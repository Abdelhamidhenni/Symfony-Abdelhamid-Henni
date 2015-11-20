<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType {

	public function getName()
	{
		return "Comment";
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('author')
		->add('content')
		->add('submit', 'submit');
	}
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'AppBundle\Entity\comment'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'appbundle_comment';
	}
}