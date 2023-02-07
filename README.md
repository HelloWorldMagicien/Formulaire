# Formulaire
Formulaire sécurisé

Sécuriser un formulaire d'inscription

Nous avons ici un formulaire sécurisé d'inscription et de connexion sécurise. Dans ce formulaire les données sont chiffrer de bout en bout avec une méthode de chiffrement SHA-256.

Les données sont cryptées depuis le front-end grâce à du Javascript. Ainsi les données transitant vers le back-end sont encryptées et non compréhensible par une personne extérieure.

Pour empêcher un utilisateur de modifier le code javascript depuis la console de développeur et de nuire au bon fonctionnement du formulaire le code à été obfusqué grâce à l'outil « JavaScript Obfuscator Tool ».

La partie back-end prend aussi en compte et protège contre les injections SQL et les attaques de type XSS.

La base de données ne contient donc que des données cryptées ; dans le cadre d'une fuite de données, c'elles-ci ne donnent aucun renseignement personnels sur les utilisateurs

Manuel d'utilisation

-Télécharger le fichier ,zip et dé-zipper le,
-Mettez le fichier « Formulaire secu » dans le répertoire « www » de votre serveur Wamp (exemple de chemin vers le fichier « www » de wamp: C:\wamp64\www), 
-Ouvrez MySQLWorkbench et dans l'onglet server choisissez l'option data import, prenez l'option « Import from Self-Contained File » et mettez le chemin vers le fichier « Dump20230205.sql »et cliquez sur « start import »


Une fois cela fais, vous pouvez vous connecter avec le compte : identifiant:test
mot de passe:test

Vous pouvez aussi créer votre propre compte.
