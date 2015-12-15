<?php

namespace AppBundle\Services;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Assetic\Exception\Exception;


class MailToUser {

    protected $mailer;
    protected $router;
    protected $templating;
    protected $app_front_url;
    protected $kernel;
    private $from = "voeux@koba.fr";
    private $reply = "voeux@koba.fr";
    private $name = "Koba Global Services";

    public function __construct($mailer, EngineInterface $templating, RouterInterface $router, $app_front_url, $kernel) {
        $this->mailer = $mailer;
        $this->router = $router;
        $this->templating = $templating;
        $this->app_front_url = $app_front_url;
        $this->kernel = $kernel;
    }
       
    public function sendBestWishesEmail($to,$mailcontent){
        $view = null;
        $view = $this->templating->render('AppBundle:Mailing:BestWishes.html.twig', $mailcontent);
        if (!$view)
            return false;
        
        // sujet
        $subject = "Faîtes vous plaisir";
        
        return $this->sendMail($subject, $view, $to);
    }
    
    private function sendMail($subject, $view, $to){
                
        //$view = $this->createOnlineVersion($view);
        
        // pour utiliser la fonction php mail à la place du smtp
        //$transport = \Swift_MailTransport::newInstance();
        //$this->mailer = \Swift_Mailer::newInstance($transport);
        
        $mail = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->from, $this->name)
                ->setBody($view)
                ->setReplyTo($this->reply, $this->name)
                ->setContentType('text/html');
        
        try {
            $mail->setTo($to);
            $this->mailer->send($mail);
        } catch (Exception $exc) {
            return false;
        }

        return true;
    }
    
    private function createOnlineVersion($view){        
        $filename = md5(uniqid(null, true).date("YmdHis"));
        $filenameWithExt = $filename.".dat";
        
        // variables dynamiques
        $lien_version_online = $this->app_front_url.$this->router->generate('front_online_version', array('type' => 'mail', 'hash' => $filename));
        $newView = str_replace('#LIEN_ONLINE#',$lien_version_online, $view);        
        
        // traitement du fichier justificatif
        $dir=$this->kernel->getRootDir()."/../web/".$this->kernel->getContainer()->getParameter('online_mail_dir');

        if (!is_dir($dir)) { mkdir($dir); }
        
        file_put_contents($dir.$filenameWithExt, $newView);
        
        return $newView;
    }
}
