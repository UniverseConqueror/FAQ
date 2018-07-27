# Sprint Sécurité

## Configurer le module de sécurité

Nous configurons le module avec notre entité User.

- On se base bien sûr sur la doc :) http://symfony.com/doc/current/security.html et ce que l'on a fait en cours.
- On modifie notre entité User pour matcher avec : http://symfony.com/doc/current/security/entity_provider.html.
- On migrate : en cas de soucis avec les données existantes ou erreur de contrainte d'intégrité, on drop la database, on la recreate.
- On modifie les fixtures pour y ajouter l'email.
- On ajoute le password encoder dans les fixtures.
- On configure le security.yaml (provider, encoder) on teste avec http_basic pour le moment.
- On reload de nouvelles fixtures.
- On va ajouter une route protégée juste pour tester le login, disons sur `/question/add`.
- Ca marche :)

## Login/logout

- On va enchainer avec la création d'un formulaire de login, cf : http://symfony.com/doc/current/security/form_login_setup.html.
- On va créer une classe de formulaire pour le login afin de bénéficier de tout le système (templates, messages d'erreurs). Cela nécessitera une configuration supplémentaire du .yaml, cf : http://symfony.com/doc/current/reference/configuration/security.html#username-parameter
- On ajoute le logout, cf : http://symfony.com/doc/current/security.html#logging-out
- On ajuste le template header pour gérer la nav user.

## Inscription

- Ajout du formulaire d'inscription => `make:form` basé sur `User` et on adapte.
- Ajout d'un controller `User` + gestion du form + encodage du mot de passe.

## Consulter mon compte

- Ajout d'une page profil : affichage info user + liens d'édition.
- Liste des questions : on reprend le partiel précédent (pas forcément le mieux ici mais ça peut s'optimiser plus tard).
- Liste des réponses : on fait le lien vers la question associée.
- A noter ici que les requêtes sont optimisable en faisant des jointures.

