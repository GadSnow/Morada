<?php

namespace App\Controller;

use App\Entity\Quarter;
use App\Form\QuarterType;
use App\Repository\QuarterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quarter')]
class QuarterController extends AbstractController
{
    #[Route('/', name: 'app_quarter_index', methods: ['GET'])]
    public function index(QuarterRepository $quarterRepository): Response
    {
        return $this->render('quarter/index.html.twig', [
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

        return $this->renderForm('quarter/new.html.twig', [
            'quarter' => $quarter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quarter_show', methods: ['GET'])]
    public function show(Quarter $quarter): Response
    {
        return $this->render('quarter/show.html.twig', [
            'quarter' => $quarter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quarter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quarter $quarter, QuarterRepository $quarterRepository): Response
    {
        $form = $this->createForm(QuarterType::class, $quarter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quarterRepository->save($quarter, true);
            $this->addFlash("success", "Modification effectuée.");

            return $this->redirectToRoute('app_quarter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quarter/edit.html.twig', [
            'quarter' => $quarter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quarter_delete', methods: ['POST'])]
    public function delete(Request $request, Quarter $quarter, QuarterRepository $quarterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quarter->getId(), $request->request->get('_token'))) {
            $quarterRepository->remove($quarter, true);
        }

        return $this->redirectToRoute('app_quarter_index', [], Response::HTTP_SEE_OTHER);
    }
}
