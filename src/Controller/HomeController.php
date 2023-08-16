<?php

namespace App\Controller;

use App\Entity\HousingSearch;
use App\Form\HousingSearchType;
use App\Repository\HousingRepository;
use App\Repository\QuarterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HousingRepository $housingRepository, QuarterRepository $quarterRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $housingSearch = new HousingSearch();
        $form = $this->createForm(HousingSearchType::class, $housingSearch);
        $error = false;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getCity() == null && $form->getData()->getMaxPrice() == null && $form->getData()->getRooms() == null) {
                $error = true;
            } else if ($form->isValid()) {
                $housings = $paginator->paginate(
                    $housingRepository->findBySearchQuery($request),
                    $request->query->getInt('page', 1),
                    8
                );
                return $this->render('view_housing/index.html.twig', [
                    'housings' => $housings,
                    'housingSearch' => $housingSearch
                ]);
            }
        }

        $housings = $housingRepository->findLatest();
        $quarters = $quarterRepository->findFirsts();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'housings' => $housings,
            'quarters' => $quarters,
            'error' => $error,
            'form' => $form->createView()
        ]);
    }
}
