<?php

namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FortuneType extends AbstractType {

	public function getName()
	{
		return "Fortune";
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('title')
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
			'data_class' => 'AppBundle\Entity\Quote'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'appbundle_quote';
	}
}