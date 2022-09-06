<?php


namespace App\Controller\api;


use App\Entity\Show;
use App\Entity\ShowSeat;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shows', name: 'app_show_')]
class ShowController extends ApiController
{
    public function __construct(
        private readonly ShowRepository $showRepository,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    #[Route(null, name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $shows = $this->showRepository->findAll();
        return $this->json($shows);
    }

    #[Route(null, name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            for ($i = 1; $i <= $show->getRoom()->getCapacity(); $i++) {
                $seat = new ShowSeat();
                $seat->setNumber($i);
                $seat->setShow($show);
                $this->entityManager->persist($seat);

                $show->addShowSeat($seat);
            }

            $this->entityManager->persist($show);
            $this->entityManager->flush();

            return $this->json([
                'id' => $show->getId(),
                'roomID' => $show->getRoom()->getId(),
                'movieID' => $show->getMovie()->getId(),
                'movie' => $show->getMovie(),
                'room' => $show->getRoom(),
                'seats' => $show->getShowSeats(),
            ]);
        }

        return $this->returnFormErrorResponse($form);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $show = $this->showRepository->findOneBy(['id' => $id]);

        if ($show === null) {
            return new JsonResponse(['message' => "Given show ID doesn't exists."], 400);
        }

        $this->entityManager->remove($show);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'The show has been removed.',
        ]);
    }

    #[Route('/{id}/buyTicket', methods: ['POST'])]
    public function buyTicket(): void
    {

    }

}