<?php

namespace TGTBundle\Controller;

use http\Env\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use TGTBundle\Entity\Casting;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Entity\CategorieFormation;
use TGTBundle\Form\CastingType;

/**
 * Casting controller.
 *
 * @Route("casting")
 */
class CastingController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filter = $request->get('filter');

        if (!empty($filter)) {
            $dql = "select p from  TGTBundle:Casting p where
                    p.titreCasting like :q or 
                    p.descriptionCasting like :q ";
            $query = $em->createQuery($dql)->setParameter("q", "%".$filter."%")->getResult();
        }else{
            $dql = "SELECT p from TGTBundle:Casting p";
            $query = $em->createQuery($dql);
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );


        if ($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('@TGT/front/Casting/_casting_content.html.twig', ['castings' => $pagination]),

            ]);
        }
        return $this->render('@TGT/front/Casting/indexCasting.html.twig', array(
            'castings' => $pagination,
        ));




    }


    public function newAction(Request $request)
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
            return $this->redirectToRoute('Casting_show');
        }

        return ($this->render('@TGT/front/Casting/addCasting.html.twig',array("form"=> $form->createView())));
    }

    public function showAction(Casting $casting)
    {
        $deleteForm = $this->createDeleteForm($casting);

        return $this->render('@TGT/front/Casting/showCasting.html.twig', array(
            'casting' => $casting,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Casting $casting)
    {
        $deleteForm = $this->createDeleteForm($casting);
        $editForm = $this->createForm('TGTBundle\Form\CastingType', $casting);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Casting_show', array('id' => $casting->getId()));
        }

        return $this->render('@TGT/front/Casting/editCasting.html.twig', array(
            'casting' => $casting,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $casting= $em->getRepository(Casting::class)->find($id);

        $em->remove($casting);

        $em->flush();

        return $this->redirectToRoute("Casting_show");
    }

    /**
     * Creates a form to delete a casting entity.
     *
     * @param Casting $casting The casting entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Casting $casting)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Casting_delete', array('id' => $casting->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }




    }
