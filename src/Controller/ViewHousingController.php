<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Entity\HousingSearch;
use App\Repository\HousingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewHousingController extends AbstractController
{
    #[Route('/biens', name: 'app_index_housings')]
    public function index(HousingRepository $housingRepository)
    {
        $search = new HousingSearch();

        $housings = $housingRepository->findBySearch($search);

        return $this->render('view_housing/index.html.twig', [
            'housings' => $housings
        ]);
    }

    #[Route('/bien/{slug}-{id}', name: 'app_view_housing', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show(Housing $housing, string $slug): Response
    {
        if ($housing->getSlug() !== $slug) {
            return $this->redirectToRoute('app_view_housing', [
                'id' => $housing->getId(),
                'slug' => $housing->getSlug()
            ], 301);
        }
        return $this->render('view_housing/show.html.twig', [
            'controller_name' => 'ViewHousingController',
            'housing' => $housing
        ]);
    }
}
