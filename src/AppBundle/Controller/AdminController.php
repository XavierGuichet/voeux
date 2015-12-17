<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\VoeuxPropose;
use AppBundle\Entity\Questionnaire;
use XG\PeopleBundle\Entity\People;

use AppBundle\Form\Type\VoeuxProposeType;

class AdminController extends Controller
{
	/**
     * @Route("/sendbestwishesbykoba", name="app_sendbestwishes")
     */
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$form_message = "";
		$VoeuxPropose = new VoeuxPropose();
		
		$form = $this->createForm(VoeuxProposeType::class, $VoeuxPropose);
		
		$form->handleRequest($request);
         if ($form->isValid()) {
			 //Creation token present dans le lien du mail pour retrouver l'utilisateurs
			 $tokenmail = md5(uniqid(null, true).date("YmdHis"));
			 $VoeuxPropose->setTokenmail($tokenmail);
			 $em->persist($VoeuxPropose);
			 
			 //Preparation contenu mail
			 if($VoeuxPropose->getPeople()->getIsmale()) {
				 $civilité = "Cher ".$VoeuxPropose->getPeople()->getPrenom();				 
			 }
			 else {
				 $civilité = "Chère ".$VoeuxPropose->getPeople()->getPrenom();
			 }
			 $link = $this->container->get('router')->generate('app_front_form', array('tokenmail' => $tokenmail), true);
			 $mailcontent = array('link' => $link,
								  'token' => $tokenmail,
								  'civilite' => $civilité,
								  'mailtexte' => $VoeuxPropose->getContenuMail()->getContenuTxt()
								  );
			 
			$to = $VoeuxPropose->getPeople()->getEmail();
			if (!$this->get('mail_to_user')->sendBestWishesEmail($to,$mailcontent,$VoeuxPropose->getEnvoyeurEmail())) {
				throw $this->createNotFoundException('Unable to send Best Wishes mail.');
			}
			else {                                
				//$em->flush();			
				$form_message = "Voeux envoyées à ".$to;
				//Nettoyage du form
				//unset($form);
				//$form = $this->createForm(VoeuxProposeType::class, new VoeuxPropose());
			}
		 }
		
        return $this->render('AppBundle:Admin:index.html.twig', array(
            'form' => $form->createView(),
            'form_message' => $form_message
            ));
    }
}
