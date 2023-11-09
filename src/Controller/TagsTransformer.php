<?php
namespace App\Controller;

use App\Entity\Tags;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
{
    // transform the ArrayCollection of Tags into a string of tag names
    public function transform($tags): ?string
    {
        if (!$tags instanceof ArrayCollection) {
            $tags = new ArrayCollection();
        }

        return implode(';', $tags->getValues());
    }

    // transform the string of tag names into an ArrayCollection of Tags
    public function reverseTransform($tagString): ArrayCollection
    {
        $tagNames = explode(';', $tagString);
        $tags = new ArrayCollection();

        foreach ($tagNames as $tagName) {
            $tag = new Tags();
            $tag->setName(trim($tagName));
            $tags->add($tag);
        }

        return $tags;
    }
}