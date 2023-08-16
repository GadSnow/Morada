<?php

namespace App\Controller;

use App\Entity\Quarter;
use App\Repository\HousingRepository;
use App\Repository\QuarterRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewQuarterController extends AbstractController
{
    #[Route('/quarter/{slug}', name: 'app_view_quarter', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function index(HousingRepository $housingRepository, $slug, PaginatorInterface $paginator, Request $request): Response
    {

        $quarterName = str_ireplace('-', ' ', $slug);
        $housings = $housingRepository->findHousingByQuarter($quarterName);

        $housings = $paginator->paginate(
            $housingRepository->findHousingByQuarter($quarterName),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('view_quarter/index.html.twig', [
            'controller_name' => 'ViewQuarterController',
            'housings' => $housings
        ]);
    }
}
