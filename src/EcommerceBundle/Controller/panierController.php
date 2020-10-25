<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\panier;
use EcommerceBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class panierController extends Controller
{
    public function addPanierAction($id,SessionInterface $session)
    {
        $panier = new panier();
        $panier1= $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id);
        $panier->setProduit($panier1);
        $panier->setQuantite('1');

        $em= $this-> getDoctrine()->getManager();

        $tab=$em->getRepository(panier::class)->getPanierProduit($panier1->getId());
        if(count($tab)==0)
        {
            $em->persist($panier);
            $em->flush();
        }

        return $this->redirectToRoute('indexPanier');
    }

    public function panierAction(){
        $em= $this-> getDoctrine()->getManager();
        $panier = $em->getRepository("EcommerceBundle:panier")->findAll();
        return $this->render('@Ecommerce/shopping-card.html.twig',array('panier'=>$panier));
    }

    public function removeAction($id,SessionInterface $session)
    {
        $em= $this-> getDoctrine()->getManager();
        $panier = $em-> getRepository(panier::class)->find($id);
        $em-> remove($panier);
        $em->flush();
        return $this->redirectToRoute('indexPanier');

    }
}
