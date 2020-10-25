<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\categorie;
use EcommerceBundle\Form\categorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;

class CategorieController extends Controller
{
    public function AjoutcategorieAction(Request $request)
    {
        $categorie = new categorie();
        $form = $this->createForm(categorieType::class,$categorie);
        $form -> handleRequest($request);

        if ($form->isSubmitted())
        {
            $em= $this-> getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('affichecategorie');
        }

        return $this->render('@Ecommerce/Categorie/AjoutCat.html.twig',array('form'=>$form->createView(),'categorie' => $categorie));
    }

    public function AffichecategorieAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $categorie = $em->getRepository("EcommerceBundle:categorie")->findAll();
        return $this->render('@Ecommerce/Categorie/AfficheCat.html.twig',array('categorie'=>$categorie));
    }


    public function SuppcategorieAction($id)
    {
        $em= $this-> getDoctrine()->getManager();
        $categorie = $em-> getRepository(categorie::class)->find($id);
        $em-> remove($categorie);
        $em->flush();
        return $this->redirectToRoute('affichecategorie');
    }

    public function ModifcategorieAction(Request $request,$id)
    {
        $categorie= $this->getDoctrine()->getRepository(categorie::class)->find($id);
        $form= $this->createForm(categorieType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
        $ef= $this->getDoctrine()->getManager();
        $ef->persist($categorie);
        $ef->flush();

        return $this->redirectToRoute("affichecategorie");
    }
        return $this->render("@Ecommerce/Categorie/ModifierCat.html.twig", array('form'=>$form->createView(),'categorie' => $categorie));
    }

    public function AfficheCategorieFrontAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $categorie = $em->getRepository("EcommerceBundle:categorie")->findAll();
        return $this->render('@Ecommerce/AfficheCategorieFront.html.twig',array('categorie'=>$categorie));
    }


}
