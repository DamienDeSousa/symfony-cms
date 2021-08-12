# symfony-cms

## ToDo

Appliquer les PSR  
Documenter les manip à faire  

Mettre en place les vérifications / logs  
Mettre en place un systeme de log via le logger   
S'assurer de la présence de la barre horizontale et latéral sur les pages admins  
Cache HTTP  
Cache applicatif  
Rédiger de la doc !  

## Installation

Il faut dans un premier temps posséder une première version stable.
git clone https://github.com/DamienDeSousa/symfony-cms.git  
make install  
make connection-php-container  
php bin/console fos:user:create  

## Configuration

## Utilisation

## Notes techniques
CMS

Un site est composé de plusieurs pages (OneToMany)
Une page ne comporte qu’un seul layout qui l’architecte (OneToOne)
Une page est composée de plusieurs blocs (ManyToMany)

Site:
- Title
- name
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

Changer la viariable d'environnement APP_ENV (dans le fichier .env) comme suit:  
APP_ENV=test  
Lancer ensuite la commande suivante pour exécuter tous les tests fonctionnels:  
./bin/phpunit
