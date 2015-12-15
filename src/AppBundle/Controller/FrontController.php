<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use AppBundle\Entity\Reponse;
use AppBundle\Entity\Question;
use AppBundle\Entity\Choix;
use AppBundle\Entity\Reponses;
use AppBundle\Form\Type\ReponseType;
use AppBundle\Form\Type\ReponsesType;
use AppBundle\Form\Type\QuestionType;

//use AppBundle\Form\Type\QuestionnaireType;
//use XG\PeopleBundle\Form\Type\PeopleType;
//use AppBundle\Form\Type\QuestionType;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    
    /**
     * @Route("/faites-vous-plaisir/{tokenmail}", name="app_frontform")
     */
    public function formAction($tokenmail, Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$repositoryVoeuxPropose = $em->getRepository('AppBundle\Entity\VoeuxPropose');

		$VoeuxPropose = $repositoryVoeuxPropose->getVoeuxCompletBytokenmail($tokenmail);

		if(!$VoeuxPropose) {
			return $this->indexAction($request);
		}
		//Si deja repondu renvoi vers la page merci
		if($VoeuxPropose->getIsAnswered()) {
			return $this->indexAction($request);
		}

		$reponses = new Reponses();
		$reponses->setPeople($VoeuxPropose->getPeople());
		$reponses->setQuestionnaire($VoeuxPropose->getQuestionnaire());

		$form = $this->createForm(ReponsesType::class, $reponses);	
		$form->add('save', 'submit', array('label' => 'Envoyer'));	

		$form->handleRequest($request);
		if ($form->isValid()) {
			$em->persist($reponses);
			$VoeuxPropose->setIsAnswered(1);
			$em->persist($VoeuxPropose);			
			$em->flush();
		}


		return $this->render('AppBundle:Front:form.html.twig', array(
		'form' => $form->createView()
		));
    }
}
