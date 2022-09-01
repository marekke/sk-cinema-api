<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[UniqueEntity('movieTitle')]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[NotNull]
    #[NotBlank]
    private ?string $movieTitle = null;

    #[ORM\Column]
    #[NotNull]
    #[NotBlank]
    private ?int $movieTime = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: Show::class, orphanRemoval: false)]
    #[Ignore]
    private Collection $shows;

    public function __construct()
    {
        $this->shows = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovieTitle(): ?string
    {
        return $this->movieTitle;
    }

    public function setMovieTitle(string $movieTitle): self
    {
        $this->movieTitle = $movieTitle;

        return $this;
    }

    public function getMovieTime(): ?int
    {
        return $this->movieTime;
    }

    public function setMovieTime(int $movieTime): self
    {
        $this->movieTime = $movieTime;

        return $this;
    }

    /**
     * @return Collection<int, Show>
     */
    public function getShows(): Collection
    {
        return $this->shows;
    }

    public function addShow(Show $show): self
    {
        if (!$this->shows->contains($show)) {
            $this->shows->add($show);
            $show->setMovie($this);
        }

        return $this;
    }

    public function removeShow(Show $show): self
    {
        if ($this->shows->removeElement($show)) {
            // set the owning side to null (unless already changed)
            if ($show->getMovie() === $this) {
                $show->setMovie(null);
            }
        }

        return $this;
    }
}
