<?php

namespace App\Controller\Admin;

use App\Entity\Housing;
use App\Form\HousingType;
use App\Repository\HousingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gadsoul/housing')]
class HousingController extends AbstractController
{
    #[Route('/', name: 'app_housing_index', methods: ['GET'])]
    public function index(HousingRepository $housingRepository): Response
    {
        return $this->render('admin_entities/housing/index.html.twig', [
            'housings' => $housingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_housing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HousingRepository $housingRepository): Response
    {
        $housing = new Housing();
        $form = $this->createForm(HousingType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $housingRepository->save($housing, true);

            return $this->redirectToRoute('app_housing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/housing/new.html.twig', [
            'housing' => $housing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_housing_show', methods: ['GET'])]
    public function show(HousingRepository $housingRepository, $id): Response
    {
        $housing = $housingRepository->find($id);
        return $this->render('admin_entities/housing/show.html.twig', [
            'housing' => $housing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_housing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, HousingRepository $housingRepository): Response
    {
        $housing = $housingRepository->find($id);
        $form = $this->createForm(HousingType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $housingRepository->save($housing, true);
            $this->addFlash("success", "Modification effectuée.");

            return $this->redirectToRoute('app_housing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/housing/edit.html.twig', [
            'housing' => $housing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_housing_delete', methods: ['POST'])]
    public function delete(Request $request, $id, HousingRepository $housingRepository): Response
    {
        $housing = $housingRepository->find($id);
        if ($this->isCsrfTokenValid('delete' . $housing->getId(), $request->request->get('_token'))) {
            $housingRepository->remove($housing, true);
        }

        return $this->redirectToRoute('app_housing_index', [], Response::HTTP_SEE_OTHER);
    }
}
