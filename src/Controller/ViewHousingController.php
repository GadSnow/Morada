<?php

namespace App\Controller;

use App\Entity\Housing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewHousingController extends AbstractController
{
    #[Route('/bien/{slug}-{id}', name: 'app_view_housing', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function index(Housing $housing, string $slug): Response
    {
        if ($housing->getSlug() !== $slug) {
            return $this->redirectToRoute('app_view_housing', [
                'id' => $housing->getId(),
                'slug' => $housing->getSlug()
            ], 301);
        }
        return $this->render('view_housing/index.html.twig', [
            'controller_name' => 'ViewHousingController',
            'housing' => $housing
        ]);
    }
}
