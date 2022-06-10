# Documentation technique du dashboard

## Page d'accueil

La méthode `index()` de la classe [App\Controller\Admin\Index](../../../app/src/Controller/Admin/Index.php) retourne la **Response** contenant la page d'accueil à afficher.  
Le template comme la méthode sont ouvert à la surcharge selon les besoins.  

## Configuration des paramètres généraux

La méthode `configureDashboard()` de la classe [App\Controller\Admin\Index](../../../app/src/Controller/Admin/Index.php) configure les informations générales du site.  
Dans cette classe, nous définissons le titre du dashboard (visible en en-tête) et l'icône du site si elle existe.  
Le template comme la méthode sont ouvert à la surcharge selon les besoins.  

## Configuration du menu

La méthode `configureMenuItems()` de la classe [App\Controller\Admin\Index](../../../app/src/Controller/Admin/Index.php) configure les entrées possible dans le menu de gauche.  
