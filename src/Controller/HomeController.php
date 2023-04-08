<?php

namespace App\Controller;

use App\Repository\HousingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HousingRepository $housingRepository): Response
    {
        $housings = $housingRepository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'housings' => $housings
        ]);
    }
}
