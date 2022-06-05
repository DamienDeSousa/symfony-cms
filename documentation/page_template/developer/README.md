# Documentation technique du Page Template (patron de page)

Un Page Template est le patron global qui est utilisé pour créer une Page.

Un Page Template est associé à zéro ou plusieurs Block Type via une entité intermédiaire Page Template Block Type.

Les droits pour manipuler un Page Template sont définis dans la classe [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).

## Création

Le controller [App\Controller\Admin\PageTemplate\CreatePageTemplateController](../../../app/src/Controller/Admin/PageTemplate/CreatePageTemplateController.php) affiche et gère la soumission du formulaire de création d'un Page Template.  
Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).  
L'entité [App\Entity\Structure\PageTemplate](../../../app/src/Entity/Structure/PageTemplate.php) représente un Page Template en base de données. Il y a une contrainte d'unicité sur les champs name et layout. Un layout est le chemin complet vers le fichier twig contenant la structure globale d'une page.  

**Seul un administrateur avec les super droits peut effectuer la création d'un Page Template.**

## Affichage

### Grille

La grille affiche la liste de tous les Pages Templates existants. Les colonnes à afficher ainsi que les actions réalisables sont définis dans la classe [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).

## <a name="maj"></a>Mise à jour

L'affichage et la soumission du formulaire de mise à jour (maj) est effectué par le controller [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).

Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).  

## <a name="delete"></a>Suppression

La suppression d'un Page Template se réalise via le controller [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php)

## Tests

Tout un ensemble de tests ont été mis en place pour vérfier le bon fonctionnement des cas nominaux et des cas non désirés. Ils sont présents dans le dossier [tests/Controller/Admin/PageTemplate](../../../app/tests/Controller/Admin/PageTemplate).