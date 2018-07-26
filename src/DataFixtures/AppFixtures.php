<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;

use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On crée une instance de Faker en français
        $generator = Faker\Factory::create('fr_FR');

        // On passe le Manager de Doctrine à Faker !
        $populator = new Faker\ORM\Doctrine\Populator($generator, $manager);

        // Users : seront créés en dur pour pouvoir les manipuler en attendant le module de sécurité
        $users = array('claire', 'jc', 'micheline', 'jeanette', 'victoria', 'gertrude', 'roland', 'marc', 'alfred', 'michel');
        $usersEntities = array();

        foreach($users as $u) {
            // New user bases on list
            $user = new User();
            $user->setUsername(\ucfirst($u));
            $user->setPassword($u);
            // Add it to the list of entities
            $usersEntities[] = $user;
            // Persist
            $manager->persist($user);
        }

        // Tags
        $populator->addEntity('App\Entity\Tag', 10, [
            'name' => function () use ($generator) {
                return $generator->unique()->word();
            },
        ]);

        // Questions
        $populator->addEntity('App\Entity\Question', 30, [
            'title' => function () use ($generator) {
                return (rtrim($generator->unique()->sentence($nbWords = 9, $variableNbWords = true), '.') . ' ?');
            },
            'body' => function () use ($generator) {
                return $generator->unique()->paragraph($nbSentences = 6, $variableNbSentences = true);
            },
            'createdAt' => function () use ($generator) {
                return $generator->unique()->dateTime($max = 'now', $timezone = null);
            },
            'votes' => 0,
            'user' => function () use ($generator, $usersEntities) {
                return $usersEntities[$generator->numberBetween($min = 0, $max = (count($usersEntities)-1))];
            },
        ]);

        // Answers
        $populator->addEntity('App\Entity\Answer', 50, [
            'body' => function () use ($generator) {
                return $generator->unique()->paragraph($nbSentences = 3, $variableNbSentences = true);
            },
            'createdAt' => function () use ($generator) {
                return $generator->unique()->dateTime($max = 'now', $timezone = null);
            },
            'votes' => 0,
            'user' => function () use ($generator, $usersEntities) {
                return $usersEntities[$generator->numberBetween($min = 0, $max = (count($usersEntities)-1))];
            },
        ]);
        // Exécution et récupération dse entités ajoutées par Faker
        $insertedEntities = $populator->execute();

        // On doit ajouter manuellement des données pour les ManyToMany
        // Depuis les données insérées :
        $tags = $insertedEntities['App\Entity\Tag'];
        $questions = $insertedEntities['App\Entity\Question'];

        // Tags sur questions
        foreach ($questions as $question) {
            // On mélange les tags et on en récupère 1 à 3 au hasard
            shuffle($tags);
            $tagCount = mt_rand(1, 3);
            for ($i = 1; $i <= $tagCount; $i++) {
                $question->addTag($tags[$i]);
            }
        }
        // Flush
        $manager->flush();
    }
}
