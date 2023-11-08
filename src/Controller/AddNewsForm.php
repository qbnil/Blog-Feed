<?php

namespace App\Controller;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
class AddNewsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface  $builder, array $options)
    {
        $builder->add('newsAuthor', TextType::class);
        $builder->add('newsTitle', TextType::class);
        $builder->add('newsDescription', TextareaType::class);
        $builder->add('Tags', TextareaType::class, ['required' => false, 'constraints' => [new Regex(['pattern' => '#([\w]+)',
        'message' => 'Tags should be in the format #tag1, #tag2, #tag3',])]]);
        $builder->add('submit', SubmitType::class, ['label' => 'Add new']);
    }



}
