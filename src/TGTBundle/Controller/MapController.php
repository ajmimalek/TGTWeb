<?php


namespace TGTBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MapController extends Controller
{
    public function indexAction()
    {
        return $this->render('@TGT/front/Events/showEvents.html.twig');
    }

}
