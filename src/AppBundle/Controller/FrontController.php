<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use AppBundle\Entity\Reponses;
use AppBundle\Form\Type\ReponsesType;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $route = $this->container->get('router')->generate('app_front_merci');
			return new RedirectResponse($route);
    }
    
    /**
     * @Route("/faites-vous-plaisir/{tokenmail}", name="app_front_form")
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
		if($VoeuxPropose->getIsAnswered() == true) {
			$route = $this->container->get('router')->generate('app_front_merci');
			return new RedirectResponse($route);
		}

		$reponses = new Reponses();
		$reponses->setPeople($VoeuxPropose->getPeople());
		$reponses->setQuestionnaire($VoeuxPropose->getQuestionnaire());

		$form = $this->createForm(new ReponsesType(), $reponses);	
		$form->add('save', 'submit', array('label' => 'Envoyer'));	

		$form->handleRequest($request);
		if ($form->isValid()) {
			$em->persist($reponses);
			$VoeuxPropose->setIsAnswered(true);
			$em->persist($VoeuxPropose);			
			$em->flush();
			$route = $this->container->get('router')->generate('app_front_merci');
			return new RedirectResponse($route);
		}

		return $this->render('AppBundle:Front:form.html.twig', array(
		'form' => $form->createView()
		));
    }
    
    /**
     * @Route("/merci", name="app_front_merci")
     */
    public function merciAction()
    {
		return $this->render('AppBundle:Front:merci.html.twig');
	}
}
