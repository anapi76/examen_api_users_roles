<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class MainController extends AbstractController
{
    #[Route('', name: 'app_main')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Bien venidos a la primera actividad del examen de 2ª Evaluación de DWES 23/24'
        ]);
    }
}
