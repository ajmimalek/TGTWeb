<?php

namespace TGTBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use TGTBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use TGTBundle\Entity\Reponse;
use TGTBundle\TGTBundle;

/**
 * Question controller.
 *
 * @Route("question")
 */
class QuestionController extends Controller
{

    public function readAction()
    {

        $Question = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render("@TGT/front/question/showQuestion.html.twig", array('Question' => $Question
            ));
    }

    /**
     * Lists all question entities.
     *
     * @Route("/", name="question_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $Question = $em->getRepository('TGTBundle:Question')->findAll() ;

        $Reponse = $em->getRepository('TGTBundle:Reponse')->findAll();



        return $this->render('@TGT/front/question/showQuestion.html.twig', array(
            'Question' => $Question ,
            'Reponse' => $Reponse,

        ));
    }

    /**
     * Creates a new question entity.
     *
     * @Route("/new", name="question_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $question = new Question();
        $question->setDateQuestion(new  \DateTime());
        $form = $this->createForm('TGTBundle\Form\QuestionType', $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('Question_show', array('id' => $question->getId()));
        }

        return $this->render('@TGT/front/Question/addQuestion.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     * @Route("/{id}", name="question_show")
     * @Method("GET")
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $question = $this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('@TGT/front/Question/showQuestion.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}/edit", name="question_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('TGTBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Question_show', array('id' => $question->getId()));
        }

        return $this->render('@TGT/front/Question/editQuestion.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $Question= $em->getRepository(Question::class)->find($id);

        $em->remove($Question);

        $em->flush();

        return $this->redirectToRoute("Question_show");
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


 //->findBy(array('contenu'=>$contenu)) ;
    public function rechercheAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository(Question::class)->findAll();

        if($request->isMethod("POST")) {

            $contenu1 = $request->get('contenu1');

            $questions = $em->getRepository("TGTBundle:Question")->findBysimulation2($contenu1);

        }

        return $this->render("@TGT/front/Question/rechercheQusetion.html.twig",array(
            'questions' => $questions
            ));
    }






    public function afficheQuestionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Theme = $em->getRepository("TGTBundle:Theme")->find($id);
        $Question = $em->getRepository("TGTBundle:Question")->findByafficheQ($Theme->getId());
        return $this->render("@TGT/front/Question/showQuestion.html.twig",array('Question'=>$Question,'Theme'=>$Theme));
    }


    public function calculerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Question = $em -> getRepository("TGTBundle:Question")->find($id);
        $Reponse = $em->getRepository("TGTBundle:Reponse")->findBycalculerR($Question->getId());

        return $this->render("@TGT/front/Question/showQuestion.html.twig", array('Question' => $Question, 'result'=>$Reponse
        ));

    }



}
