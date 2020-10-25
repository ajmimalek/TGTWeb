<?php

namespace FormationsBundle\Controller;

use FormationsBundle\Entity\Candidat;
use FormationsBundle\Entity\participer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FormationsBundle\Entity\Casting;
use FormationsBundle\Entity\Events;
use FormationsBundle\Entity\formation;
use FormationsBundle\Entity\Organisations;
use FormationsBundle\Form\CandidatType;
use FormationsBundle\Form\CastingType;
use FormationsBundle\Form\EventsType;
use FormationsBundle\Form\OrganisationsType;

/**
 * Back controller.
 *
 * @Route("candidat")
 */
class BackController extends Controller
{

    public function indexFormationAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('FormationsBundle:formation')->findAll();
        return $this->render('@Formations/back/formation/indexFormation.html.twig', array('formations' => $formations));
    }


    public function editFormationAction(Request $request, formation $formation)
    {
        $editForm = $this->createForm('FormationsBundle\Form\formationType', $formation);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('back_EditFormation', array('id' => $formation->getFormationId()));
        }
        return $this->render('@Formations/back/formation/editFormation.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
        ));
    }




    public function deleteFormationAction($formation_id)
    {
        $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->find($formation_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('back_DeleteFormation', array('id' => $formation->getFormationId()));
    }


    public function newFormationAction(Request $request)
    {
        $formation = new Formation();
        $form = $this->createForm('FormationsBundle\Form\formationType', $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form ['image']->getData();

            $newAssetName = $file->getClientOriginalName();

            $file->move($this->getParameter('assets_directory'), $newAssetName);

            $formation->setImage($newAssetName);
            $formation->setDureeFormation(0);
            dump($file);

            dump($formation);
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('back_AddFormation');

        }

        return $this->render('@Formations/back/formation/addFormation.html.twig', array(
            'formation' => $formation,
            'form' => $form->createView(),
        ));
    }
}


