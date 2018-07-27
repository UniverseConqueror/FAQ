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

