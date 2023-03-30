<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HousingController extends AbstractController
{
    #[Route('/biens', name: 'app_housing_show')]
    public function index(): Response
    {
        return $this->render('housing/index.html.twig', [
            'controller_name' => 'HousingController',
        ]);
    }
}
