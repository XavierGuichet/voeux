<?php
//src/AppBundle/Form/Type/ReponseType.php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Reponse;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {												
		$builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
        $reponse = $event->getData();	
        $form = $event->getForm();
        
        $form->add("choix",EntityType::class, array(
														'class' => 'AppBundle:Choix',
														'choice_label' => function($choix) {
																return $choix->getTitre();
															},
														'choices' => $reponse->getQuestion()->getChoixs(),
														'expanded' => true,
														'multiple' => false
														)
													);
		});										
    }

	
    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reponse',
        ));
    }
}
