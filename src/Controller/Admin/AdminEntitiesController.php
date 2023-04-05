<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminEntitiesController extends AbstractController
{
    #[Route('/gadsoul', name: 'app_admin_entities')]
    public function index(): Response
    {
        return $this->render('admin_entities/index.html.twig', [
            'controller_name' => 'AdminEntitiesController',
        ]);
    }
}
