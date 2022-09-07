<?php


namespace App\Controller\api;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app', name: 'app_')]
class AppController extends ApiController
{
    #[Route('/clear-database', name:'clear_database', methods: ['POST'])]
    public function clearDatabase(EntityManagerInterface $em): JsonResponse
    {
        $em->getConnection()->executeQuery('DELETE FROM show_seat');
        $em->getConnection()->executeQuery('DELETE FROM `show`');
        $em->getConnection()->executeQuery('DELETE FROM movie');
        $em->getConnection()->executeQuery('DELETE FROM room');

        return $this->json([]);
    }
}