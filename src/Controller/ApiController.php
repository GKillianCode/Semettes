<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\ExceptionalClosedSlotRepository;
use App\Repository\MeetingRoomRepository;
use App\Repository\WeekSlotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    #[Route('/api/weekslots', name: 'show_weekslot')]
    public function show(
        WeekSlotRepository $weekslotRepository,
        MeetingRoomRepository $meetingRoomRepository,
        BookingRepository $bookingRepository,
        ExceptionalClosedSlotRepository $exceptionalClosedSlotRepository,
        
    ): Response {
        $closedSlots = $exceptionalClosedSlotRepository->findAll();

        $begin =  new \DateTime(); // now();
        $end =  new \DateTime();
        $end->modify('+60 day');

        // $bookings = $bookingRepository->findByDate($begin, $end);
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

            foreach ($weekslots as $slot) {
                $start = new \DateTime($i->format('Y-m-d').$slot->getStartTime()->format('H:i:s'));
                $finish = new \DateTime($i->format('Y-m-d').$slot->getEndTime()->format('H:i:s'));

                $meetingRooms = $meetingRoomRepository->findAll();

                foreach($meetingRooms as &$room){
                    $room = $room->getId();
                }

                $rooms = $bookingRepository->findFromdXtoDy($start,$finish);

                foreach($rooms as &$room){
                    $room = $room['meeting_room_id'];
                }
                $roomAvailable = array_diff($meetingRooms,$rooms);

                $response[] = [
                    'start' => $start->format('Y-m-d H:i:s'),
                    'end' => $finish->format('Y-m-d H:i:s'),
                    'extendedProps' => [
                        'room' => $roomAvailable,
                        'isClickable' => $isClickable = count($roomAvailable) === 0 ? false : true,
                    ],
                ];
            }
            
        }

        return new JsonResponse($response, 200, []);
    }

    #[Route('/api/rooms', methods: ['GET'])]
    public function showRooms(
        MeetingRoomRepository $meetingRoomRepo,
        SerializerInterface $serializer
    ) {
        $rooms = $meetingRoomRepo->findAll();
        $apiResponse = new Response($serializer->serialize($rooms, 'json', ['groups'=>['meeting_rooms']]));

        return $apiResponse;
    }
}
