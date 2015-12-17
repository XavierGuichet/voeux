<?php
//src/AppBundle/Form/Type/VoeuxProposeType.php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;

use XG\PeopleBundle\Form\Type\PeopleType;

class VoeuxProposeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {	
		$builder->add('envoyeurNom');
		$builder->add('envoyeurPrenom');
		$builder->add('envoyeurEmail',EmailType::class);
		 $builder->add('people', PeopleType::class);
		 $builder->add('questionnaire',EntityType::class, array(
														'class' => 'AppBundle:Questionnaire',
														'choice_label' => function($questionnaire) {
															return displayQuestions($questionnaire);
															},
														'query_builder' => function(\AppBundle\Repository\QuestionnaireRepository $er) { 
															return $er->getSelectList();
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
		$builder->add('save', 'submit', array('label' => 'Envoyer'));
    }

	
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\VoeuxPropose',
            'em' => null
        ));
    }
}

function displayQuestions(\AppBundle\Entity\Questionnaire $questionnaire) {
	$str = "";
	foreach($questionnaire->getQuestions() as $linkquestion) {
		$size = count($linkquestion->getQuestion()->getChoixs()) - 1;
		$str .= "<p class='choix__item'>";
		foreach($linkquestion->getQuestion()->getChoixs() as $key => $choix) {
			$str .= $choix->getTitre();
			if($key < $size) {
				$str .= " / ";
			}
		}
		$str .= "</p>";
	}
	return $str;
}
