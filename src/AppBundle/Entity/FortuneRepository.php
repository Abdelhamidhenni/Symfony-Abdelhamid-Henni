<?php
namespace AppBundle\Entity;
use \Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * 
 */
 class FortuneRepository extends EntityRepository
 {
 	
 	public function findLasts()
 	{
 		$queryBuilder = $this->createQueryBuilder('F')
 		->orderBy("F.createdAt","ASC");
 		return new DoctrineORMAdapter($queryBuilder);

 		
 	}

 	public function findBestRated()
 	{
 		return $this->createQueryBuilder('F')
 		->setMaxResults(1)
 		->orderBy("F.upVote / F.downVote", "DESC")
 		->getQuery()
 		->getResult();
 	}

 	public function findByAuthor($author)
 	{
 		return $this->createQueryBuilder('F')
 		->where("F.author = :author")
 		->setParameter("author", $author)
 		->getQuery()
 		->getResult();
 	}

 	public function findByQuote($id)
 	{
 		return $this->createQueryBuilder('F')
 		->where("F.id = :id")
 		->setParameter("id", $id)
 		->getQuery()
 		->getResult();
 	}

	public function findRandom() {

		 $count = $this->createQueryBuilder('r')
			 ->select('COUNT(r)')
			 ->getQuery()
			 ->getSingleScalarResult();


		 return $this->createQueryBuilder('r')
			 ->select('r.id')
			 ->setFirstResult(rand (0 , $count - 1))
			 ->setMaxResults(1)
			 ->getQuery()
			 ->getSingleScalarResult();
	 }

	public function findUnpublished() {
		 $queryBuilder = $this->createQueryBuilder('i')
			 ->where('i.published = false')
			 ->orderBy("i.createdAt","DESC");

		 return new DoctrineORMadapter($queryBuilder);
	 }
 	
 } 