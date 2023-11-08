<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[ORM\Assert\Sequentially()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $newsAuthor = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $newsDescription = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAtDateAndTime = null;

    #[ORM\Column(length: 255)]
    private ?string $newsTitle = null;

    #[ORM\OneToMany(mappedBy: 'news', targetEntity: Comments::class, fetch: 'EAGER')]
    private Collection $newsComments;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'news')]
    private Collection $tags;

    public function __construct()
    {
        $this->newsComments = new ArrayCollection();
        $this->tags= new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewsAuthor(): ?string
    {
        return $this->newsAuthor;
    }

    public function setNewsAuthor(string $newsAuthor): static
    {
        $this->newsAuthor = $newsAuthor;

        return $this;
    }

    public function getNewsDescription(): ?string
    {
        return $this->newsDescription;
    }

    public function setNewsDescription(string $newsDescription): static
    {
        $this->newsDescription = $newsDescription;

        return $this;
    }


    public function getCreatedAtDateAndTime(): ?\DateTimeInterface
    {

        return $this->createdAtDateAndTime;
    }

    public function setCreatedAtDateAndTime(\DateTimeInterface $createdAtDateAndTime): static
    {
        $this->createdAtDateAndTime = $createdAtDateAndTime;

        return $this;
    }

    public function getNewsTitle(): ?string
    {
        return $this->newsTitle;
    }

    public function setNewsTitle(string $newsTitle): static
    {
        $this->newsTitle = $newsTitle;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getNewsComments(): Collection
    {
        return $this->newsComments;
    }

    public function addNewsComment(Comments $newsComment): static
    {
        if (!$this->newsComments->contains($newsComment)) {
            $this->newsComments->add($newsComment);
            $newsComment->setNews($this);
        }

        return $this;
    }

    public function removeNewsComment(Comments $newsComment): static
    {
        if ($this->newsComments->removeElement($newsComment)) {
            // set the owning side to null (unless already changed)
            if ($newsComment->getNews() === $this) {
                $newsComment->setNews(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addCategory(Tags $tags): static
    {
        if (!$this->tags->contains($tags)) {
            $this->tags->add($tags);
        }

        return $this;
    }

    public function removeCategory(Tags $tags): static
    {
        $this->tags->removeElement($tags);

        return $this;
    }
}
