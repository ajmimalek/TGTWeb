<?php

namespace TGTBundle\Controller;

use TGTBundle\Entity\Reponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Reponse controller.
 *
 * @Route("reponse")
 */
class ReponseController extends Controller
{
    /**
     * Lists all reponse entities.
     *
     * @Route("/", name="reponse_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reponses = $em->getRepository('TGTBundle:Reponse')->findAll();

        return $this->render('@TGT/front/reponse/showReponse.html.twig', array(
            'reponses' => $reponses,
        ));
    }

    /**
     * Creates a new reponse entity.
     *
     * @Route("/new", name="reponse_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reponses = new Reponse();
        $reponses->setDate(new  \DateTime());
        $form = $this->createForm('TGTBundle\Form\ReponseType', $reponses);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reponses);
            $em->flush();

            return $this->redirectToRoute('Reponse_show', array('id' => $reponses->getId()));
        }

        return $this->render('@TGT/front/Reponse/addReponse.html.twig', array(
            'reponse' => $reponses,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reponse entity.
     *
     * @Route("/{id}", name="reponse_show")
     * @Method("GET")
     */
    public function showAction(Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);

        return $this->render('@TGT/front/Reponse/showReponse.html.twig', array(
            'reponse' => $reponse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reponse entity.
     *
     * @Route("/{id}/edit", name="reponse_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);
        $editForm = $this->createForm('TGTBundle\Form\ReponseType', $reponse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Reponse_show', array('id' => $reponse->getId()));
        }

        return $this->render('@TGT/front/Reponse/editReponse.html.twig', array(
            'reponse' => $reponse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $Reponse= $em->getRepository(Reponse::class)->find($id);

        $em->remove($Reponse);

        $em->flush();

        return $this->redirectToRoute("Reponse_show");
    }

    /**
     * Creates a form to delete a reponse entity.
     *
     * @param Reponse $reponse The reponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reponse $reponse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Reponse_delete', array('id' => $reponse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    public function afficheReponseAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Question = $em->getRepository("TGTBundle:Question")->find($id);
        $Reponse = $em->getRepository("TGTBundle:Reponse")->findByaffiche($Question->getId());
        return $this->render("@TGT/front/Reponse/showReponse.html.twig",array('Question'=>$Question,'reponses'=>$Reponse));
    }



}
