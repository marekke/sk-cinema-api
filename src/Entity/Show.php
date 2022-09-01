<?php

namespace App\Entity;

use App\Repository\ShowRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ShowRepository::class)]
#[ORM\Table("`show`")]
class Show
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[NotNull]
    private ?\DateTimeInterface $showDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[NotNull]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\ManyToOne(inversedBy: 'shows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movie $movie = null;

    #[ORM\ManyToOne(inversedBy: 'shows')]
    private ?Room $room = null;

    #[ORM\OneToMany(mappedBy: 'show', targetEntity: ShowSeat::class, orphanRemoval: true)]
    private Collection $showSeats;

    public function __construct()
    {
        $this->showSeats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShowDate(): ?\DateTimeInterface
    {
        return $this->showDate;
    }

    public function setShowDate(\DateTimeInterface $showDate = null): self
    {
        $this->showDate = $showDate;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime = null): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    /**
     * @return Collection<int, ShowSeat>
     */
    public function getShowSeats(): Collection
    {
        return $this->showSeats;
    }

    public function addShowSeat(ShowSeat $showSeat): self
    {
        if (!$this->showSeats->contains($showSeat)) {
            $this->showSeats->add($showSeat);
            $showSeat->setShow($this);
        }

        return $this;
    }

    public function removeShowSeat(ShowSeat $showSeat): self
    {
        if ($this->showSeats->removeElement($showSeat)) {
            // set the owning side to null (unless already changed)
            if ($showSeat->getShow() === $this) {
                $showSeat->setShow(null);
            }
        }

        return $this;
    }
}
