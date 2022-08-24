<?php

namespace App\Entity;

use App\Repository\WeekSlotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeekSlotRepository::class)
 */
class WeekSlot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $start_time;

    /**
     * @ORM\Column(type="time")
     */
    private $end_time;

    /**
     * @ORM\Column(type="smallint")
     */
    private $week_day;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_opened;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getWeekDay(): ?int
    {
        return $this->week_day;
    }

    public function setWeekDay(int $week_day): self
    {
        $this->week_day = $week_day;

        return $this;
    }

    public function isIsOpened(): ?bool
    {
        return $this->is_opened;
    }

    public function setIsOpened(bool $is_opened): self
    {
        $this->is_opened = $is_opened;

        return $this;
    }
}
