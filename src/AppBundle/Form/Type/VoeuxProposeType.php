<?php
//src/AppBundle/Form/Type/VoeuxProposeType.php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use XG\PeopleBundle\Form\Type\PeopleType;

class VoeuxProposeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
		 $builder->add('people', PeopleType::class);
		 $builder->add('questionnaire',EntityType::class, array(
														'class' => 'AppBundle:Questionnaire',
														'choice_label' => function($questionnaire) {
															return displayQuestions($questionnaire);
															},
														'expanded' => true,
														'multiple' => false
														)
							);
		 $builder->add('ContenuMail',EntityType::class, array(
														'class' => 'AppBundle:ContenuMail',
														'choice_label' => 'contenuTxt',
														'expanded' => true,
														'multiple' => false
														)
							);
    }

	
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VoeuxPropose',
        ));
    }
}

function displayQuestions(\AppBundle\Entity\Questionnaire $questionnaire) {
	//How / WHere to retrieve  list properly.
	return $questionnaire->getTitre()."<br/>test / toast";
}
