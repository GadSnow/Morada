<?php

namespace App\Controller\Admin;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/gadsoul/region')]
class RegionController extends AbstractController
{
    #[Route('/', name: 'app_region_index', methods: ['GET'])]
    public function index(RegionRepository $regionRepository): Response
    {
        return $this->render('admin_entities/region/index.html.twig', [
            'regions' => $regionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_region_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RegionRepository $regionRepository): Response
    {
        $region = new Region();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionRepository->save($region, true);

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/region/new.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_show', methods: ['GET'])]
    public function show(RegionRepository $regionRepository, $id): Response
    {
        $region = $regionRepository->find($id);
        return $this->render('admin_entities/region/show.html.twig', [
            'region' => $region,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_region_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, $id, RegionRepository $regionRepository): Response
    {
        $region = $regionRepository->find($id);

        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $regionRepository->save($region, true);
            $this->addFlash("success", "Modification effectuée.");

            return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_entities/region/edit.html.twig', [
            'region' => $region,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_region_delete', methods: ['POST'])]
    public function delete(Request $request, $id, RegionRepository $regionRepository): Response
    {
        $region = $regionRepository->find($id);

        if ($this->isCsrfTokenValid('delete' . $region->getId(), $request->request->get('_token'))) {
            $regionRepository->remove($region, true);
        }

        return $this->redirectToRoute('app_region_index', [], Response::HTTP_SEE_OTHER);
    }
}
