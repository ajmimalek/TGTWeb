<?php

namespace TGTBundle\Controller;

use Composer\Script\Event;
use Symfony\Component\HttpFoundation\Response;
use TGTBundle\Entity\Events;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Form\EventsType;

/**
 * Event controller.
 *
 * @Route("events")
 */
class EventsController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('TGTBundle:Events')->findallevents();

        return $this->render('@TGT/front/Events/indexEvents.html.twig', array(
            'events' => $events,
        ));
    }


    public function newAction(Request $request)
    {
        $events= new Events();
        $form = $this->createForm(EventsType::class,$events);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()){

            $file = $form ['imageEvents']->getData();


            $newImageName = $file->getClientOriginalName();

            $file->move($this->getParameter('images_directory'), $newImageName);

            $events->setImageEvents($newImageName);

            dump($file);

            dump($events);
            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();
            return $this->redirectToRoute('Events_show');
        }

        return ($this->render('@TGT/front/Events/addEvents.html.twig',array("form"=> $form->createView())));
    }



    public function showAction(Events $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('@TGT/front/Events/showEvents.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function editAction(Request $request, Events $event)
    {
        $deleteForm = $this->createDeleteForm($event);
        $editForm = $this->createForm('TGTBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Events_show', array('id' => $event->getId()));
        }

        return $this->render('@TGT/front/Events/editEvents.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $casting= $em->getRepository(Events::class)->find($id);

        $em->remove($casting);

        $em->flush();

        return $this->redirectToRoute("Events_show");
    }

    /**
     * Creates a form to delete a event entity.
     *
     * @param Events $event The event entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Events $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Events_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
