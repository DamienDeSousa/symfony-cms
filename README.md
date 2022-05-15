# symfony-cms

## ToDo

Appliquer les PSR  
Documenter les manip à faire  

Mettre en place les vérifications / logs  
Mettre en place un systeme de log via le logger  
Rédiger de la doc !  

## Installation

Il faut dans un premier temps posséder une première version stable.
git clone https://github.com/DamienDeSousa/symfony-cms.git  
make install  
make connection-php-container  
php bin/console fos:user:create  

## Utilisation

### Site

Vous trouverez le lien vers la documentation développeur du site [ici](documentation/site/developer/README.md).  
Vous trouverez le lien vers la documentation fonctionelle du site [ici](documentation/site/functional/README.md).

## Notes techniques
CMS

Un site est composé de plusieurs pages (OneToMany)
Une page ne comporte qu’un seul layout qui l’architecte (OneToOne)
Une page est composée de plusieurs blocs (ManyToMany)

Site:
- Title
- favicon

Page:
- (Id)
- Title
- Name
- layout
- Liste de blocs
- Route ? (Avec args ?)

Layout:
- Title
- Twig
- Type de layout ?
- Page ?

Bloc:
- Title
- Name
- Type (footer, header , etc..)
- Un twig  

### Création nouvel environnement

Pour créer un nouvel environnement il suffit de suivre la documentation à ce sujet.  
Il est toutefois à noter qu'il faut également vérifier les bundles à utiliser en fonctions des environnements (voir le fichier config/bundles.php).  
Si un bundle est nécessaire pour un environnement, il faut vérifier qu'il est bien retourné pour cet environnement dans le fichier config/bundles.php.  

## Exécution des tests fonctionnels

L'environnement test permet d'exécuter les tests fonctionnels de l'application.  
Dans cet environnement est défini une nouvelle base de données dans laquelle les fixtures peuvent être créer sans polluer la base de données de dev.

Changer la variable d'environnement APP_ENV (dans le fichier .env) comme suit:  
APP_ENV=test  
Lancer ensuite la commande suivante pour exécuter tous les tests fonctionnels:  
./bin/phpunit  

## Exposer une nouvelle route pour le Javascript (FosJsBundle)

Créer une route classique.  
Ajouter le name de la route dans config/packages/fos_js.yaml.  
Lancer la commande make expose-js-routes.  
Dans le javascript, faire appel à la route comme suit: Routing.generate('admin_site_update')  
