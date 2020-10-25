<?php

namespace FormationsBundle\Controller;

use http\Client\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FormationsBundle\Entity\Commentaire;
use FormationsBundle\Entity\cour;
use FormationsBundle\Form\CommentaireType;

class CommentaireController extends Controller
{



    /**
     * Finds and displays a commentaire entity.
     *
     * @Route("/commentairee/{cour_id}", name="commentaire_new")
     * @Method({"GET", "POST"})
     *
     **/
    public function newComAction(\Symfony\Component\HttpFoundation\Request $request, Cour $cour)
    {
        $commentaire = new Commentaire();
        $em = $this->getDoctrine()->getManager();
        $commentaire->setNbinutile(0);
        $commentaire->setDateComm(new \DateTime());
        $cour=$em->getRepository("FormationsBundle:cour")->find($cour);
        $form = $this->createForm(CommentaireType::class,$commentaire);
        $cour->setNoteCour($commentaire->getRatingComm()+$cour->getNoteCour());
        $this->getDoctrine()->getManager()->flush();
$form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setCour($cour);
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('commentaire_show', array('id' => $cour->getCourId()) );
        }
        return ($this->render('@Formations/cour/newcomm.html.twig',array('form_comment' => $form->createView(),'cour' => $cour)));

    }
}
