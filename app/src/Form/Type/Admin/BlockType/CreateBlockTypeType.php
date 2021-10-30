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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * This class is used to define the block type form type.
 */
class CreateBlockTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'type',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'block-type.create.type',
                    'error_bubbling' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => BlockType::class]);
    }
}
