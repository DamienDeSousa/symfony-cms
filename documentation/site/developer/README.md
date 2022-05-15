# Documentation technique d'un Site

## Création

Un Site peut être créé via la commande symfony `php bin/console cms:site:create <nom site>`. La classe [App\Command\Site\CreateSiteCommand](../../../app/src/Command/Site/CreateSiteCommand.php) est responsable de cette commande.

Le nom du Site sera le nom affiché dans l'onglet du navigateur et dans le lien des moteurs de recherche.  
Le service [App\Service\Site\SiteCreatorHelper](../../../app/src/Service/Site/SiteCreatorHelper.php) est en charge de la création d'un Site.  
**Il est important à noter qu'il ne peut y avoir qu'un seul Site.**  
**La gestion des multi-site n'est pas gérée.**

La création d'un Site effectue une insertion en base de données.  
La classe [App\Entity\Site](../../../app/src/Entity/Site.php) est la représentation d'un Site en base de données.

## Affichage

Le controller [App\Controller\Admin\Site\ShowSiteController](../../../app/src/Controller/Admin/Site/ShowSiteController.php) est en charge de l'affichage d'un Site.  
Le service [App\Service\Site\SiteReaderService](../../../app/src/Service/Site/SiteReaderService.php) récupère le Site depuis la base de données.  

## Mise à jour

Le controller [App\Controller\Admin\Site\UpdateSiteController](../../../app/src/Controller/Admin/Site/UpdateSiteController.php) est en charge de l'affichage et de la soumission du formulaire de mise à jour.  
Le service [App\Service\Site\SiteUpdaterService](../../../app/src/Service/Site/SiteUpdaterService.php) met à jour un Site en base de données.  
L'icône du Site correspond à la petite image présente dans l'onglet du navigateur. Celle-ci est facultative.  
La classe [App\Form\Type\Admin\Site\UpdateSiteType](../../../app/src/Form/Type/Admin/Site/UpdateSiteType.php) est la représentation du formulaire. A noter qu'il y a une contrainte sur le type de fichier et sur la taille de l'icône. **jpeg, png ou x-icon pour le type de fichier**, et **1024ko maximum pour la taille**.

## Suppression

Un Site **ne doit pas être supprimé**. Des conséquences désastreuses pourraient avoir lieu en terme de fonctionnement du site internet et du SEO.

## Tests

Un ensemble de tests ont été mis en place pour vérifier le bon fonctionnement d'un Site. Les cas nominaux et les cas non désirés sont vérifiés. Vous trouverez les tests dans les dossiers [tests/Command/Site](../../../app/tests/Command/Site) et [tests/Controller/Admin/Site](../../../app/tests/Controller/Admin/Site).