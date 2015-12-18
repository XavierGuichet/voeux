<?php
//src/XG/PeopleBundle/Form/Type/PeopleType.php

namespace XG\PeopleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PeopleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('societe')
				->add('nom')
				->add('prenom')
				->add('adresse')
				->add('codepostal')
				->add('ville');
				
		if($options['displayall']) {
		$builder->add('ismale',new ChoiceType(),array(
							'placeholder' => false,
							'choices' => array('Madame' => false, 'Monsieur' => true),
							'choices_as_values' => true,
							'expanded' => true,
							'multiple' => false ))
				->add('email');
		}
    }

	
    public function configureOptions(OptionsResolver $resolver)
    {		
        $resolver->setDefaults(array(
            'data_class' => 'XG\PeopleBundle\Entity\People',
            'displayall' => true
        ));
    }
}
