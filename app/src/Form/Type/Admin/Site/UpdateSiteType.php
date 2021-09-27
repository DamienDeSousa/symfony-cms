<?php

/**
 * File that defines the Update site type class.
 *
 * @author    Damien DE SOUSA <desousadamien30@gmail.com>
 * @copyright 2021 Daùien DE SOUSA
 */

declare(strict_types=1);

namespace App\Form\Type\Admin\Site;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class used to define the form type of the update site form.
 */
class UpdateSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                //The following property allow the input label translation.
                //The translation is located in the messages.locale.yml
                'translation_domain' => 'messages',
                'label' => 'site.update.title',
                //By default, errors are deplayed under each input, if the following property is enabled
                //then errors are displayed separatly from the corresponding input.
                'error_bubbling' => true
            ]
        )->add(
            'icon',
            FileType::class,
            [
                'translation_domain' => 'messages',
                'label' => 'site.update.icon',
                //This property is not mapped with the icon Site property (the entity)
                //because in the form it is a file and in the entity it is a string.
                'mapped' => false,
                'required' => false,
                'error_bubbling' => true,
                //Define the constraint here and not in the entity because the icon property in not mapped.
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/x-icon'
                        ],
                        'mimeTypesMessage' => 'site.update.icon.error.mimetypes',
                    ])
                ],
                'help' => 'site.update.icon_help'
            ]
        )->add(
            'save',
            SubmitType::class,
            [
                'label' => 'site.update.save',
                'translation_domain' => 'messages',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Site::class]);
    }
}
