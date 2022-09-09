<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\WeekSlotRepository;
use App\Repository\MeetingRoomRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ExceptionalClosedSlotRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/api/weekslots', methods: ['GET'])]
    public function show(
        WeekSlotRepository $weekslotRepository,
        MeetingRoomRepository $meetingRoomRepository,
        BookingRepository $bookingRepository,
        ExceptionalClosedSlotRepository $exceptionalClosedSlotRepository,

    ): Response {

        $begin =  new \DateTime(); // now();
        $end =  new \DateTime();
        $end->modify('+30 day');

        $response = [];

        for ($i = $begin; $i <= $end; date_modify($i, '+1 day')) {
            // Récupérer le jour de la semaine (date)
            $date = new \DateTime($i->format('Y-m-d'));
            $day = $date->format('N');

            // Récupérer les slots ouvert par rapport au jour de la semaine.
            $weekslots = $weekslotRepository->findBy([
                'is_opened' => true,
                'week_day' => $day
            ]);

            $iDate = new \DateTime($i->format('Y-m-d'));

            $closedSlotsByDay = $exceptionalClosedSlotRepository->findBy([
                'closedDate' => $iDate
            ]);

            foreach ($weekslots as $slot) {
                $startSlot = new \DateTime($i->format('Y-m-d') . $slot->getStartTime()->format('H:i:s'));
                $finishSlot = new \DateTime($i->format('Y-m-d') . $slot->getEndTime()->format('H:i:s'));

                $closeDate = new \DateTime($i->format('Y-m-d'));
                $slotStartTime = new \DateTime($slot->getStartTime()->format('H:i:s'));
                $slotEndTime = new \DateTime($slot->getEndTime()->format('H:i:s'));

                $isClosed = false;

                foreach ($closedSlotsByDay as $closedSlot) {
                    if ($closedSlot->getClosedDate() == $closeDate) {
                        $closeStart = new \DateTime($closedSlot->getStartHour()->format('H:i:s'));
                        $closeEnd = new \DateTime($closedSlot->getEndHour()->format('H:i:s'));

                        if ($closeStart == $slotStartTime && $closeEnd == $slotEndTime) {
                            $isClosed = true;
                        }
                    } else {
                        $isClosed = false;
                    }
                }

                if ($isClosed == true) {
                    $response[] = [
                        'start' => $startSlot->format('Y-m-d H:i:s'),
                        'end' => $finishSlot->format('Y-m-d H:i:s'),
                        'extendedProps' => [
                            'isClosed' => true,
                        ],
                    ];
                } else {
                    $meetingRooms = $meetingRoomRepository->findAll();

                    foreach ($meetingRooms as &$room) {
                        $room = $room->getId();
                    }

                    $rooms = $bookingRepository->findFromdXtoDy($startSlot, $finishSlot);

                    foreach ($rooms as &$room) {
                        $room = $room['meeting_room_id'];
                    }
                    $roomAvailable = array_diff($meetingRooms, $rooms);

                    $response[] = [
                        'start' => $startSlot->format('Y-m-d H:i:s'),
                        'end' => $finishSlot->format('Y-m-d H:i:s'),
                        'extendedProps' => [
                            'room' => $roomAvailable,
                            'isClickable' => $isClickable = count($roomAvailable) === 0 ? false : true,
                            'isClosed' => false,
                        ],
                    ];
                }
            }
        }

        return new JsonResponse($response, 200, []);
    }

    #[Route('/api/rooms', methods: ['GET'])]
    public function getRooms(
        MeetingRoomRepository $meetingRoomRepo,
        SerializerInterface $serializer
    ) {
        $rooms = $meetingRoomRepo->findAll();
        $apiResponse = new Response($serializer->serialize($rooms, 'json', ['groups' => ['meeting_rooms']]));

        return $apiResponse;
    }

    #[Route('/api/weekslots/{id}', name: 'show_weekslot')]
    public function showRooms(
        WeekSlotRepository $weekslotRepository,
        BookingRepository $bookingRepository,
        ExceptionalClosedSlotRepository $exceptionalClosedSlotRepository,
        int $id,
    ): Response {

        $begin =  new \DateTime(); // now();
        $end =  new \DateTime();
        $end->modify('+30 day');

        $response = [];

        for ($i = $begin; $i <= $end; date_modify($i, '+1 day')) {
            // Récupérer le jour de la semaine (date)
            $date = new \DateTime($i->format('Y-m-d'));
            $day = $date->format('N');

            // Récupérer les slots ouvert par rapport au jour de la semaine.
            $weekslots = $weekslotRepository->findBy([
                'is_opened' => true,
                'week_day' => $day
            ]);

            $iDate = new \DateTime($i->format('Y-m-d'));

            $closedSlotsByDay = $exceptionalClosedSlotRepository->findBy([
                'closedDate' => $iDate
            ]);

            foreach ($weekslots as $slot) {
                $startSlot = new \DateTime($i->format('Y-m-d') . $slot->getStartTime()->format('H:i:s'));
                $finishSlot = new \DateTime($i->format('Y-m-d') . $slot->getEndTime()->format('H:i:s'));

                $closeDate = new \DateTime($i->format('Y-m-d'));
                $slotStartTime = new \DateTime($slot->getStartTime()->format('H:i:s'));
                $slotEndTime = new \DateTime($slot->getEndTime()->format('H:i:s'));

                $isClosed = false;

                foreach ($closedSlotsByDay as $closedSlot) {
                    if ($closedSlot->getClosedDate() == $closeDate) {
                        $closeStart = new \DateTime($closedSlot->getStartHour()->format('H:i:s'));
                        $closeEnd = new \DateTime($closedSlot->getEndHour()->format('H:i:s'));

                        if ($closeStart == $slotStartTime && $closeEnd == $slotEndTime) {
                            $isClosed = true;
                        }
                    } else {
                        $isClosed = false;
                    }
                }

                if ($isClosed == true) {
                    $response[] = [
                        'start' => $startSlot->format('Y-m-d H:i:s'),
                        'end' => $finishSlot->format('Y-m-d H:i:s'),
                        'extendedProps' => [
                            'isClosed' => true,
                        ],
                    ];
                } else {
                    $isBookingRoom = $bookingRepository->findByDateAndRoom($startSlot, $finishSlot, $id);

                    $response[] = [
                        'start' => $startSlot->format('Y-m-d H:i:s'),
                        'end' => $finishSlot->format('Y-m-d H:i:s'),
                        'extendedProps' => [
                            'isClickable' => $isBookingRoom[0] ? false : true,
                            'isClosed' => false,
                            'bookingId' => $isBookingRoom[0] ? $isBookingRoom[0] : false
                        ],
                    ];
                }
            }
        }

        return new JsonResponse($response, 200, []);
    }
}
