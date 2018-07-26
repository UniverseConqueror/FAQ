# Sprint Base

## Intégrer le layout principal

Depuis les wireframes nos intégrons notre layout principal avec Bootstrap (ou autre CSS selon vos préférences). On va donc devoir créer un premier contrôleur qui correspond à la page d'accueil. On ajoute une CSS custom pour peaufiner.

## Afficher la liste des questions

- On va chercher la liste des questions, on l'envoie à la vue.
- Attention : on a dû ajouter un champ "isSolved" sur l'entité Question afin d'indiquer si la question détient une réponse acceptée ou non (on a l'info directement depuis l'objet Question).
- On fait un affichage minimaliste mais efficace (voir CSS custom).

## Afficher une page question

### Question

- On va la chercher et on affiche toutes ses infos.
- On en profite pour mutualiser le bloc qui affiche les infos sur la home avec celui-ci (pas toujours une bonne idée mais ici ça s'y prête plutôt bien). On adapte le code du partial selon une variable transmise à l'include.

### Réponses

- On boucle sur les réponses et on les affiche.
- Pour afficher la réponse validée en premier on peut utiliser une requête custom ou bien utiliser l'annotation `@ORM\OrderBy` sur l'entité Question vers Answer. On peut également en profiter pour classer par date de création les autres réponses.
- On conditionne le style graphique de la réponse dans notre CSS.

## Poser une question

- On crée un formulaire avec `php bin/console make:form`
- On installe le formulaire sur la page "Poser une question"
- On supprime tous les champs que le ne doit pas modifier et on gère les valeurs par défaut dans le `__construct` de l'entité.
- On associe un user à la question (pour le moment un user choisi dans les existants).
- On gère les contraintes, les flashs.

## Proposer une réponse

- On crée un formulaire avec `php bin/console make:form`
- On installe le formulaire sur la page "Question"
- On supprime tous les champs que le ne doit pas modifier et on gère les valeurs par défaut dans le `__construct` de l'entité.
- On gère les contraintes, les flashs.

## Accepter une réponse

- Pour le moment on se contente d'ajouter un lien de validation, on gèrera les droits plus tard.