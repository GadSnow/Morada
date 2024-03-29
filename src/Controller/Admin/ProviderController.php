<?php

namespace App\Controller\Admin;

use App\Entity\Provider;
use App\Form\ProviderType;
use App\Repository\ProviderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gadsoul/provider')]
class ProviderController extends AbstractController
{
    #[Route('/', name: 'app_provider_index', methods: ['GET'])]
    public function index(ProviderRepository $providerRepository): Response
    {
        return $this->render('admin_entities/provider/index.html.twig', [
            'providers' => $providerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_provider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProviderRepository $providerRepository): Response
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $providerRepository->save($provider, true);

            return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/provider/new.html.twig', [
            'provider' => $provider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provider_show', methods: ['GET'])]
    public function show(ProviderRepository $providerRepository, $id): Response
    {
        $provider = $providerRepository->find($id);

        return $this->render('admin_entities/provider/show.html.twig', [
            'provider' => $provider,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_provider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, ProviderRepository $providerRepository): Response
    {
        $provider = $providerRepository->find($id);

        $form = $this->createForm(ProviderType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $providerRepository->save($provider, true);
            $this->addFlash("success", "Modification effectuée.");

            return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/provider/edit.html.twig', [
            'provider' => $provider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provider_delete', methods: ['POST'])]
    public function delete(Request $request, $id, ProviderRepository $providerRepository): Response
    {
        $provider = $providerRepository->find($id);
        if ($this->isCsrfTokenValid('delete' . $provider->getId(), $request->request->get('_token'))) {
            $providerRepository->remove($provider, true);
        }

        return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
    }
}
