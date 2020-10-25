<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Commande;
use EcommerceBundle\Entity\panier;
use EcommerceBundle\Entity\ProduitVendu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommandeController extends Controller
{
    public function createAction()
    {
        $commande= new Commande();
        //recuperer id avec fosuser
        //$client=$em->...->find($id);
        //$commande->setClient(NULL);
        $commande->setTotal('360');
        $commande->setDate(new \DateTime('now'));

        $em=$this->getDoctrine()->getManager();
        $em->persist($commande);

        $tab=$em->getRepository(panier::class)->findAll();

        //changer findall by find personalisee pour cherche les paniers du client connecte

        if(count($tab)!=0) {
            foreach ($tab as $row) {
                $prod= new ProduitVendu();
                $prod->setCommande($commande);
                $prod->setNom($row->getProduit()->getNom());
                $prod->setPrix($row->getProduit()->getPrix());
                $em->persist($prod);
                $em->remove($row);

            }
            $em->flush();
        }


        return $this->redirectToRoute('commande');

    }

    public function commandeAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $panier = $em->getRepository("EcommerceBundle:ProduitVendu")->findAll();
        return $this->render('@Ecommerce/commande.html.twig',array('commande'=>$panier));
    }


}
