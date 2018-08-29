# Sprint Bonus

## Voter +1 sur question et réponse

- On ajoute les relations entre vote et question dans l'entité User.
    - Afin que le couple User/Question soit unique, créons une entité UserQuestionVote donc la clé primaire sera composée sur les 2 ids.
- Ajout d'un bouton pour voter sur le template question, qui va renvoyer vers une méthode pour créer une nouveau vote et y associer le user et la question.
    - En cas de doublon on intercepte l'exception et on affiche un Flash Message comme quoi on a déjà voté sur cette question.
    - => attention si on oublie le `use` de l'Exception ça ne le précise par et l'erreur n'est pas catchée.

## Questions/réponses bloquées visibles par modérateur

- Ajout d'une `AuthorizationCheckerInterface` sur Question `list()` et `show()`.
- Conditionnement du critère de recherche selon si modérateur ou non.
- Modification de la requête custom `findByTag()` pour traiter ce cas.
- Rien à faire côté template, tout se situe au niveau des requêtes.