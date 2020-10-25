<?php

namespace EcommerceBundle\Controller;

use EcommerceBundle\Entity\categorie;
use EcommerceBundle\Entity\Commentaire;
use EcommerceBundle\Entity\Produit;
use EcommerceBundle\Form\categorieType;
use EcommerceBundle\Form\CommentaireType;
use EcommerceBundle\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ProduitController extends Controller
{
    public function AjoutproduitAction(Request $request)
    {

        $produit = new Produit();
        $form = $this->createForm(ProduitType::class,$produit);
        $form -> handleRequest($request);

        if ($form->isSubmitted())
        {
            $file = $form ['image']->getData();

            $newAssetName = $file->getClientOriginalName();

            $file->move($this->getParameter('assets_directory'), $newAssetName);

            $produit->setImage($newAssetName);

            dump($file);

            dump($produit);
            $em= $this-> getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('afficheproduit');
        }

        return $this->render('@Ecommerce/Produit/AjoutProduit.html.twig',array('form'=>$form->createView(),'produit' => $produit));
    }

    public function AfficheproduitAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $produit = $em->getRepository("EcommerceBundle:Produit")->findAll();
        return $this->render('@Ecommerce/Produit/AfficheProduit.html.twig',array('produit'=>$produit));
    }

    public function SuppproduitAction($id)
    {
        $em= $this-> getDoctrine()->getManager();
        $produit = $em-> getRepository(Produit::class)->find($id);
        $em-> remove($produit);
        $em->flush();
        return $this->redirectToRoute('afficheproduit');
    }

    public function ModifproduitAction(Request $request,$id)
    {
        $produit= $this->getDoctrine()->getRepository(Produit::class)->find($id);
        $form= $this->createForm(ProduitType::class,$produit);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $file = $form ['image']->getData();

            $newAssetName = $file->getClientOriginalName();

            $file->move($this->getParameter('assets_directory'), $newAssetName);

            $produit->setImage($newAssetName);

            dump($file);

            dump($produit);
            $ef= $this->getDoctrine()->getManager();
            $ef->persist($produit);
            $ef->flush();

            return $this->redirectToRoute("afficheproduit");
        }
        return $this->render("@Ecommerce/Produit/ModifierProduit.html.twig", array('form'=>$form->createView(),'produit' => $produit));
    }


    public function backAction()
    {
        return $this->render('@Ecommerce/back.html.twig');
    }
    public function frontAction()
    {
        return $this->render('@Ecommerce/front.html.twig');
    }


    public function AfficheproduitfrontAction()
    {
        $em= $this-> getDoctrine()->getManager();
        $produit = $em->getRepository("EcommerceBundle:Produit")->findAll();
        return $this->render('@Ecommerce/AfficheProduitFront.html.twig',array('produit'=>$produit));
    }

    public function detailProdAction(Request $request, Produit $prod)
    {
        $commentaire = new Commentaire();
        $em= $this-> getDoctrine()->getManager();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted()) {
            $commentaire->setProduit($prod);
            //$commantaire->setUser($this->getUser());
            $commentaire->setDate(new \DateTime('now'));
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('detailproduitfront', array('id'=>$prod->getId()));
        }
        $comments = $em->getRepository(Commentaire::class)->findBy(['produit' => $prod]);
        $produit = $this->getDoctrine()->getRepository(Produit::class)->find($prod->getId());
        return $this->render('@Ecommerce/detailProd.html.twig',array(
            'produit'=>$produit,
            'commentaire' => $commentaire,
            'comments' => $comments,
            'form' => $form->createView(),
        ));
    }

    public function produitparcatAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('EcommerceBundle:Produit');
        $produits = $categoryRepository->produitparcategorie($id);

        return $this->render('@Ecommerce/produitparcat.html.twig',array('produit'=>$produits));
    }
}
