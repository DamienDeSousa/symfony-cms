<?php

/**
 * File that defines the CreatePageTemplateType class.
 *
 * @author    Damien DE SOUSA
 * @copyright 2021 Damien DE SOUSA
 */

declare(strict_types=1);

namespace App\Form\Type\Admin\PageTemplate;

use App\Entity\Structure\PageTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * This class is used to define the page template form type.
 */
class CreatePageTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'page-template.create.name',
                    'error_bubbling' => true
                ]
            )->add(
                'layout',
                TextType::class,
                [
                    'translation_domain' => 'messages',
                    'label' => 'page-template.create.layout',
                    'error_bubbling' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => PageTemplate::class]);
    }
}
