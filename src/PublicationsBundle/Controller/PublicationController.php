<?php

namespace PublicationsBundle\Controller;

use DateTime;
use Exception;
use PublicationsBundle\Entity\CategoriePublication;
use PublicationsBundle\Entity\Publication;
use PublicationsBundle\Form\PublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Publication controller.
 *
 * @Route("publications")
 */
class PublicationController extends Controller
{
    /**
     * Lists all publication entities.
     *
     * @Route("/", name="publication_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository('PublicationsBundle:Publication')->findAll();
        foreach ($publications as $publication) {
            if (strpos($publication->getVideo(), "file:") === 0) {
                $pos = strrpos($publication->getVideo(), "/") + 1;
                $publication->setVideo(substr($publication->getVideo(), $pos));
            }
        }
        //TWIG
        return $this->render('@Publications/publication/index.html.twig', array(
            'publications' => $publications,
        ));
    }

    /**
     * Creates a new publication entity.
     *
     * @Route("/new", name="publication_new")
     * @Method("POST")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function newAction(Request $request)
    {
        $publication = new Publication();
        $publication->setDatePub(new DateTime());
        $publication->setRatingPub(0.0);
        // Formulaire
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form ['video']->getData();
            // this condition is needed because the 'video' field is not required
            if ($file) {
                $newAssetName = $file->getClientOriginalName();
                $file->move($this->getParameter('assets_directory'), $newAssetName);
                $publication->setVideo($newAssetName);
                $em = $this->getDoctrine()->getManager();
                $em->getRepository(Publication::class)->alterTable();
                $em->persist($publication);
                $em->flush();
            }
        }

        return $this->render('@Publications/publication/new.html.twig', array(
            'publication' => $publication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publication entity.
     *
     * @Route("/{id_pub}", name="publication_show")
     * @Method("GET")
     * @param Publication $publication
     * @return Response
     */
    public function showAction(Publication $publication)
    {
        return $this->render('@Publications/publication/show.html.twig', array(
            'publication' => $publication,
        ));
    }


    /**
     * Displays a form to edit an existing publication entity.
     *
     * @Route("/{id_pub}/edit", name="publication_edit")
     * @Method("PUT")
     * @param Request $request
     * @param Publication $publication
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Publication $publication)
    {
        //Formulaire
        $editForm = $this->createForm(PublicationType::class, $publication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $editForm ['video']->getData();
            if ($file) {
                $newAssetName = $file->getClientOriginalName();

                $file->move($this->getParameter('assets_directory'), $newAssetName);

                $publication->setVideo($newAssetName);
                dump($file);
                dump($publication);
                $this->getDoctrine()->getManager()->flush();
            }
            return $this->redirectToRoute('publication_index');
        }

        return $this->render('@Publications/publication/edit.html.twig', array(
            'publication' => $publication,
            'edit_form' => $editForm->createView()
        ));
    }

    public function deleteAction(Request $request)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository(Publication::class)->find($request->get('id_pub'));
        //remove from the ORM
        $em->remove($publication);
        //update the data base
        $em->flush();
        return $this->redirectToRoute('publication_index');
    }
}
