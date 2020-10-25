<?php

namespace PublicationsBundle\Controller;

use Exception;
use PublicationsBundle\Entity\CommentairePublication;
use PublicationsBundle\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Commentairepublication controller.
 * @Route("")
 *
 */
class CommentairePublicationController extends Controller
{
    /**
     * Lists all commentairePublication entities.
     *
     * @Route("publications/{id_pub}/commentaires", name="commentaires_index")
     * @Method("GET,POST")
     * @param Request $request
     * @param $id_pub
     * @return Response
     * @throws Exception
     */
    public function indexAction(Request $request, $id_pub)
    {
        $commentairePublication = new Commentairepublication();
        $commentairePublication->setDateComm(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository(Publication::class)->find($id_pub);
        $commentairePublication->setPublication($publication);
        $commentairePublication->setNbinutile(0);
        $form = $this->createForm('PublicationsBundle\Form\CommentairePublicationType', $commentairePublication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->getRepository(CommentairePublication::class)->alterTable();
            $em->persist($commentairePublication);
            $em->flush();
            $em->getRepository(Publication::class)->updatePublication($id_pub);
            return $this->redirectToRoute('commentaires_index', array('id_pub' => $id_pub));
        }
        return $this->render('@Publications/commentairepublication/index.html.twig', array(
            'commentairePublications' => $publication->getCommentaires(),
            'publication' => $publication,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a commentairePublication entity.
     *
     * @Route("publications/{id_pub}/commentaires/{id_comment}", name="commentaires_show")
     * @Method("GET")
     * @param CommentairePublication $commentairePublication
     * @return Response
     */
    public function showAction(CommentairePublication $commentairePublication, $id_pub)
    {
        return $this->render('@Publications/commentairepublication/show.html.twig', array(
            'commentairePublication' => $commentairePublication
        ));
    }

    /**
     * Displays a form to edit an existing commentairePublication entity.
     *
     * @Route("publications/{id_pub}/commentaires/{id_comment}/edit", name="commentaires_edit")
     * @Method("PUT")
     * @param Request $request
     * @param CommentairePublication $commentairePublication
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, CommentairePublication $commentairePublication)
    {
        $editForm = $this->createForm('PublicationsBundle\Form\CommentairePublicationType', $commentairePublication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $em->getRepository(Publication::class)->updatePublication($commentairePublication->getPublication()->getId());
            return $this->redirectToRoute('commentaires_index', array('id_pub' => $commentairePublication->getPublication()->getId()));
        }

        return $this->render('@Publications/commentairepublication/edit.html.twig', array(
            'commentairePublication' => $commentairePublication,
            'publication' => $commentairePublication->getPublication(),
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a commentairePublication entity.
     *
     * @Route("publications/{id_pub}/commentaires/{id_comment}/delete", name="commentaires_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param CommentairePublication $commentairePublication
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, CommentairePublication $commentairePublication)
    {
        $em = $this->getDoctrine()->getManager();
        //remove from the ORM
        $em->remove($commentairePublication);
        //update the data base
        $em->flush();
        $em->getRepository(Publication::class)->updatePublication($commentairePublication->getPublication()->getId());
        return $this->redirectToRoute('commentaires_index', array('id_pub' => $commentairePublication->getPublication()->getId()));
    }

    /**
     * Sorting comments by date or Rating
     *
     * @Route("publications/{id_pub}/commentaires/trie/{val}", name="commentaires_trie")
     * @Method({"GET"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function TrierAction(Request $request,$id_pub)
    {
        $commentairePublication = new Commentairepublication();
        $commentairePublication->setDateComm(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository(Publication::class)->find($id_pub);
        $commentairePublication->setPublication($publication);
        $commentairePublication->setNbinutile(0);
        $form = $this->createForm('PublicationsBundle\Form\CommentairePublicationType', $commentairePublication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->getRepository(CommentairePublication::class)->alterTable();
            $em->persist($commentairePublication);
            $em->flush();
            $em->getRepository(Publication::class)->updatePublication($id_pub);
            return $this->redirectToRoute('commentaires_index', array('id_pub' => $id_pub));
        }
        //Getting option from Request
        $val = $request->get('val');
        $id_pub = $request->get('id_pub');
        if (strtoupper($val) === 'RATING') {
            $commentairesPublication = $em->getRepository('PublicationsBundle:CommentairePublication')->trierParRating($id_pub);
        } elseif (strtoupper($val) === 'DATE') {
            $commentairesPublication = $em->getRepository('PublicationsBundle:CommentairePublication')->trierParDate($id_pub);
        }
        return $this->render('@Publications/commentairepublication/index.html.twig', array(
            'commentairePublications' => $commentairesPublication,
            'publication' => $publication,
            'form' => $form->createView(),
        ));
    }
}
