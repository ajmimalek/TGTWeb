<?php

namespace FormationsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FormationsBundle\Entity\CategorieFormation;
use FormationsBundle\Entity\formation;

/**
 * Formation controller.
 *
 * @Route("/formation")
 */
class formationMobileController extends Controller
{
    #*******************************************************

    /**
     * Creates a new formation entity.
     *
     * @Route("/newF", name="formationn_new")
     * @Method({"GET", "POST"})
     */
    public function newFAction(Request $request)
    {

        $formation = new Formation();
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository(CategorieFormation::class)->find($request->get('id'));
        if (empty($categorie)){
            return new JsonResponse(['message' => 'Catégorie non trouvée'], Response::HTTP_NOT_FOUND);
        }
        $formation->setCategorie($categorie);
        $formation->setTitreFormation($request->get('titreformation'));
        $formation->setDescriptionFormation($request->get('descriptionFormation'));
        $formation->setImage($request->get('image'));
        $formation->setDureeFormation($request->get('dureeFormation'));
        $formation->setLikes($request->get('likes'));
        $formation->setNolikes($request->get('dislikes'));

        $em->persist($formation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
        return new JsonResponse($formatted);
    }

#************************************************

    /**
     * Lists all formation entities.
     *
     * @Route("/all", name="all")
     * @Method("GET")
     */
    Public function allAction()
    {
        $tasks = $this ->getDoctrine()->getManager()
            ->getRepository('FormationsBundle:formation')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }
    #**************************************************
    /**
     * Displays a form to edit an existing formation entity.
     *
     * @Route("/{formation_id}/editF", name="formationn_edit")
     * @Method({"GET", "POST"})
     */
    public function editFAction(Request $request, Formation $formation)
    {
        $em = $this->getDoctrine()->getManager();


        $user=$em ->getRepository(formation::class)->find((int)$request->get('formation_id'));
        $formation->setTitreFormation($request->get('titreformation'));
        $formation->setDescriptionFormation($request->get('descriptionFormation'));
        $formation->setImage($request->get('image'));
        $formation->setDureeFormation($request->get('dureeFormation'));
        $formation->setLikes($request->get('likes'));
        $formation->setNolikes($request->get('dislikes'));


        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

    #**************************************************

    /**
     * Deletes a publication entity.
     *
     * @Route("/deleteF/{formation_id}", name="formationn_delete")
     * @Method("DELETE")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteeAction(Request $request)
    {
        //get the object to be removed given the submitted id
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(Formation::class)->find($request->get('formation_id'));
        //remove from the ORM
        $em->remove($formation);
        //update the data base
        $em->flush();
        return new JsonResponse(['message' => 'Publication Supprimée'], Response::HTTP_OK);
    }
}
