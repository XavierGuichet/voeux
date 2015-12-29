<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;

use AppBundle\Entity\VoeuxPropose;
use AppBundle\Entity\Questionnaire;
use AppBundle\Entity\ContenuMail;
use XG\PeopleBundle\Entity\People;

class ImportController extends Controller
{
    private $listQuestionnaire;
    private $listContenu;

    /**
     * @Route("/import/upload", name="app_import_csv_file_upload")
     */
    public function uploadAction()
    {
      $form = $this->getImportForm();

      return $this->render('AppBundle:Import:upload.html.twig', array(
          'form' => $form->createView()
          ));
    }

    /**
     * @Route("/import/verification", name="app_import_csv_file_upload")
     */
    public function check_validityAction(Request $request) {
      $table = array();
      $form_message = "";
      $file_integrity = "";
      $em = $this->getDoctrine()->getManager();
      $repositoryQuestionnaire = $em->getRepository('AppBundle\Entity\Questionnaire');
      $repositoryContenuMail = $em->getRepository('AppBundle\Entity\ContenuMail');
  		$this->listQuestionnaire = $repositoryQuestionnaire->findAll();
  		$this->listContenu = $repositoryContenuMail->findAll();

      $validator = $this->get('validator');


      $form = $this->getImportForm();
      $form->handleRequest($request);
      
      $formImportedCsvData = $form->get('importedcsv')->getData();
      
      if ($form->isValid() && !empty($formImportedCsvData)) {
        $file = $form->get('importedcsv')->getData();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $uploadDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/csv/';
        $file->move($uploadDir, $fileName);
        $filepath = $uploadDir.$fileName;
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();
        $objPHPExcel = \PHPExcel_IOFactory::load($filepath);

        $row_count = 0;
        $error_count = 0;
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
          foreach ($worksheet->getRowIterator() as $row) {
            $row_count++;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $VoeuxPropose = new VoeuxPropose();
            $VoeuxPropose = $this->CsvRowToVoeuxObject($cellIterator);
            if($VoeuxPropose !== false) {
              if($VoeuxPropose !== "Bad cell count") {
                $errors = $validator->validate($VoeuxPropose);
                if (count($errors) > 0) {
                  $error_count++;
                  $table[$row_count]["errors"] = $errors;
                  $table[$row_count]["VoeuxPropose"] = $VoeuxPropose;
                }
                elseif(!preg_match('/@(freetouch\.fr|visibleo\.fr|koba\.com){1}$/',$VoeuxPropose->getEnvoyeurEmail())) {
                  $error_count++;
                  $table[$row_count]["errors"][]["message"] = "L'adresse mail de l'expéditeur n'est pas autorisé";
                  $table[$row_count]["VoeuxPropose"] = $VoeuxPropose;
                }
                else {
                  $table[$row_count]["VoeuxPropose"] = $VoeuxPropose;
                }
              }
              else {
                $error_count++;
                $table[$row_count]["errors"][]["message"] = "Cette ligne contient un ou plusieurs champs vide. Elle n'a pas pu être gérée.";
              }
            }
          }
        }
        
        if($row_count > 30){
            $error_count++;
            $file_integrity = "Votre fichier dépasse la limite de 30 lignes (total trouvé : ".$row_count."). Il faut séparer la liste en plusieurs fichiers.";
        }

        if ($form->get('check_and_send')->isClicked() && $error_count == 0) {
          foreach($table as $row) {
            $curVoeuxPropose = $row["VoeuxPropose"];            
            $tokenmail = md5(uniqid(null, true).date("YmdHis"));
            $curVoeuxPropose->setTokenmail($tokenmail);

            //Preparation contenu mail
            if($curVoeuxPropose->getPeople()->getIsmale()) {
                $civilité = "Cher ".$curVoeuxPropose->getPeople()->getPrenom();
            }
            else {
                $civilité = "Chère ".$curVoeuxPropose->getPeople()->getPrenom();
            }
            $link = $this->container->get('router')->generate('app_front_form', array('tokenmail' => $tokenmail), true);
            $mailcontent = array('link' => $link,
                                 'token' => $tokenmail,
                                 'civilite' => $civilité,
                                 'mailtexte' => $curVoeuxPropose->getContenuMail()->getContenuTxt()
                                 );

            if(preg_match('/@(freetouch\.fr|visibleo\.fr|koba\.com){1}$/',$curVoeuxPropose->getEnvoyeurEmail())) {
                $to = $curVoeuxPropose->getPeople()->getEmail();
                if (!$this->get('mail_to_user')->sendBestWishesEmail($to,$mailcontent,$curVoeuxPropose->getEnvoyeurEmail())) {
                    throw $this->createNotFoundException('Unable to send Best Wishes mail.');
                }
            }
            $em->persist($curVoeuxPropose); 
            $em->flush();
          }
          $form_message = "Soumission réussie";
          /*
            SET FOREIGN_KEY_CHECKS = 0;
            TRUNCATE people;
            TRUNCATE reponse;
            TRUNCATE reponses;
            TRUNCATE voeux_propose;
            SET FOREIGN_KEY_CHECKS = 1;
           */
        }
      }

      return $this->render('AppBundle:Import:checkvalidity.html.twig', array(
        'form' => $form->createView(),
        'table_check' => $table,
        'form_message' => $form_message,
        'file_integrity' => $file_integrity
      ));
    }

    /**
     * Retourne le formulaire d'upload de fichiers
     */
    private function getImportForm() {
      return $this->createFormBuilder()
                   ->setAction($this->generateUrl('app_import_csv_check_validity'))
                   ->add('importedcsv', new FileType(), array('label' => 'Votre fichier', 'constraints' => array(
                     new NotBlank(),
                    ),))
                   ->add('check', 'submit', array('label' => 'Vérifier'))
                   ->add('check_and_send', 'submit', array('label' => 'Vérifier et envoyer les voeux'))
                   ->getForm();
    }

    /**
     * Converti une ligne de cellule en objet VoeuxPropose
     */
    private function CsvRowToVoeuxObject($cellIterator) {
      //$em = $this->getDoctrine()->getManager();
      $row = array();
      foreach ($cellIterator as $cell) {
              if (!is_null($cell) && !is_null($cell->getCalculatedValue())) {
                if(is_numeric($cell->getCalculatedValue())) {
                  $row[] = (int) $cell->getCalculatedValue();
                }
                else {
                $row[] = trim($cell->getCalculatedValue());
                }
              }
      }
      if(count($row) == 0) { return false;}
      if(count($row) != 11) { return "Bad cell count";}
      if($row[0] == "Raison Sociale") { return false;}

      $VoeuxPropose = new VoeuxPropose();
      $Questionnaire = new Questionnaire();
      $People = new People();
      $ContenuMail = new ContenuMail();

      $People->setSociete($row[0]);
      $People->setAdresse($row[1]);
      $People->setCodepostal($row[2]);
      $People->setVille($row[3]);
      $People->setNom($row[4]);
      $People->setPrenom($row[5]);
      $People->setEmail($row[6]);
      $People->setIsmale($row[7]);

      //$em->persist($People);
      $contenumail = $this->listContenu[$row[8] - 1];
      $questionnaire = $this->listQuestionnaire[$row[9] - 1];

      $VoeuxPropose->setQuestionnaire($questionnaire);
      $VoeuxPropose->setPeople($People);
      $VoeuxPropose->setContenuMail($contenumail);
      $VoeuxPropose->setEnvoyeurEmail($row[10]);
      //$em->persist($VoeuxPropose);
      return $VoeuxPropose;
    }
}
