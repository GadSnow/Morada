<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gadsoul/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('admin_entities/client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientRepository $clientRepository): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->save($client, true);

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/client/new.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(ClientRepository $clientRepository, $id): Response
    {
        $client = $clientRepository->find($id);
        return $this->render('admin_entities/client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->save($client, true);
            $this->addFlash("success", "Modification effectuée.");


            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, $id, ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            $clientRepository->remove($client, true);
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
