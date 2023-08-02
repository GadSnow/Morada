<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Entity\HousingSearch;
use App\Repository\HousingRepository;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewHousingController extends AbstractController
{
    #[Route('/biens', name: 'app_index_housings')]
    public function index(HousingRepository $housingRepository, PaginatorInterface $paginator, Request $request)
    {
        $housings = $paginator->paginate(
            $housingRepository->findAllVisibleItemsQuery(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('view_housing/index.html.twig', [
            'housings' => $housings
        ]);
    }

    #[Route('/biens/{slug}-{id}', name: 'app_view_housing', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show(string $slug, $id, HousingRepository $repo): Response
    {
        $housing = $repo->find($id);

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
