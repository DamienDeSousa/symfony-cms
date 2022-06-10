# Documentation technique du Page Template Block Type (patron de page type de block)

Un Page Template Block Type est le entre un Page Template et un Block Type.  
Il possède un slug permettant de l'identifier de manière unique pour un duo Page Template / Block Type donné.

Les droits pour manipuler un Page Template sont définis dans la classe [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php).

## Création

Le controller [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php) affiche et gère la soumission du formulaire de création d'un Page Template Block Type.  
Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php).  
L'entité [App\Entity\Structure\PageTemplateBlockType](../../../app/src/Entity/Structure/PageTemplateBlockType.php) représente un Page Template Block Type en base de données. Il y a une contrainte d'unicité sur l'union des champs slug, pageTemplate et blockType.

## Affichage

### Grille

La grille affiche la liste de tous les Page Template Block Types existants. Les colonnes à afficher ainsi que les actions réalisables sont définis dans la classe [App\Controller\Admin\PageTemplate\PageTemplateCRUDController](../../../app/src/Controller/Admin/PageTemplate/PageTemplateCRUDController.php).

## <a name="maj"></a>Mise à jour

L'affichage et la soumission du formulaire de mise à jour (maj) est effectué par le controller [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php).

Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php).

## <a name="delete"></a>Suppression

La suppression d'un Page Template se réalise via le controller [App\Controller\Admin\PageTemplateBlockType\PageTemplateBlockTypeCRUDController](../../../app/src/Controller/Admin/PageTemplateBlockType/PageTemplateBlockTypeCRUDController.php).

## Tests

Tout un ensemble de tests ont été mis en place pour vérfier le bon fonctionnement des cas nominaux et des cas non désirés. Ils sont présents dans le dossier [tests/Controller/Admin/PageTemplateBlockType](../../../app/tests/Controller/Admin/PageTemplateBlockType).