<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExceptionalClosedSlotRepository;

/**
 * @ORM\Entity(repositoryClass=ExceptionalClosedSlotRepository::class)
 */
class ExceptionalClosedSlot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $closedDate;

    /**
     * @ORM\Column(type="time")
     */
    private $startHour;

    /**
     * @ORM\Column(type="time")
     */
    private $endHour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClosedDate(): ?\DateTimeInterface
    {
        return $this->closedDate;
    }

    public function setClosedDate(\DateTimeInterface $closedDate): self
    {
        $this->closedDate = $closedDate;

        return $this;
    }

    public function getStartHour(): ?\DateTimeInterface
    {
        return $this->startHour;
    }

    public function setStartHour(\DateTimeInterface $startHour): self
    {
        $this->startHour = $startHour;

        return $this;
    }

    public function getEndHour(): ?\DateTimeInterface
    {
        return $this->endHour;
    }

    public function setEndHour(\DateTimeInterface $endHour): self
    {
        $this->endHour = $endHour;

        return $this;
    }
}
