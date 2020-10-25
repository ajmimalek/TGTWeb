<?php

namespace TGTBundle\Controller;

use TGTBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Entity\Casting;
use TGTBundle\Entity\Contrat;
use TGTBundle\Entity\Entretien;
use TGTBundle\Entity\Events;
use TGTBundle\Entity\formation;
use TGTBundle\Entity\Organisations;
use TGTBundle\Form\CandidatType;
use TGTBundle\Form\CastingType;
use TGTBundle\Form\ContratType;
use TGTBundle\Form\EntretienType;
use TGTBundle\Form\EventsType;
use TGTBundle\Form\OrganisationsType;

/**
 * Back controller.
 *
 * @Route("candidat")
 */
class BackController extends Controller
{

    public function indexUtilisateurAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository(Candidat::class)->findAll();

        return $this->render('@TGT/back/utilisateur/backUtilisateur.html.twig', array(
            'candidats' => $candidats,
        ));
    }

########### Back Organisation #############
    public function indexOrganisationAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisations = $em->getRepository(Organisations::class)->findAll();

        return $this->render('@TGT/back/organisation/indexOrganisations.html.twig', array(
            'organisations' => $organisations,
        ));
    }

    public function addOrganisationAction(Request $request)
    {
        $organisation = new Organisations();
        $form = $this->createForm('TGTBundle\Form\OrganisationsType', $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisation);
            $em->flush();

            return $this->redirectToRoute('back_Organiation', array('id' => $organisation->getId()));
        }

        return $this->render('@TGT/back/organisation/addOrganisations.html.twig', array(
            'organisation' => $organisation,
            'form' => $form->createView(),
        ));
    }

    public function editOrganisationAction(Request $request, $id)
    {
        $organisation = $this->getDoctrine()->getRepository(Organisations::class)
            ->find($id);
        $form = $this->createForm(OrganisationsType::class, $organisation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $ef = $this->getDoctrine()->getManager();
            $ef->persist($organisation);
            $ef->flush();


            return $this->redirectToRoute("back_Organiation");
        }
        return $this->render("@TGT/back/organisation/editOrganisations.html.twig",
            array("form" => $form->createView()));

    }


    public function deleteOrganisationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $organisation = $em->getRepository(Organisations::class)->find($id);

        $em->remove($organisation);

        $em->flush();

        return $this->redirectToRoute("back_Organiation");
    }

    ########## Back Casting #########
    public function indexCastingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $castings = $em->getRepository('TGTBundle:Casting')->findAll();

        return $this->render('@TGT/back/casting/indexCasting.html.twig', array(
            'castings' => $castings,
        ));
    }

    public function newCastingAction(Request $request)
    {

        $casting= new Casting();
        $form = $this->createForm(CastingType::class,$casting);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()){

            $file = $form ['imageCasting']->getData();


            $newImageName = $file->getClientOriginalName();

            $file->move($this->getParameter('images_directory'), $newImageName);

            $casting->setImageCasting($newImageName);



            dump($file);

            dump($casting);
            $em = $this->getDoctrine()->getManager();
            $em->persist($casting);
            $em->flush();
            return $this->redirectToRoute('back_Casting');
        }

        return ($this->render('@TGT/back/casting/addCasting.html.twig',array("form"=> $form->createView())));
    }

    public function editCastingAction(Request $request, Casting $casting)
    {
        $deleteForm = $this->createDeleteForm($casting);
        $editForm = $this->createForm('TGTBundle\Form\CastingType', $casting);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_Casting', array('id' => $casting->getId()));
        }

        return $this->render('@TGT/back/casting/editCasting.html.twig', array(
            'casting' => $casting,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteCastingAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $casting= $em->getRepository(Casting::class)->find($id);

        $em->remove($casting);

        $em->flush();

        return $this->redirectToRoute("back_Casting");
    }

    private function createDeleteForm(Casting $casting)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('back_DeleteCasting', array('id' => $casting->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    ########## Back Events #########
    public function indexEventsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('TGTBundle:Events')->findAll();

        return $this->render('@TGT/back/Events/indexEvents.html.twig', array(
            'events' => $events,
        ));
    }

    public function newEventsAction(Request $request)
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
            return $this->redirectToRoute('back_Events');
        }

        return ($this->render('@TGT/back/Events/addEvents.html.twig',array("form"=> $form->createView())));
    }

    public function editEventsAction(Request $request, Events $event)
    {
        $deleteForm = $this->createDeleteForms($event);
        $editForm = $this->createForm('TGTBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_Events', array('id' => $event->getId()));
        }

        return $this->render('@TGT/back/Events/editEvents.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteEventsAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $casting= $em->getRepository(Events::class)->find($id);

        $em->remove($casting);

        $em->flush();

        return $this->redirectToRoute("back_Events");
    }

    private function createDeleteForms(Events $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Events_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }


########CANDIAT#############################################

    public function indexCandidatAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidat = $em->getRepository(Candidat::class)->findAll();

        return $this->render('@TGT/back/condidat/indexCandidat.html.twig', array(
            'candidat' => $candidat,
        ));
    }

    public function addCandidatAction(Request $request)
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
            return $this->redirectToRoute('back_Candidat');
        }

        return ($this->render('@TGT/back/condidat/addCandidat.html.twig',array("form"=> $form->createView())));
    }


    public function editCandidatAction(Request $request, Candidat $candidat)
    {
        $deleteForm = $this->createDeleteFormCondidat($candidat);
        $editForm = $this->createForm(CandidatType::class, $candidat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_Candidat', array('id' => $candidat->getId()));
        }

        return $this->render('@TGT/back/condidat/editCandidat.html.twig', array(
            'candidat' => $candidat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteCandidatAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $candidat= $em->getRepository(Candidat::class)->find($id);

        $em->remove($candidat);

        $em->flush();

        return $this->redirectToRoute("back_Candidat");
    }
####################################################################################################################
##################Etretient################################################################################

    public function indexEntretientAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entretient = $em->getRepository(Entretien::class)->findAll();

        return $this->render('@TGT/back/entretient/indexEntretient.html.twig', array(
            'entretient' => $entretient,
        ));
    }

    public function editEntretientAction(Request $request, $id)
    {
        $entretient = $this->getDoctrine()->getRepository(Organisations::class)
            ->find($id);
        $form = $this->createForm(EntretienType::class, $entretient);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $ef = $this->getDoctrine()->getManager();
            $ef->persist($entretient);
            $ef->flush();


            return $this->redirectToRoute("back_Entretient");
        }
        return $this->render("@TGT/back/entretient/editEntretient.html.twig",
            array("form"=>$form->createView()));

    }

    public function addEntretientAction(Request $request)
    {
        $entretient = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entretient);
            $em->flush();

            return $this->redirectToRoute('back_Entretient', array('id' => $entretient->getId()));
        }

        return $this->render('@TGT/back/entretient/addEntretient.html.twig', array(
            'entretient' => $entretient,
            'form' => $form->createView(),
        ));
    }

    public function deleteEntretientAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entretiens= $em->getRepository(Entretien::class)->find($id);

        $em->remove($entretiens);

        $em->flush();

        return $this->redirectToRoute("back_Entretient");
    }


####################################################################################################################
##################Contrat################################################################################
    public function indexContratAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contrat = $em->getRepository(Contrat::class)->findAll();

        return $this->render('@TGT/back/contrat/indexContrat.html.twig', array(
            'contrat' => $contrat,
        ));
    }

    public function addContratAction(Request $request)
    {
        $contrats = new Contrat();
        $form = $this->createForm(ContratType::class, $contrats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contrats);
            $em->flush();

            return $this->redirectToRoute('back_Contrat', array('id' => $contrats->getId()));
        }

        return $this->render('@TGT/back/contrat/addContrat.html.twig', array(
            'contrat' => $contrats,
            'form' => $form->createView(),
        ));
    }

    public function editContratAction(Request $request, $id)
    {
        $contrat = $this->getDoctrine()->getRepository(Contrat::class)
            ->find($id);
        $form = $this->createForm(ContratType::class, $contrat);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $ef = $this->getDoctrine()->getManager();
            $ef->persist($contrat);
            $ef->flush();


            return $this->redirectToRoute("back_Contrat");
        }
        return $this->render("@TGT/back/contrat/editContrat.html.twig",
            array("form"=>$form->createView()));

    }
    public function deleteContratAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $contrat= $em->getRepository(Contrat::class)->find($id);

        $em->remove($contrat);

        $em->flush();

        return $this->redirectToRoute("back_Contrat");
    }

    private function createDeleteFormCondidat(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('back_DeleteCandidat', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}


