<?php

namespace FormationsBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use FormationsBundle\Entity\formation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use FormationsBundle\Entity\participer;
use FormationsBundle\Entity\CategorieFormation;


/**
 * Formation controller.
 *
 * @Route("formation")
 */
class formationController extends Controller
{
    /**
     * Lists all formation entities.
     *
     * @Route("/", name="formation_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT f FROM FormationsBundle:formation f";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );
        $em = $this->getDoctrine()->getManager();
        $formations = $em->getRepository('FormationsBundle:formation')->findAll();
        $categorie = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();
        // parameters to template
        return $this->render('@Formations/formation/index.html.twig', ['pagination' => $pagination, 'formations' => $formations, 'categories' => $categorie]);
    }
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
        $formation->setTitreFormation($request->get('titreFormation'));
        $formation->setDescriptionFormation($request->get('descriptionFormation'));
        $formation->setImage($request->get('image'));
        $formation->setDureeFormation($request->get('dureeFormation'));
        $formation->setLikes($request->get('likes'));
        $formation->setNolikes(0);

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
     * @Route("/all", name="allF")
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
     * @Route("/api/trier/{val}", name="Json_Trier")
     * @Method({"GET", "POST"})
     */
    public function TrierJsonAction(Request $request)
    {

        $em=$this->get('doctrine.orm.entity_manager');
        $val = $request->get('val');

        if ($val == 'PE') {
            $em = $this->getDoctrine()->getManager();
            $formations = $em->getRepository('FormationsBundle:formation')->trierDureeElv();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($formations);
            return new JsonResponse($formatted);

        } elseif ($val == 'PB') {
            $em = $this->getDoctrine()->getManager();
            $formations = $em->getRepository('FormationsBundle:formation')->trierDureeBas();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($formations);
            return new JsonResponse($formatted);

        }
    }
    #**************************************************
    /**
     *
     * @Route("/api/rechercheJson", name="search")
     */
    public function rechercheJsonAction(Request $request)
    {
        $keyWord = $request->get('keyWord');
       // dump($keyWord);exit();

            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->RechercheTitreFormation($keyWord);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
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
        $categorie = $em->getRepository(CategorieFormation::class)->find($request->get('id'));
        $formation->setCategorie($categorie);
        $formation->setTitreFormation($request->get('titreFormation'));
        $formation->setDescriptionFormation($request->get('descriptionFormation'));
        $formation->setImage($request->get('image'));
        $formation->setDureeFormation($request->get('dureeFormation'));
        $formation->setLikes($request->get('likes'));
        $em->persist($formation);
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
#***********************************************
    /**
     * Simulation
     *
     * @Route("/api/Simulation/{formation_id}", name="Json_Simu")
     * @Method({"GET", "POST"})
     */
    public function SimulationJsonAction($formation_id)
    {

        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository("FormationsBundle:formation")->find($formation_id);
        $cour = $em->getRepository("FormationsBundle:cour")->findBySimulation($formation->getFormationId());
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($cour);
        return new JsonResponse($formatted);
    }
#***********************************************
    /**
     * @Route("/{formation_id}/participer", name="participer")
     * @Method({"GET", "POST"})
     */
    public function participerAction(Request $request, formation $formation)
    {
        $participer = new participer();


        $em = $this->getDoctrine()->getManager();
        $participer->setIdformation($formation);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $participer->setIdUser($user);
        $em->persist($participer);
        $em->flush();

        return $this->redirectToRoute('Simulation', array('formation_id' => $formation->getFormationId()));

    }




    /**
     * @Route("showmine", name="showmine")
     * @Method({"GET", "POST"})
     */
    public function showmineAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        //$evenements = $em->getRepository('EvenementBundle:Evenement')->FindMyEvents($user);
        $categorie = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();

        $dql = $this
            ->getDoctrine()->getManager()
            ->createQuery( 'SELECT I FROM  FormationsBundle:participer I WHERE I.idUser = :idusr');
        $dql->setParameter(':idusr', $user);
        $alli= $dql->getResult();
        $formations =[];
        foreach ($alli as $i)
        {
            $formations[]=$i->getIdformation();
        }

        return $this->render('@Formations/formation/showmine.html.twig', array(
            'formations' => $formations,'categories'=>$categorie
        ));
    }



    /**
     * @Route("/{formation_id}/annulerparticiper", name="annulerparticiper")
     * @Method({"GET", "POST"})
     */

    public function annulerparticiperAction($formation_id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $participer = $em->getRepository("FormationsBundle:participer")->findBy(['idformation'=>$formation_id,'idUser'=>$user]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($participer[0]);
        $em->flush();


        return $this->redirectToRoute('formation_index');
    }


    /**
     * @Route("/formation/trier", name="formation_trier")
     * @Method({"GET", "POST"})
     */
    public function TrierAction(Request $request)
    {

        $em=$this->get('doctrine.orm.entity_manager');
        $paginator=$this->get('knp_paginator');
        $val = $request->get('val');

        if ($val == 'PE') {
            $em = $this->getDoctrine()->getManager();
            $categories = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();
            $formations = $em->getRepository('FormationsBundle:formation')->trierDureeElv();
            $pagination = $paginator->paginate(
                $formations, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                4 /*limit per page*/
            );
        } elseif ($val == 'PB') {
            $em = $this->getDoctrine()->getManager();
            $categories = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();
            $formations = $em->getRepository('FormationsBundle:formation')->trierDureeBas();
            $pagination = $paginator->paginate(
                $formations, /* query NOT result */
                $request->query->getInt('page', 1), /*page number*/
                4 /*limit per page*/
            );
        }
        //aaaaaaaaaa
        return $this->render('@Formations/formation/index.html.twig', ['pagination' => $pagination, 'formations' => $formations,'categories'=>$categories]);

    }






    /**
     *
     * @Route("/formation/recherche", name="f_recherche")
     * @Method({"GET", "POST"})
     */
    public function rechercheAction(Request $request)
    {
        $keyWord = $request->get('keyWord');
        //dump($keyWord);exit();
        if($keyWord == '')
        {
            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->findAll();
        }else
        {
            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->RechercheTitreFormation($keyWord);

        }

        $template = $this->render( '@Formations/formation/recherche.html.twig', array("formations" => $formation))->getContent();
        $json     = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     *
     * @Route("/formation/recherchecat", name="f_recherche_cat")
     * @Method({"GET", "POST"})
     */
    public function rechercheCatAction(Request $request)
    {
        $keyWord = $request->get('keyWord');
        //dump($keyWord);exit();
        if($keyWord == '')
        {
            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->findAll();
        }else
        {
            $categorie = $this->getDoctrine()->getRepository('FormationsBundle:CategorieFormation')->findBy(['libele'=>$keyWord]);
            $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->findBy(['categorie'=>$categorie[0]]);
        }

         $template = $this->render( '@Formations/formation/recherche.html.twig', array("formations" => $formation))->getContent();

        $json     = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * Creates a new Categorie et annonce entity.
     *
     * @Route("/jaime/new", name="formation_jaime")
     * @Method({"GET", "POST"})
     */
    public function newJaimeAction(Request $request)
    {

        if (($request->isXmlHttpRequest())) {
            $id = $request->get('Id');
            $em = $this->getDoctrine()->getManager();
            $formation = $em->getRepository('FormationsBundle:formation')->find($id);
            $formation->setLikes($formation->getLikes() + 1);
            $em->flush();
            return $this->redirectToRoute('formation_index');
        }
    }


    /**
     * Creates a new Categorie et annonce entity.
     *
     * @Route("/nojaime/new", name="formation_nojaime")
     * @Method({"GET", "POST"})
     */
    public function newnoJaimeAction(Request $request)
    {

        if (($request->isXmlHttpRequest())) {
            $id = $request->get('Id');
            $em = $this->getDoctrine()->getManager();
            $formation = $em->getRepository('FormationsBundle:formation')->find($id);
            $formation->setLikes($formation->getLikes() - 1);
            $em->flush();
            return $this->redirectToRoute('formation_index');
        }
    }



    /**
     * @Route("/categorie/{cat}", name="recherch_Categorie")
     * @Method("GET")
     */
    public function RecherchCategorieAction(Request $request, $cat)
    {

        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('FormationsBundle:CategorieFormation')->findAll();
        $pagination = $em->getRepository('FormationsBundle:formation')->findByCategorie($cat);
        //dump($formations);exit();
        // parameters to template
        return $this->render('@Formations/formation/cat.html.twig', ['pagination' => $pagination,'categories'=>$categorie]);
    }

    /**
     * @Route("/new", name="formation_new")
     * @Method("GET")
     */
    public function newAction(Request $request)
    {
        $formation = new Formation();
        $form = $this->createForm('FormationsBundle\Form\formationType', $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form ['image']->getData();

            $newAssetName = $file->getClientOriginalName();

            $file->move($this->getParameter('assets_directory'), $newAssetName);
            $formation->setLikes(0);
            $formation->setNolikes(0);

            $formation->setImage($newAssetName);
            $formation->setDureeFormation(0);
            dump($file);

            dump($formation);
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('formation_show', array('formation_id' => $formation->getFormationId()));
        }

        return $this->render('@Formations/formation/new.html.twig', array(
            'formation' => $formation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a formation entity.
     *
     * @Route("/{formation_id}", name="formation_show")
     * @Method("GET")
     */
    public function showAction(formation $formation)
    {


        return $this->render('@Formations/formation/show.html.twig', array(
            'formation' => $formation,
        ));
    }

    /**
     * Displays a form to edit an existing formation entity.
     *
     * @Route("/{formation_id}/edit", name="formation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, formation $formation)
    {
        $editForm = $this->createForm('FormationsBundle\Form\formationType', $formation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_edit', array('formation_id' => $formation->getFormationId()));
        }

        return $this->render('@Formations/formation/edit.html.twig', array(
            'formation' => $formation,
            'edit_form' => $editForm->createView(),
        ));
    }




    /**
     * Deletes a formation entity.
     *
     * @Route("/delete/{formation_id}", name="formation_delete")
     * @Method("DELETE")
     */
    public function deleteAction($formation_id)
    {

        $formation = $this->getDoctrine()->getRepository('FormationsBundle:formation')->find($formation_id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('formation_index');
    }


    /**
     * Simulation
     *
     * @Route("/Simulation/{formation_id}", name="Simulation")
     * @Method({"GET", "POST"})
     */
    public function SimulationAction($formation_id)
    {

        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository("FormationsBundle:formation")->find($formation_id);
        $cour = $em->getRepository("FormationsBundle:cour")->findBySimulation($formation->getFormationId());
        return $this->render("@Formations/formation/Simulation.html.twig",array('cour'=>$cour,'formation'=>$formation));
    }




}
