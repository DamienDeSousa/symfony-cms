# Documentation technique du Block Type (type de block)

Un Block Type est le patron global qui est utilisé pour créer un block.

Un Block Type est associé à zéro ou plusieurs Page Template via une entité intermédiaire Page Template Block Type.

Les droits pour manipuler un Block Type sont définis dans la classe [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).

## Création

Le controller [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php) affiche et gère la soumission du formulaire de création d'un Block Type.  
Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).  
L'entité [App\Entity\Structure\BlockType](../../../app/src/Entity/Structure/BlockType.php) représente un Block Type en base de données. Il y a une contrainte d'unicité sur les champs type et layout. Un layout est le chemin complet vers le fichier twig contenant la structure globale d'un block.  

## Grille

La grille affiche la liste de tous les Blocks Types existants. Les colonnes à afficher ainsi que les actions réalisables sont définis dans la classe [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).

## <a name="maj"></a>Mise à jour

L'affichage et la soumission du formulaire de mise à jour (maj) est effectué par le controller [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).

Le formType est définit dans la méthode `configureFields` de la classe [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).  

## <a name="delete"></a>Suppression

La suppression d'un Block Type se réalise via le controller [App\Controller\Admin\BlockType\BlockTypeCRUDController](../../../app/src/Controller/Admin/BlockType/BlockTypeCRUDController.php).

## Tests

Tout un ensemble de tests ont été mis en place pour vérfier le bon fonctionnement des cas nominaux et des cas non désirés. Ils sont présents dans le dossier [tests/Controller/Admin/BlockType](../../../app/tests/Controller/Admin/BlockType).