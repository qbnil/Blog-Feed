<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $commentAuthor = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentContent = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $commentDate = null;
    #[ORM\ManyToOne(targetEntity: News::class, inversedBy: 'newsComments')]
    private $news;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentAuthor(): ?string
    {
        return $this->commentAuthor;
    }

    public function setCommentAuthor(string $commentAuthor): static
    {
        $this->commentAuthor = $commentAuthor;

        return $this;
    }

    public function getCommentContent(): ?string
    {
        return $this->commentContent;
    }

    public function setCommentContent(string $commentContent): static
    {
        $this->commentContent = $commentContent;

        return $this;
    }

    public function getCommentDate(): ?\DateTimeInterface
    {
        return $this->commentDate;
    }

    public function setCommentDate(\DateTimeInterface $commentDate): static
    {
        $this->commentDate = $commentDate;

        return $this;
    }





    public function getNews(): ?News
    {
        return $this->news;
    }

    public function setNews(?News $news): self
    {
        $this->news = $news;

        return $this;
    }
}
