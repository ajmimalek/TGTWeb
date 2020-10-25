<?php

namespace TGTBundle\Controller;

use TGTBundle\Entity\Entretien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Form\EntretienType;

/**
 * Entretien controller.
 *
 * @Route("entretien")
 */
class EntretienController extends Controller
{

    public function espaceentretienAction()
    {
        return $this->render('@TGT/Entretien/espaceEntretien.html.twig');
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entretiens = $em->getRepository('TGTBundle:Entretien')->findAll();

        return $this->render('@TGT/Entretien/indexEntretien.html.twig', array(
            'entretiens' => $entretiens,
        ));
    }

    public function newAction(Request $request)
    {
        $entretiens = new Entretien();
        $form = $this->createForm('TGTBundle\Form\EntretienType', $entretiens);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entretiens->setNoteEnt('0');
            $entretiens->setStatutEnt('en cour');
            $em->persist($entretiens);
            $em->flush();

            return $this->redirectToRoute('entretien_show', array('id' => $entretiens->getId()));
        }

        return $this->render('@TGT/Entretien/newEntretien.html.twig', array(
            'entretiens' => $entretiens,
            'form' => $form->createView(),
        ));
    }


    public function showAction(Entretien $entretien)
    {
        $deleteForm = $this->createDeleteForm($entretien);

        return $this->render('@TGT/Entretien/show.html.twig', array(
            'entretiens' => $entretien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Entretien $entretiens)
{
    $deleteForm = $this->createDeleteForm($entretiens);
    $editForm = $this->createForm('TGTBundle\Form\EntretienType', $entretiens);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('entretien_show', array('id' => $entretiens->getId()));
    }

    return $this->render('@TGT/Entretien/editEntretien.html.twig', array(
        'entretiens' => $entretiens,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
    ));
}

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entretiens= $em->getRepository(Entretien::class)->find($id);

        $em->remove($entretiens);

        $em->flush();

        return $this->redirectToRoute("entretien_show");
    }
    /**
     * Creates a form to delete a entretien entity.
     *
     * @param Entretien $entretien The entretien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Entretien $entretien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('entretien_delete', array('id' => $entretien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
