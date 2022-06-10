# Documentation technique d'un Site

Un Site est la représentation d'un site. Il contient des méta-données comme le titre ou l'icône du site.

Certaines actions nécessitent des droits pour pouvoir être réalisées. Ces droits sont définis et gérés dans la classe [App\Security\Admin\Voter\SiteVoter](../../../app/src/Controller/Admin/Site/SiteCRUDController.php).

## Création

Un Site peut être créé via la commande symfony `php bin/console cms:site:create <nom site>`. La classe [App\Controller\Admin\Site](../../../app/src/Command/Site/CreateSiteCommand.php) est responsable de cette commande.

Le nom du Site est le nom affiché dans l'onglet du navigateur et dans le lien des moteurs de recherche.  
Le service [App\Service\Site\SiteCreatorHelper](../../../app/src/Service/Site/SiteCreatorHelper.php) est en charge de la création d'un Site.  
**Il est important à noter qu'il ne peut y avoir qu'un seul Site.**  
**La gestion des multi-sites n'est pas prise en charge.**

La création d'un Site effectue une insertion en base de données.  
La classe [App\Entity\Site](../../../app/src/Entity/Site.php) est la représentation d'un Site en base de données.

## Affichage

Le controller [App\Controller\Admin\Site\SiteCRUDController](../../../app/src/Controller/Admin/Site/SiteCRUDController.php) est en charge de l'affichage d'un Site via une datagrid.  
Le service [App\Service\Site\SiteReaderService](../../../app/src/Service/Site/SiteReaderService.php) récupère le Site depuis la base de données.

Les extensions Twig [App\Twig\Admin\SiteTitle](../../../app/src/Twig/Admin/SiteTitle.php) et [App\Twig\Admin\SiteIcon](../../../app/src/Twig/Admin/SiteIcon.php) permettent respectivement de récupérer le titre du Site et l'icône du Site afin de l'afficher dans le navigateur.

## Mise à jour

Le controller [App\Controller\Admin\Site\SiteCRUDController](../../../app/src/Controller/Admin/Site/SiteCRUDController.php) est en charge de l'affichage et de la soumission du formulaire de mise à jour.  
L'icône du Site correspond à la petite image présente dans l'onglet du navigateur. Celle-ci est facultative.

## Suppression

Un Site **ne peut pas et ne doit pas être supprimé**. Des conséquences désastreuses pourraient avoir lieu en terme de fonctionnement du site internet et du SEO.

## Tests

Un ensemble de tests ont été mis en place pour vérifier le bon fonctionnement d'un Site. Les cas nominaux et les cas non désirés sont vérifiés. Vous trouverez les tests dans les dossiers [tests/Command/Site](../../../app/tests/Command/Site) et [tests/Controller/Admin/Site](../../../app/tests/Controller/Admin/Site).