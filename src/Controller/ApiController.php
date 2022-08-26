<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\WeekSlotRepository;
use App\Repository\MeetingRoomRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;


class ApiController extends AbstractController
{
    #[Route('/api/weekslots', name: 'show_weekslot')]
    public function show(
        WeekSlotRepository $weekslotRepo,
        MeetingRoomRepository $meetingRoomRepo,
        BookingRepository $bookingRepo,
    ): Response {
        $weekSlots = $weekslotRepo->findAll();
        $meetingRooms = $meetingRoomRepo->findAll();
        $bookings = $bookingRepo->findFromTodayOnward();
        $begin =  new \DateTime(); // now();
        $end =  new \DateTime();
        $end->modify('+60 day');
        $response = [];
        for ($i = $begin; $i <= $end; date_modify($i, '+1 day')) {
            foreach($weekSlots as $ws){
                # Recherche de la date du slot en fonction de la semaine type
                if ($i->format('N') == $ws->getWeekDay()){
                    $start = new \DateTime($i->format('Y-m-d').$ws->getStartTime()->format('H:i:s'));
                    $finish = new \DateTime($i->format('Y-m-d').$ws->getEndTime()->format('H:i:s'));
                
                    # Recherche des salles disponibles dans le slot en question: 

                    $response[] = [
                        'start' => $start->format('y-m-d H:i:s'),
                        'end' => $finish->format('y-m-d H:i:s'),
                        'extendedProps' => [
                            'room' => ['room1'],
                            'isClickable' => true
                        ],
                    ];
                }   
            }
        }
        $apiResponse = new JsonResponse($response, 200, []);
        return $apiResponse;
    }

    #[Route('/api/rooms', methods: ['GET'])]

    public function showRooms(
        MeetingRoomRepository $meetingRoomRepo,
        SerializerInterface $serializer

    ) {
        $rooms = $meetingRoomRepo->findAll();
        $apiResponse = $serializer->serialize($rooms, 'json', ['groups'=>['meeting_rooms']]);
        return $apiResponse;
    }
}
