<?php


namespace App\Controller\api;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    protected function returnFormErrorResponse(FormInterface $form): JsonResponse
    {
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            if ($error->getOrigin()) {
                $errors[$error->getOrigin()->getName()][] = $error->getMessage();
            }
        }

        return new JsonResponse($errors, 400);
    }

}