<?php

namespace PublicationsBundle\Controller;

use PublicationsBundle\Entity\CategoriePublication;
use PublicationsBundle\Form\CategoriePublicationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Categoriepublication controller.
 *
 * @Route("categorie")
 */
class CategoriePublicationController extends Controller
{
    /**
     * Lists all categoriePublication entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categoriePublications = $em->getRepository(CategoriePublication::class)->findAll();

        return $this->render('@Publications/categoriepublication/index.html.twig', array(
            'categoriePublications' => $categoriePublications,
        ));
    }

    /**
     * Creates a new categoriePublication entity.
     *
     * @Route("/new", name="categorie_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $categoriePublication = new Categoriepublication();
        $form = $this->createForm(CategoriePublicationType::class, $categoriePublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository(CategoriePublication::class)->alterTable();
            $em->persist($categoriePublication);
            $em->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('@Publications/categoriepublication/new.html.twig', array(
            'categoriePublication' => $categoriePublication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categoriePublication entity.
     *
     * @Route("/{id_cat}", name="categorie_show")
     * @Method("GET")
     * @param CategoriePublication $categoriePublication
     * @return Response
     */
    public function showAction(CategoriePublication $categoriePublication)
    {
        return $this->render('@Publications/categoriepublication/show.html.twig', array(
            'categoriePublication' => $categoriePublication,
        ));
    }

    /**
     * Displays a form to edit an existing categoriePublication entity.
     *
     * @Route("/{id_cat}/edit", name="categorie_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param CategoriePublication $categoriePublication
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CategoriePublication $categoriePublication)
    {
        $editForm = $this->createForm(CategoriePublicationType::class, $categoriePublication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_index');
        }

        return $this->render('@Publications/categoriepublication/edit.html.twig', array(
            'categoriePublication' => $categoriePublication,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a categoriePublication entity.
     *
     * @Route("/delete/{id_cat}", name="categorie_delete")
     * @Method("DELETE")
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $categoriePublication = $em->getRepository(CategoriePublication::class)->find($request->get('id_cat'));
        //remove from the ORM
        $em->remove($categoriePublication);
        //update the data base
        $em->flush();
        return $this->redirectToRoute('categorie_index');
    }

}
