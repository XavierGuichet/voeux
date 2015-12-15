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
		$VoeuxPropose = new VoeuxPropose();
				
		/*$repositoryQuestionnaire = $em->getRepository('AppBundle\Entity\Questionnaire');		
		$questionnaires = $repositoryQuestionnaire->getAllQuestionnairesComplet();*/
		
		$form = $this->createForm(VoeuxProposeType::class, $VoeuxPropose);
		$form->add('save', 'submit', array('label' => 'Envoyer'));           
		
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
			 $link = $this->container->get('router')->generate('app_frontform', array('tokenmail' => $tokenmail), true);
			 $mailcontent = array('link' => $link,
								  'token' => $tokenmail,
								  'civilite' => $civilité,
								  'mailtexte' => $VoeuxPropose->getContenuMail()->getContenuTxt()
								  );
			 
			$to = $VoeuxPropose->getPeople()->getEmail();
			if (!$this->get('mail_to_user')->sendBestWishesEmail($to,$mailcontent)) {
				throw $this->createNotFoundException('Unable to send Best Wishes mail.');
			}
                                
			$em->flush();
             
		 }
		
        return $this->render('AppBundle:Admin:index.html.twig', array(
            'form' => $form->createView()
            ));
    }
}
