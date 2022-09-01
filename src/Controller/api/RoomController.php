<?php


namespace App\Controller\api;


use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rooms', name: 'app_room_')]
class RoomController extends ApiController
{
    public function __construct(
        private readonly RoomRepository $roomRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(null, name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $rooms = $this->roomRepository->findAll();
        return $this->json($rooms);
    }

    #[Route(null, name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->entityManager->persist($room);
            $this->entityManager->flush();

            return new JsonResponse([
                'id' => $room->getId(),
                'roomNumber' => $room->getRoomNumber(),
                'capacity' => $room->getCapacity(),
            ]);
        }

        return $this->returnFormErrorResponse($form);
    }

    #[Route('/{id}', name: 'update', methods: ['POST'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $room = $this->roomRepository->findOneBy(['id' => $id]);

        if ($room === null) {
            return new JsonResponse(['message' => "Given room ID doesn't exists."], 400);
        }

        $form = $this->createForm(RoomType::class, $room);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->entityManager->flush();

            return new JsonResponse([
                'id' => $room->getId(),
                'roomNumber' => $room->getRoomNumber(),
                'capacity' => $room->getCapacity(),
            ]);
        }

        return $this->returnFormErrorResponse($form);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $room = $this->roomRepository->findOneBy(['id' => $id]);

        if ($room === null) {
            return new JsonResponse(['message' => "Given room ID doesn't exists."], 400);
        }

        $this->entityManager->remove($room);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'The room has been removed.',
        ]);
    }
}