<?php

namespace App\Controller;

use App\Entity\HousingSearch;
use App\Form\HousingSearchType;
use App\Repository\HousingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HousingRepository $housingRepository, Request $request): Response
    {
        $housingSearch = new HousingSearch();
        $form = $this->createForm(HousingSearchType::class, $housingSearch);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $housings = $housingRepository->findBySearch($housingSearch);

            return $this->render('view_housing/index.html.twig', [
                'housings' => $housings,
                'housingSearch' => $housingSearch
            ]);
        }
        $housings = $housingRepository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'housings' => $housings,
            'form' => $form->createView()
        ]);
    }
}
