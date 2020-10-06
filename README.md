# symfony-cms

## ToDo

Appliquer les PSR  
Mettre des commentaires  
Documenter les manip à faire  

Mettre en place les vérifications / logs  
Mettre en place un systeme de log via le logger  
Créer une page de configuration gloale du site permettant de gérer: Title, icon  
Mettre captcha sur page de login admin  
Ajouter tests fonctionnels  
Cache HTTP  
Cache applicatif  
Décorer la méthode FOS\UserBundle\Command\PromoteUserCommand->executeRoleCommand(...) pour empecher de saisir un role qui n'existe pas  
Même chose pour la méthode FOS\UserBundle\Command\DemoteUserCommand->executeRoleCommand(...)  
Créer un nouvel env pour exécuter les tests fonctionnels  
Rédiger de la doc !  

## Installation

Il faut dans un premier temps posséder une première version stable.

## Configuration

## Utilisation

## Notes techniques

### Création nouvel environnement

Pour créer un nouvel environnement il suffit de suivre la documentation à ce sujet.  
Il est toutefois à noter qu'il faut également vérifier les bundles à utiliser en fonctions des environnements (voir le fichier config/bundles.php).  
Si un bundle est nécessaire pour un environnement, il faut vérifier qu'il est bien retourné pour cet environnement dans le fichier config/bundles.php.  

### Exécution des tests fonctionnels

L'environnement functional_test permet d'exécuter les tests fonctionnels de l'application.  
Dans cet environnement est défini une nouvelle base de données dans laquelle les fixtures peuvent être créer sans polluer la base de données de dev.  
