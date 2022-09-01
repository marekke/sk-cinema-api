<?php

namespace App\Controller\api;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/movies')]
class MovieController extends ApiController
{
    public function __construct(
        private readonly MovieRepository $movieRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route(null, name: 'app_movie_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $movies = $this->movieRepository->findAll();
        return $this->json($movies);
    }

    #[Route(null, name: 'app_movie_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->entityManager->persist($movie);
            $this->entityManager->flush();

            return new JsonResponse([
                'id' => $movie->getId(),
                'movieTitle' => $movie->getMovieTitle(),
                'movieTime' => $movie->getMovieTime(),
            ]);
        }

        return $this->returnFormErrorResponse($form);
    }

    #[Route('/{id}', name: 'app_movie_update', methods: ['POST'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $movie = $this->movieRepository->findOneBy(['id' => $id]);

        if ($movie === null) {
            return new JsonResponse(['message' => "Given movie ID doesn't exists."], 400);
        }
        
        $form = $this->createForm(MovieType::class, $movie);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->entityManager->flush();

            return new JsonResponse([
                'id' => $movie->getId(),
                'movieTitle' => $movie->getMovieTitle(),
                'movieTime' => $movie->getMovieTime(),
            ]);
        }

        return $this->returnFormErrorResponse($form);
    }

    #[Route('/{id}', name: 'app_movie_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $movie = $this->movieRepository->findOneBy(['id' => $id]);

        if ($movie === null) {
            return new JsonResponse(['message' => "Given movie ID doesn't exists."], 400);
        }

        $this->entityManager->remove($movie);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'The movie has been removed.',
        ]);
    }
}
