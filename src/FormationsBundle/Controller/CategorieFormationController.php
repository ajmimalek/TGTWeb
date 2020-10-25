<?php

namespace FormationsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FormationsBundle\Entity\CategorieFormation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Categorieformation controller.
 *
 * @Route("categorieformation")
 */
class CategorieFormationController extends Controller
{
    /**
     * Lists all categorieFormation entities.
     *
     * @Route("/", name="categorieformation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieFormations = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();

        return $this->render('@Formations/categorieformation/index.html.twig', array(
            'categorieFormations' => $categorieFormations,
        ));
    }

    /**
     * Lists all formation entities.
     *
     * @Route("/allCat", name="allCat")
     * @Method("GET")
     */
    Public function allCatAction()
    {
        $tasks = $this ->getDoctrine()->getManager()
            ->getRepository('FormationsBundle:CategorieFormation')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }


    /**
     * Creates a new categorieFormation entity.
     *
     * @Route("/new", name="categorieformation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorieFormation = new Categorieformation();
        $form = $this->createForm('FormationsBundle\Form\CategorieFormationType', $categorieFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieFormation);
            $em->flush();

            return $this->redirectToRoute('categorieformation_show', array('id' => $categorieFormation->getId()));
        }

        return $this->render('@Formations/categorieformation/new.html.twig', array(
            'categorieFormation' => $categorieFormation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorieFormation entity.
     *
     * @Route("/{id}", name="categorieformation_show")
     * @Method("GET")
     */
    public function showAction(CategorieFormation $categorieFormation)
    {
        $deleteForm = $this->createDeleteForm($categorieFormation);

        return $this->render('@Formations/categorieformation/show.html.twig', array(
            'categorieFormation' => $categorieFormation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorieFormation entity.
     *
     * @Route("/{id}/edit", name="categorieformation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CategorieFormation $categorieFormation)
    {
        $deleteForm = $this->createDeleteForm($categorieFormation);
        $editForm = $this->createForm('FormationsBundle\Form\CategorieFormationType', $categorieFormation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorieformation_edit', array('id' => $categorieFormation->getId()));
        }

        return $this->render('@Formations/categorieformation/edit.html.twig', array(
            'categorieFormation' => $categorieFormation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a categorieFormation entity.
     *
     * @Route("/{id}", name="categorieformation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CategorieFormation $categorieFormation)
    {
        $form = $this->createDeleteForm($categorieFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorieFormation);
            $em->flush();
        }

        return $this->redirectToRoute('categorieformation_index');
    }

    /**
     * Creates a form to delete a categorieFormation entity.
     *
     * @param CategorieFormation $categorieFormation The categorieFormation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CategorieFormation $categorieFormation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorieformation_delete', array('id' => $categorieFormation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
