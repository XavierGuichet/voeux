<?php
//src/AppBundle/Form/Type/ReponseType.php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\Type\ReponseType;
use XG\PeopleBundle\Form\Type\PeopleType;

class ReponsesType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {			
		$builder->add('people',new PeopleType(),array('displayall' => false));
		
		$t = $options["data"]->getListreponses();
		$builder->add('listreponses', new CollectionType(), array(
                    'entry_type'   => new ReponseType()										
                    )
                );
    }

	
    public function configureOptions(OptionsResolver $resolver)
    {
		$resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reponses',
        ));
    }
}
