<?php

/**
 * Defines the BlockTypeCRUDController class.
 *
 * @author Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Controller\Admin\BlockType;

use App\Entity\Structure\BlockType;
use Symfony\Component\Finder\Finder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * Defines the CRUD actions for a block type.
 */
class BlockTypeCRUDController extends AbstractCrudController
{
    public const FORM_TYPE_BLOCK_RELATIVE_PATH = '/src/Form/Type/Block';

    /** @var Finder */
    private $finder;

    /** @var string */
    private $directoryPath;

    public function __construct(string $directoryPath)
    {
        $this->finder = new Finder();
        $this->directoryPath = $directoryPath;
    }

    /**
     * @inheritdoc
     */
    public static function getEntityFqcn(): string
    {
        return BlockType::class;
    }

    /**
     * @inheritdoc
     */
    public function configureCrud(Crud $crud): Crud
    {
        return $crud->renderContentMaximized();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::BATCH_DELETE, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::SAVE_AND_ADD_ANOTHER, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::DETAIL, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::INDEX, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::SAVE_AND_CONTINUE, 'ROLE_SUPER_ADMIN')
            ->setPermission(Action::SAVE_AND_RETURN, 'ROLE_SUPER_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type', 'block-type.grid.type')
                ->setMaxLength(100),
            TextField::new('layout', 'block-type.grid.layout')
                ->setMaxLength(255),
            ChoiceField::new('formType', 'block-type.grid.form-type')
                ->setChoices($this->getAvailableFormTypes()),
        ];
    }

    private function getAvailableFormTypes(): array
    {
        $files = $this->finder->files()->in($this->directoryPath . self::FORM_TYPE_BLOCK_RELATIVE_PATH);
        $choices = [];
        foreach ($files as $file) {
            $choices[$file->getRelativePathname()] = $file->getRelativePathname();
        }

        return $choices;
    }
}
