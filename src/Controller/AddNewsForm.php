<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\News;
class AddNewsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder->add('newsAuthor', TextType::class);
        $builder->add('newsTitle', TextType::class);
        $builder->add('newsDescription', TextareaType::class);
        $builder->add('tags', CollectionType::class, [
            'entry_type' => TagType::class,
            'entry_options' => ['label' => false],
            'allow_add' => true,
        ]);
        $builder->add('Submit', SubmitType::class, ['label' => 'Add new']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
            'required' => false,
        ]);
    }



}
