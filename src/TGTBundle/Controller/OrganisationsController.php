<?php

namespace TGTBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use TGTBundle\Entity\Organisations;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Organisation controller.
 *
 * @Route("organisations")
 */
class OrganisationsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisations = $em->getRepository('TGTBundle:Organisations')->findAll();

        return $this->render('@TGT/front/Organisations/indexOrganisations.html.twig', array(
            'organisations' => $organisations,
        ));
    }


    public function newAction(Request $request)
    {
        $organisation = new Organisations();
        $form = $this->createForm('TGTBundle\Form\OrganisationsType', $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisation);
            $em->flush();

            return $this->redirectToRoute('Organisations_show', array('id' => $organisation->getId()));
        }

        return $this->render('@TGT/front/Organisations/addOrganisations.html.twig', array(
            'organisation' => $organisation,
            'form' => $form->createView(),
        ));
        $mailer = $this->get('mailer');
        $msg = (new \Swift_Message('demande islem'))
            ->setFrom('noreply@TGT.tn')
            ->setTo('islem.mhalla1@esprit.tn')
            ->setBody('ay hkeyaa');

        $mailer->send($msg);
    }


    public function showAction(Organisations $organisation)
    {
        $deleteForm = $this->createDeleteForm($organisation);

        return $this->render('@TGT/front/Organisations/indexOrganisations.html.twig', array(
            'organisation' => $organisation,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function editAction(Request $request, Organisations $organisation)
    {
        $deleteForm = $this->createDeleteForm($organisation);
        $editForm = $this->createForm('TGTBundle\Form\OrganisationsType', $organisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Organisations_show', array('id' => $organisation->getId()));
        }

        return $this->render('@TGT/front/Organisations/editOrganisations.html.twig', array(
            'organisation' => $organisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $organisation = $em->getRepository(Organisations::class)->find($id);

        $em->remove($organisation);

        $em->flush();

        return $this->redirectToRoute("Organisations_show");
    }

    /**
     * Creates a form to delete a organisation entity.
     *
     * @param Organisations $organisation The organisation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organisations $organisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Organisations_delete', array('id' => $organisation->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
