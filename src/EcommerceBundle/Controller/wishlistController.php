<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\Produit;
use EcommerceBundle\Entity\wishlist;
use EcommerceBundle\Form\wishlistType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class wishlistController extends Controller
{
    public function wishlistAction($id)
    {
        $wishlist = new wishlist();
        $wishlist1= $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($id);
        $wishlist->setProduit($wishlist1);

        $em= $this-> getDoctrine()->getManager();

        $tab=$em->getRepository(wishlist::class)->getWishlistByProduit($wishlist1->getId());
        if(count($tab)==0)
        {
        $em->persist($wishlist);
        $em->flush();
        }

       // echo ' <script>alert("Produit existe deja !!")</script>';
        return $this->redirectToRoute('affichewishlist');



    }

    public function affichewishlistAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $wishlist = $em->getRepository("EcommerceBundle:wishlist")->findAll();
        return $this->render('@Ecommerce/wishlist.html.twig',array('wishlist'=>$wishlist));
    }

    public function SupprimerwishlistAction($id)
    {
        $em= $this-> getDoctrine()->getManager();
        $wishlist = $em-> getRepository(wishlist::class)->find($id);
        $em-> remove($wishlist);
        $em->flush();
        return $this->redirectToRoute('affichewishlist');
    }
}
