<?php

namespace FormationsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FormationsBundle\Entity\CategorieFormation;
use FormationsBundle\Entity\cour;
use FormationsBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use FormationsBundle\Entity\formation;

/**
 * Cour controller.
 *
 * @Route("cour")
 */
class courController extends Controller
{
    //*********************************************************************************************************
    #*******************************************************

    /**
     * Creates a new cour entity.
     *
     * @Route("/newC", name="courr_new")
     * @Method({"GET", "POST"})
     */
    public function newCAction(Request $request)
    {

        $cour = new Cour();
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository(formation::class)->find($request->get('formationId'));
        if (empty($formations)){
            return new JsonResponse(['message' => 'Formation non trouvée'], Response::HTTP_NOT_FOUND);
        }
        $cour->setFormations($formations);
        $cour->setTitreCour($request->get('titreCour'));
        $cour->setDescriptionCour($request->get('descriptionCour'));
        $cour->setDureeCour($request->get('dureeCour'));
        $cour->setNoteCour($request->get('noteCour'));
        $cour->setTextCour($request->get('textCour'));
        $cour->setImage($request->get('image'));

        $em->persist($cour);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cour);
        return new JsonResponse($formatted);
    }

#************************************************

    /**
     * Lists all formation entities.
     *
     * @Route("/allC", name="allC")
     * @Method("GET")
     */
    Public function allAction()
    {
        $tasks = $this ->getDoctrine()->getManager()
            ->getRepository('FormationsBundle:cour')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    #**************************************************
    /**
     * Displays a form to edit an existing cour entity.
     *
     * @Route("/{cour_id}/editC", name="courr_edit")
     * @Method({"GET", "POST"})
     */
    public function editCAction(Request $request, Cour $cour)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(formation::class)->find($request->get('formation_id'));
        $user=$em ->getRepository(cour::class)->find((int)$request->get('cour_id'));
        $cour->setTitreCour($request->get('titreCour'));
        $cour->setDescriptionCour($request->get('descriptionCour'));
        $cour->setImage($request->get('image'));
        $cour->setTextCour($request->get('textCour'));
        $cour->setDureeCour($request->get('dureeCour'));
        $cour->setNoteCour($request->get('NoteCour'));
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    #**************************************************

    /**
     * Deletes a publication entity.
     *
     * @Route("/deleteC/{cour_id}", name="courr_delete")
     * @Method("DELETE")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteeAction(Request $request)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $cour = $em->getRepository(Cour::class)->find($request->get('cour_id'));
        //remove from the ORM
        $em->remove($cour);
        //update the data base
        $em->flush();
        return new JsonResponse(['message' => 'Cour Supprimée'], Response::HTTP_OK);
    }



    #***********************************************
    //********************************************************************************************************
    /**
     * Lists all cour entities.
     *
     * @Route("/", name="cour_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {$em=$this->get('doctrine.orm.entity_manager');

        $dql   = "SELECT c FROM FormationsBundle:cour c";
        $query = $em->createQuery($dql);
        $paginator=$this->get('knp_paginator');
        $RatingMoy = $em->getRepository('FormationsBundle:cour')->calculerMoyenneRating();
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        // parameters to template
        return $this->render('@Formations/cour/index.html.twig', ['pagination' => $pagination , 'RatingMoy' => $RatingMoy]);


        //********

        $em = $this->getDoctrine()->getManager();

        $cours = $em->getRepository('FormationsBundle:cour')->findAll();

        return $this->render('@Formations/cour/index.html.twig', array(
            'cours' => $cours,
        ));
    }

    /**
     * Creates a new cour entity.
     *
     * @Route("/new", name="cour_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cour = new Cour();
        $form = $this->createForm('FormationsBundle\Form\courType', $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form ['image']->getData();
            $newAssetName = $file->getClientOriginalName();

            $file->move($this->getParameter('assets_directory'), $newAssetName);

            $cour->setImage($newAssetName);

            //dump($file);
            //dump($cour->getFormations()->getFormationId());
            //dump($cour);exit();
            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->find($cour->getFormations()->getFormationId());
            $cour->setNoteCour(0);
            if($formation->getDureeFormation() == null)
            {
                $formation->setDureeFormation($cour->getDureeCour());
                $this->getDoctrine()->getManager()->flush();
            }else{
                $formation->setDureeFormation($formation->getDureeFormation()+$cour->getDureeCour());
                $this->getDoctrine()->getManager()->flush();}
            $em = $this->getDoctrine()->getManager();
            $em->persist($cour);
            $em->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('@Formations/cour/new.html.twig', array(
            'cour' => $cour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cour entity.
     *
     * @Route("/{cour_id}", name="cour_show")
     * @Method("GET")
     */
    public function showAction(cour $cour)
    {

        return $this->render('@Formations/cour/show.html.twig', array(
            'cour' => $cour,
        ));
    }


    /**
     * Displays a form to edit an existing cour entity.
     *
     * @Route("/{cour_id}/edit", name="cour_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, cour $cour)
    {
        $editForm = $this->createForm('FormationsBundle\Form\courType', $cour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cour_edit', array('cour_id' => $cour->getCourId()));
        }

        return $this->render('@Formations/cour/edit.html.twig', array(
            'cour' => $cour,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a cour entity.
     *
     * @Route("/delete/{cour_id}", name="cour_delete")
     * @Method("DELETE")
     */
    public function deleteAction($cour_id)
    {


        $cour = $this->getDoctrine()->getRepository('FormationsBundle:cour')->find($cour_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($cour);
        $em->flush();


        return $this->redirectToRoute('formation_index');
    }



    public function commentsAction(Request $request, cour $cour)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository("FormationsBundle:Commentaire")->findByCour($cour);
        $cour = $this->getDoctrine()->getRepository("FormationsBundle:cour")->find($cour->getCourId());
        return $this->render('@Formations/cour/Commentaire.html.twig', array(
            'comments' =>$comments,
           'cour'=>$cour,
        ));
    }
}
