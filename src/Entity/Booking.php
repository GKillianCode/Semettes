<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['booking'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['booking'])]
    private $booking_id;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['booking'])]
    private $start_time;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['booking'])]
    private $end_time;

    /**
     * @ORM\ManyToOne(targetEntity=MeetingRoom::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['booking'])]
    private $meeting_room;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['booking'])]
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['booking'])]
    private $lastname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    #[Groups(['booking'])]
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['booking'])]
    private $email;

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

    public function getMeetingRoom(): ?MeetingRoom
    {
        return $this->meeting_room;
    }

    public function setMeetingRoom(?MeetingRoom $meeting_room): self
    {
        $this->meeting_room = $meeting_room;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
