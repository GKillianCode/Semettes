<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MeetingRoomRepository;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['meeting_rooms'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['meeting_rooms'])]
    private $room_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[Groups(['meeting_rooms'])]
    private $room_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['meeting_rooms'])]
    private $room_image_name;

    /**
     * @ORM\Column(type="smallint")
     */
    #[Groups(['meeting_rooms'])]
    private $max_person;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['meeting_rooms'])]
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="meeting_room")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setMeetingRoom($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getMeetingRoom() === $this) {
                $booking->setMeetingRoom(null);
            }
        }

        return $this;
    }

}
