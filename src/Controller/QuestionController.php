<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;

class QuestionController extends Controller
{
    /**
     * @Route("/", name="question_list")
     */
    public function list(QuestionRepository $questionRepository)
    {
        // On va chercher la liste des questions par ordre inverse de date
        $questions = $questionRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_show")
     */
    public function show(Question $question)
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

}
