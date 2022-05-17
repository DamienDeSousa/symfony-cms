<?php

/**
 * File that defines the CreateBlockTypeType class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Form\Type\Admin\BlockType;

use App\Entity\Structure\BlockType;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * This class is used to define the block type form type.
 */
class CreateBlockTypeType extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $files = $this->finder->files()->in($this->directoryPath . self::FORM_TYPE_BLOCK_RELATIVE_PATH);
        $choices = [];
        foreach ($files as $file) {
            $choices[$file->getRelativePathname()] = $file->getRelativePathname();
        }

        $builder
            ->add(
                'type',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'block-type.create.type',
                    'error_bubbling' => true
                ]
            )->add(
                'layout',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'block-type.create.layout',
                    'error_bubbling' => true
                ]
            )->add(
                'formType',
                ChoiceType::class,
                [
                    'choices' => $choices,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => BlockType::class]);
    }
}
