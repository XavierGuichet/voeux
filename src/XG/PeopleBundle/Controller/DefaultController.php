<?php

namespace XG\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //return $this->render('XGPeopleBundle:Default:index.html.twig');
        $route = $this->container->get('router')->generate('app_frontpage');
        return new RedirectResponse($route);
    }
}
