<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Fortune;
use AppBundle\Form\FortuneType;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Comment;
use Pagerfanta\Pagerfanta;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $fortunes = new Pagerfanta($this->getDoctrine()->getRepository("AppBundle:Fortune")->findLasts());
        $fortunes->setMaxPerPage(1);

        $fortunes->setCurrentPage($request->get("page",1));
               //replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'fortunes'=>$fortunes
        ));     
    }

     /**
     * @Route("/vote_up/{id}", name="vote_up")
     */
     public function setVoteUp($id)
    {     
       if ($this->get('session')->get($id)){
       return $this->redirectToRoute("create");

       } 
       $this->get('session')->set($id, "value");
       $this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id)->voteUp();
       $this->getDoctrine()->getManager()->flush();         
       return $this->redirectToRoute("punchline");
    }


    /**
     * @Route("/vote_down/{id}", name="vote_down")
     */
     public function setVoteDown($id)
    {     
        if ($this->get('session')->get($id)){
       return $this->redirectToRoute("create");
       }
       $this->get('session')->set($id, "value");
       $this->getDoctrine()->getRepository("AppBundle:Fortune")->find($id)->voteDown();
       $this->getDoctrine()->getManager()->flush();
       return $this->redirectToRoute("punchline");
    }

    /**
     * @Route("/bestpunchline", name="punchline")
     */
    public function showBestRatedAction()
    {
        return $this->render('default/showBestRated.html.twig', array (
            'fortunes'=>$this->getDoctrine()->getRepository("AppBundle:Fortune")->findBestRated()
            ));
    }




    /**
     * @Route("/by_author/{author}", name="author")
     */
    public function showByAuthorAction($author)
    {
        return $this->render('default/showByAuthor.html.twig', array (
            'fortunes'=>$this->getDoctrine()->getRepository("AppBundle:Fortune")->findByAuthor($author)
            ));
    }

    /**
     * @Route("/new", name="create")
     */
    public function createAction(Request $request)
    {

        $form = $this->createForm(new FortuneType, new Fortune);
      
        $form ->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $quote=$form->getData();
            $em->persist($form->getData());
            $em->flush();
            
            return $this->redirectToRoute('quote', array ('id'=>$quote->getId()));
        }
        return $this->render('default/create.html.twig', array (
            'form'=>$form->createView()
            ));
    }

    /**
     * @Route("/quote/{id}", name="quote")
     */
    public function showOneQuoteAction(Fortune $fortune, $id, Request $request)
    {
         $form = $this->createForm(new CommentType, new Comment);

          $form ->handleRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $comment = $form->getData();
                $comment->setFortune($fortune);

                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('quote', array ('id'=>$fortune->getId()));
            }
       return $this->render('default/showByQuote.html.twig', array (
            'fortunes'=>$this->getDoctrine()->getRepository("AppBundle:Fortune")->findByQuote($id),
             'form'=>$form->createView()
            ));
    }

    

}
