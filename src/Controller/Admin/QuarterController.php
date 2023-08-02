<?php

namespace App\Controller\Admin;

use App\Entity\Quarter;
use App\Form\QuarterType;
use App\Repository\QuarterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gadsoul/quarter')]
class QuarterController extends AbstractController
{
    #[Route('/', name: 'app_quarter_index', methods: ['GET'])]
    public function index(QuarterRepository $quarterRepository): Response
    {
        return $this->render('admin_entities/quarter/index.html.twig', [
            'quarters' => $quarterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quarter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuarterRepository $quarterRepository): Response
    {
        $quarter = new Quarter();
        $form = $this->createForm(QuarterType::class, $quarter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quarterRepository->save($quarter, true);

            return $this->redirectToRoute('app_quarter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/quarter/new.html.twig', [
            'quarter' => $quarter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quarter_show', methods: ['GET'])]
    public function show(QuarterRepository $quarterRepository, $id): Response
    {
        $quarter = $quarterRepository->find($id);
        return $this->render('admin_entities/quarter/show.html.twig', [
            'quarter' => $quarter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quarter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, QuarterRepository $quarterRepository): Response
    {
        $quarter = $quarterRepository->find($id);

        $form = $this->createForm(QuarterType::class, $quarter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quarterRepository->save($quarter, true);
            $this->addFlash("success", "Modification effectuée.");

            return $this->redirectToRoute('app_quarter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/quarter/edit.html.twig', [
            'quarter' => $quarter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quarter_delete', methods: ['POST'])]
    public function delete(Request $request, $id, QuarterRepository $quarterRepository): Response
    {
        $quarter = $quarterRepository->find($id);

        if ($this->isCsrfTokenValid('delete' . $quarter->getId(), $request->request->get('_token'))) {
            $quarterRepository->remove($quarter, true);
        }

        return $this->redirectToRoute('app_quarter_index', [], Response::HTTP_SEE_OTHER);
    }
}
