# symfony-cms

## ToDo

Appliquer les PSR  
Mettre des commentaires  
Documenter les manip à faire  

Mettre en place les vérifications / logs  
Mettre en place un systeme de log via le logger  
Créer une page de configuration gloale du site permettant de gérer: Title, icon  
Mettre captcha sur page de login admin  
Ajouter tests fonctionnels sur page accueil, page login admin, page accueil admin, page affichage site  
S'assurer de la présence de la barre horizontale et latéral sur les pages admins  
Cache HTTP  
Cache applicatif  
Créer un nouvel env pour exécuter les tests fonctionnels  
Rédiger de la doc !  
Extraire la gestion des erreurs, du last login et de l'affichage du captcha dans des services.  

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
