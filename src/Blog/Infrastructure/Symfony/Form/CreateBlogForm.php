<?php

namespace App\Blog\Infrastructure\Symfony\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;

final class CreateBlogForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 10, 'max' => 80])
                    ]
                ]
            )
            ->add(
                'content',
                TextareaType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 20])
                    ]
                ]
            )
            ->add(
                'image',
                FileType::class,
                [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new File(
                            [
                                'maxSize' => '1024k',
                                'mimeTypes' => ['image/jpeg'],
                                'mimeTypesMessage' => "Only jpg is allowed."
                            ]
                        )
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [

                ]
            );
    }
}