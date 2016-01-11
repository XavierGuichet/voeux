<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\VoeuxPropose;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\Reponse;
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

        $form = $this->createForm(new VoeuxProposeType(), $VoeuxPropose);

        $form->handleRequest($request);
         if ($form->isValid()) {
             //Creation token present dans le lien du mail pour retrouver l'utilisateurs
             $tokenmail = md5(uniqid(null, true).date("YmdHis"));
             $VoeuxPropose->setTokenmail($tokenmail);
             $em->persist($VoeuxPropose);

             //Preparation contenu mail
             if($VoeuxPropose->getPeople()->getIsmale()) {
                 $civilite = "Cher ".$VoeuxPropose->getPeople()->getPrenom();
             }
             else {
                 $civilite = "Chère ".$VoeuxPropose->getPeople()->getPrenom();
             }
             $link = $this->container->get('router')->generate('app_front_form', array('tokenmail' => $tokenmail), true);
             $mailcontent = array('link' => $link,
                                  'token' => $tokenmail,
                                  'civilite' => $civilite,
                                  'mailtexte' => $VoeuxPropose->getContenuMail()->getContenuTxt()
                                  );

                if(preg_match('/@(freetouch\.fr|visibleo\.fr|koba\.com){1}$/',$VoeuxPropose->getEnvoyeurEmail())) {
                    $to = $VoeuxPropose->getPeople()->getEmail();
                    if (!$this->get('mail_to_user')->sendBestWishesEmail($to,$mailcontent,$VoeuxPropose->getEnvoyeurEmail())) {
                        throw $this->createNotFoundException('Unable to send Best Wishes mail.');
                    }
                    else {
                        $em->flush();
                        $form_message = "Voeux envoyées à ".$to;
                        //Nettoyage du form
                        unset($form);
                        $newVoeux = new VoeuxPropose();
                        $newVoeux->setEnvoyeurEmail($VoeuxPropose->getEnvoyeurEmail());
                        $form = $this->createForm(new VoeuxProposeType, $newVoeux);
                    }
                }
                else{ $form->get('envoyeurEmail')->addError(new FormError('Cette adresse mail n\'est pas autorisé'));}
         }

        return $this->render('AppBundle:Admin:index.html.twig', array(
            'form' => $form->createView(),
            'form_message' => $form_message
            ));
    }

    /**
     * @Route("/exportcsv", name="app_export_csv")
     */
    public function exportcsvAction() {
       $em = $this->getDoctrine()->getManager();
       $repositoryVoeux = $em->getRepository('AppBundle\Entity\VoeuxPropose');
       $repositoryReponses = $em->getRepository('AppBundle\Entity\Reponses');

       $listVoeux = $repositoryVoeux->getAllVoeuxPeople();

       $handle = fopen('php://memory', 'r+');
       $header = array();

        //Ajoute une ligne de titre au fichier
        $titlecsv = array('Expediteur','Questionnaire repondu','Société','Civilité','Nom','Prénom','Email','Adresse','Code postal','Ville','Titre questionnaire','Reponse 1','Reponse 2','Reponse 3','Reponse 4','Reponse 5');
        fputcsv($handle, $titlecsv);

        //Ajoute toutes les demandes, celles répondues d'abord
        foreach($listVoeux as $Voeux) {

            $civilite = 'Mme';
            if($Voeux->getPeople()->getIsmale()){
                $civilite = 'M.';
            }

            $identification = array($Voeux->getEnvoyeurEmail(),
                             $Voeux->getIsAnswered(),
                             $Voeux->getPeople()->getSociete(),
                             $civilite,
                             $Voeux->getPeople()->getNom(),
                             $Voeux->getPeople()->getPrenom(),
                             $Voeux->getPeople()->getEmail(),
                             $Voeux->getPeople()->getAdresse(),
                             $Voeux->getPeople()->getCodepostal(),
                             $Voeux->getPeople()->getVille(),
                             $Voeux->getQuestionnaire()->getTitre(),
                             );

            $reponses = array();
            if($Voeux->getIsAnswered()) {
                $reponse = $repositoryReponses->getReponseByPeopleId($Voeux->getPeople()->getId());
                foreach($reponse->getListreponses() as $reponse_item) {
                    if(is_a($reponse_item,"AppBundle\Entity\Reponse") && !is_null($reponse_item->getChoix())) {
                      $reponses[] = $reponse_item->getChoix()->getTitre();
                    }
                    else {
                      $reponses[] = '';
                      $ligne_pb[] = array($identification,$reponse_item);
                    }
                }
            }
            $lignecsv = array_merge ($identification,$reponses);
            fputcsv($handle, $lignecsv);
        }



        /*if(isset($ligne_pb)) {
          dump($ligne_pb);
          $response = new Response();
          $response->setStatusCode(500);
          return $response;
        }*/

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return new Response($content, 200, array(
            'Content-Type' => 'application/force-download',
            'Content-Disposition' => 'attachment; filename="export.csv"'
        ));

    }
}
