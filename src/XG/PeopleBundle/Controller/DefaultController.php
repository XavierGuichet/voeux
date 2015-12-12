<?php

namespace XG\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('XGPeopleBundle:Default:index.html.twig');
    }
}
