<?php

/**
 * File that defines the CreatePageTemplateBlockTypeType class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2022
 */

declare(strict_types=1);

namespace App\Form\Type\Admin\PageTemplateBlockType;

use App\Entity\Structure\BlockType;
use App\Entity\Structure\PageTemplate;
use Symfony\Component\Form\AbstractType;
use App\Entity\Structure\PageTemplateBlockType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\Structure\BlockTypeRepository;
use App\Repository\Structure\PageTemplateRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * This class is used to define the page template block type form type.
 */
class CreatePageTemplateBlockTypeType extends AbstractType
{
    /** @var PageTemplateRepository */
    private $pageTemplateRepository;

    /** @var BlockTypeRepository */
    private $blockTypeRepository;

    public function __construct(
        PageTemplateRepository $pageTemplateRepository,
        BlockTypeRepository $blockTypeRepository
    ) {
        $this->pageTemplateRepository = $pageTemplateRepository;
        $this->blockTypeRepository = $blockTypeRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pageTemplates = $this->pageTemplateRepository->findAllBy(['name' => 'ASC']);
        $blockTypes = $this->blockTypeRepository->findAllBy(['type' => 'ASC']);
        $builder
            ->add(
                'slug',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'page-template-block-type.create.slug',
                    'error_bubbling' => true
                ]
            )->add(
                'pageTemplate',
                ChoiceType::class,
                [
                    'choices' => $pageTemplates,
                    'choice_value' => 'id',
                    'choice_label' => function (?PageTemplate $pageTemplate) {
                        return $pageTemplate ? ucfirst($pageTemplate->getName()) : '';
                    },
                    'translation_domain' => 'messages',
                    'label' => 'page-template-block-type.create.page-template',
                    'error_bubbling' => true,
                ]
            )->add(
                'blockType',
                ChoiceType::class,
                [
                    'choices' => $blockTypes,
                    'choice_value' => 'id',
                    'choice_label' => function (?BlockType $blockType) {
                        return $blockType ? ucfirst($blockType->getType()) : '';
                    },
                    'translation_domain' => 'messages',
                    'label' => 'page-template-block-type.create.block-type',
                    'error_bubbling' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => PageTemplateBlockType::class]);
    }
}
