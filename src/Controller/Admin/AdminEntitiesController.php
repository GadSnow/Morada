<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminEntitiesController extends AbstractController
{
    #[Route('/gadsoul', name: 'app_admin_entities')]
    public function index(AuthenticationUtils $auth): Response
    {
        $username = $auth->getLastUsername();
        $entities = [
            0 => ['app_housing_index', 'Appartements'],
            1 =>  ['app_category_index', 'Catégories'],
            2 => ['app_city_index', 'Villes'],
            3 => ['app_client_index', 'Clients'],
            4 => ['app_provider_index', 'Fournisseurs'],
            5 => ['app_region_index', 'Régions'],
            6 => ['app_quarter_index', 'Quartiers']
        ];
        return $this->render('admin_entities/index.html.twig', [
            'controller_name' => 'AdminEntitiesController',
            'entities' => $entities,
            'username' => $username
        ]);
    }
}
