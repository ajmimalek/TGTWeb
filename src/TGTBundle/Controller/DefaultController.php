<?php

namespace TGTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TGTBundle:Default:index.html.twig');
    }
}
