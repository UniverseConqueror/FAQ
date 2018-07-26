<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Answer;

class AnswerController extends Controller
{
    /**
     * @Route("/answer/validate/{id}", name="answer_validate")
     */
    public function validate(Answer $answer)
    {
        // Valide réponse
        $answer->setIsValidated(true);
        // Valide question
        $answer->getQuestion()->setIsSolved(true);
        // Flush
        $this->getDoctrine()->getEntityManager()->flush();
        // Flash
        $this->addFlash('success', 'Réponse acceptée');
        // Redirection
        return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
    }
}
