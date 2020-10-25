<?php

namespace TGTBundle\Controller;

use TGTBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Form\CandidatType;

/**
 * Candidat controller.
 *
 * @Route("candidat")
 */
class CandidatController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository('TGTBundle:Candidat')->findAll();

        return $this->render('@TGT/Candidat/indexCandidat.html.twig', array(
            'candidats' => $candidats,
        ));
    }
    public function newAction(Request $request)
    {
        $candidats= new Candidat();
        $form = $this->createForm(CandidatType::class,$candidats);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()){

            $file = $form ['cv']->getData();


            $newFileName = $file->getClientOriginalName();

            $file->move($this->getParameter('files_directory'), $newFileName);

            $candidats->setcv($newFileName);



            dump($file);

            dump($candidats);
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidats);
            $em->flush();
            return $this->redirectToRoute('candidat_show');
        }

        return ($this->render('@TGT/Candidat/newCandidat.html.twig',array("form"=> $form->createView())));
    }
    #public function newAction(Request $request)
    #{
     #   $candidat = new Candidat();
      #  $form = $this->createForm('TGTBundle\Form\CandidatType', $candidat);
       # $form->handleRequest($request);

        #if ($form->isSubmitted() && $form->isValid()) {
         #   $em = $this->getDoctrine()->getManager();
          #  $em->persist($candidat);
           # $em->flush();

            #return $this->redirectToRoute('candidat_show', array('id' => $candidat->getId()));
        #}

        #return $this->render('@TGT/Candidat/newCandidat.html.twig', array(
         #   'candidat' => $candidat,
          #  'form' => $form->createView(),
        #));
    #}

    public function showAction(Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);

        return $this->render('@TGT/Candidat/showCandidat.html.twig', array(
            'candidat' => $candidat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);
        $editForm = $this->createForm('TGTBundle\Form\CandidatType', $candidat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidat_show', array('id' => $candidat->getId()));
        }

        return $this->render('@TGT/Candidat/editCandidat.html.twig', array(
            'candidat' => $candidat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $candidat= $em->getRepository(Candidat::class)->find($id);

        $em->remove($candidat);

        $em->flush();

        return $this->redirectToRoute("candidat_show");
    }

    /**
     * Creates a form to delete a candidat entity.
     *
     * @param Candidat $candidat The candidat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidat_delete', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
