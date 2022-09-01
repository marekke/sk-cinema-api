<?php

namespace App\Entity;

use App\Repository\ShowSeatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ShowSeatRepository::class)]
#[UniqueEntity('ticket')]
class ShowSeat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'showSeats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Show $show = null;

    #[ORM\Column(length: 255)]
    #[NotNull]
    #[NotBlank]
    private ?string $ticket = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShow(): ?Show
    {
        return $this->show;
    }

    public function setShow(?Show $show): self
    {
        $this->show = $show;

        return $this;
    }

    public function getTicket(): ?string
    {
        return $this->ticket;
    }

    public function setTicket(string $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }
}
