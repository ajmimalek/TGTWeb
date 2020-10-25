<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function TrierAction(Request $request)
    {
        $em=$this->get('doctrine.orm.entity_manager');
        $val = $request->get('val');
        if ($val === 'Date') {
            $em = $this->getDoctrine()->getManager();
            $comments = $em->getRepository('EcommerceBundle:Commentaire')->trierDate();
        }
        return $this->render('@Ecommerce/statistiques/CommentaireTrie.html.twig', ['comments'=>$comments]);
    }
}
