# Documentation technique du Page Template (patron de page)

Un Page Template est le patron global qui est utilisé pour créer une Page.

Un Page Template est associé à zéro ou plusieurs Block Type via une entité intermédiaire Page Template Block Type.

Certaines des actions suivantes nécessitent des droits plus ou moins élevés. Ces droits sont définis et gérés dans la classe [App\Security\Admin\Voter](../../../app/src/Security/Admin/Voter/PageTemplateVoter.php).

## Création

Le controller [App\Controller\Admin\PageTemplate\CreatePageTemplateController](../../../app/src/Controller/Admin/PageTemplate/CreatePageTemplateController.php) affiche et gère la soumission du formulaire de création d'un Page Template.  
Le service [App\Service\Structure\PageTemplate\PageTemplateCreatorService](../../../app/src/Service/Structure/PageTemplate/PageTemplateCreatorService.php) retourne un nouveau Page Template et effectue l'insertion en base de données.  
Le formType [App\Form\Type\Admin\PageTemplate\CreatePageTemplateType](../../../app/src/Form/Type/Admin/PageTemplate/CreatePageTemplateType.php) représente le formulaire de création d'un Page Template.  
L'entité [App\Entity\Structure\PageTemplate](../../../app/src/Entity/Structure/PageTemplate.php) représente un Page Template en base de données. Il y a une contrainte d'unicité sur les champs name et layout. Un layout est le chemin complet vers le fichier twig contenant la structure globale d'une page.  

**Seul un administrateur avec les super droits peut effectuer la création d'un Page Template.**

## Affichage

### Grille

La grille affiche la liste de tous les Pages Templates existants. Les colonnes à afficher ainsi que les actions réalisables sont définis dans la classe [App\Controller\Admin\PageTemplate\GridPageTemplateController](../../../app/src/Controller/Admin/PageTemplate/GridPageTemplateController.php).

Chaque élément présent dans la grille possède trois actions possible représentées par trois boutons:
- un bouton bleu permettant d'afficher le détail d'un Page Template (voir la section [Détail](#detail))
- un bouton jaune permettant de modifier un Page Template (voir la section [Mise à jour](#maj))
- un bouton rouge permettant de supprimer un Page Template (voir la section [Suppression](#delete))

### <a name="detail"></a>Détail

L'affichage du détail est géré par le controller [App\Controller\Admin\PageTemplate\ShowPageTemplateController](../../../app/src/Controller/Admin/PageTemplate/ShowPageTemplateController.php).  Seuls les attributs retrounés par la méthode `PageTemplate::toArray()` sont présents dans le détail.

## <a name="maj"></a>Mise à jour

L'affichage et la soumission du formulaire de mise à jour (maj) est effectué par le controller [App\Controller\Admin\PageTemplate\UpdatePageTemplateController](../../../app/src/Controller/Admin/PageTemplate/UpdatePageTemplateController.php).

Il utilise le service [App\Service\Structure\PageTemplate\PageTemplateCreatorService](../../../app/src/Service/Structure/PageTemplate/PageTemplateCreatorService.php) afin de réaliser la maj en base de données. Il s'agit du même service que pour la création.

Le formType [App\Form\Type\Admin\PageTemplate\CreatePageTemplateType](../../../app/src/Form/Type/Admin/PageTemplate/CreatePageTemplateType.php) représente le formulaire de maj d'un Page Template. Il s'agit du même formType que pour la création.

## <a name="delete"></a>Suppression

La suppression d'un Page Template depuis le BO se réalise via le controller [App\Controller\Admin\PageTemplate\DeletePageTemplateController](../../../app/src/Controller/Admin/PageTemplate/DeletePageTemplateController.php).

Il utilise le service [App\Service\Structure\PageTemplate\PageTemplateDeleterService](../../../app/src/Service/Structure/PageTemplate/PageTemplateDeleterService.php) afin d'effectuer la suppression en base de données.

## Tests

Tout un ensemble de tests ont été mis en place pour vérfier le bon fonctionnement des cas nominaux et des cas non désirés. Ils sont présents dans le dossier [tests/Controller/Admin/PageTemplate](../../../app/tests/Controller/Admin/PageTemplate).