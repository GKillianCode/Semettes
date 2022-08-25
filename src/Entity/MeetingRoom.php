<?php

namespace App\Entity;

use App\Repository\MeetingRoomRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeetingRoomRepository::class)
 */
class MeetingRoom
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
    private $room_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $room_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $room_image_name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $max_person;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rate;

    /**
     * @ORM\OneToOne(targetEntity=Booking::class, mappedBy="meeting_room_id", cascade={"persist", "remove"})
     */
    private $booking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomName(): ?string
    {
        return $this->room_name;
    }

    public function setRoomName(string $room_name): self
    {
        $this->room_name = $room_name;

        return $this;
    }

    public function getRoomDescription(): ?string
    {
        return $this->room_description;
    }

    public function setRoomDescription(?string $room_description): self
    {
        $this->room_description = $room_description;

        return $this;
    }

    public function getRoomImageName(): ?string
    {
        return $this->room_image_name;
    }

    public function setRoomImageName(string $room_image_name): self
    {
        $this->room_image_name = $room_image_name;

        return $this;
    }

    public function getMaxPerson(): ?int
    {
        return $this->max_person;
    }

    public function setMaxPerson(int $max_person): self
    {
        $this->max_person = $max_person;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(?Booking $booking): self
    {
        // unset the owning side of the relation if necessary
        if ($booking === null && $this->booking !== null) {
            $this->booking->setMeetingRoomId(null);
        }

        // set the owning side of the relation if necessary
        if ($booking !== null && $booking->getMeetingRoomId() !== $this) {
            $booking->setMeetingRoomId($this);
        }

        $this->booking = $booking;

        return $this;
    }
}
