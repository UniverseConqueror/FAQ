<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Tag;
use App\Form\QuestionType;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use App\Entity\User;

class QuestionController extends Controller
{
    /**
     * @Route("/", name="question_list")
     * @Route("/tag/{name}", name="question_list_by_tag")
     * @ParamConverter("tag", class="App:Tag")
     */
    public function list(Request $request, QuestionRepository $questionRepository, Tag $tag = null)
    {
        // On vérifie si on vient de la route "question_list_by_tag"
        if($request->attributes->get('_route') == 'question_list_by_tag' && $tag === null) {
            // On récupère le name passé dans l'attribut de requête
            $params = $request->attributes->get('_route_params');
            $selectedTag = $params['name'];
            // Equivaut à $selectedTag = $request->attributes->get('_route_params')['name'];

            // Flash + redirect
            $this->addFlash('success', 'Le mot-clé "'.$selectedTag.'" n\'existe pas. Affichage de toutes les questions.');
            return $this->redirectToRoute('question_list');
        }

        // On va chercher la liste des questions par ordre inverse de date
        if($tag) {
            // Avec tag
            $questions = $questionRepository->findByTag($tag);
            $selectedTag = $tag->getName();
        } else {
            // Sans tag
            $questions = $questionRepository->findBy([], ['createdAt' => 'DESC']);
            $selectedTag = null;
        }

        // Nuage de mots-clés
        $tags = $this->getDoctrine()->getRepository(Tag::class)->findBy([], ['name' => 'ASC']);

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'tags' => $tags,
            'selectedTag' => $selectedTag,
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_show", requirements={"id": "\d+"})
     */
    public function show(Question $question, Request $request, UserRepository $userRepository)
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $answer = $form->getData();
            // On associe Réponse
            $answer->setQuestion($question);

            // User : pour le moment, allons chercher un user issue de notre liste
            $user = $userRepository->findOneByUsername('jc');
            // On associe user
            $answer->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($answer);
            $entityManager->flush();

            $this->addFlash('success', 'Réponse ajoutée');

            return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
        }

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/question/add", name="question_add")
     */
    public function add(Request $request, UserRepository $userRepository)
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $question = $form->getData();

            // User : pour le moment, allons chercher un user issue de notre liste
            $user = $userRepository->findOneByUsername('jc');
            // On associe
            $question->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            $this->addFlash('success', 'Question ajoutée');

            return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
