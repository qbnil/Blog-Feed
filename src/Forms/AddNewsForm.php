<?php
namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class AddNewsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('newsAuthor', TextType::class);
        $builder->add('newsTitle', TextType::class);
        $builder->add('newsDescription', TextareaType::class);
        $builder->add('YourTags', TextareaType::class, ['mapped' => false, 'constraints' => new Regex( pattern: '/\w+|(?!;$);/', message: 'Follow the pattern: tag1;tag2;tag3...', match: true), 'required' => false]);
        $builder->add('Submit', SubmitType::class, ['label' => 'Add new']);
    }

}
