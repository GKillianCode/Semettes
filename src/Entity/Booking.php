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
     * @ORM\OneToOne(targetEntity=WeekSlot::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $week_slot_id;

    /**
     * @ORM\OneToOne(targetEntity=MeetingRoom::class, inversedBy="booking", cascade={"persist", "remove"})
     */
    private $meeting_room_id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="booking", cascade={"persist", "remove"})
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_time;

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

    public function getWeekSlotId(): ?weekSlot
    {
        return $this->week_slot_id;
    }

    public function setWeekSlotId(weekSlot $week_slot_id): self
    {
        $this->week_slot_id = $week_slot_id;

        return $this;
    }

    public function getMeetingRoomId(): ?meetingRoom
    {
        return $this->meeting_room_id;
    }

    public function setMeetingRoomId(?meetingRoom $meeting_room_id): self
    {
        $this->meeting_room_id = $meeting_room_id;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

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
}
