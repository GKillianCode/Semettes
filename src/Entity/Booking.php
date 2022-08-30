<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $booking_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_time; 

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_time;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=MeetingRoom::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meeting_room;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingId(): ?string
    {
        return $this->booking_id;
    }

    public function setBookingId(string $booking_id): self
    {
        $this->booking_id = $booking_id;

        return $this;
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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMeetingRoom(): ?MeetingRoom
    {
        return $this->meeting_room;
    }

    public function setMeetingRoom(?MeetingRoom $meeting_room): self
    {
        $this->meeting_room = $meeting_room;

        return $this;
    }
}
