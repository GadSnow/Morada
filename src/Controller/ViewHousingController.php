<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Housing;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use App\Repository\HousingRepository;
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

        if ($request->query->get('city') || $request->get('rooms') || $request->get('maxPrice')) {
            $housings = $paginator->paginate(
                $housingRepository->findBySearchQuery($request),
                $request->query->getInt('page', 1),
                8
            );
        } else {
            $housings = $paginator->paginate(
                $housingRepository->findAllVisibleItemsQuery(),
                $request->query->getInt('page', 1),
                8
            );
        }

        return $this->render('view_housing/index.html.twig', [
            'housings' => $housings
        ]);
    }

    #[Route('/biens/{slug}-{id}', name: 'app_view_housing', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show(string $slug, $id, HousingRepository $repo, Request $request, ContactNotification $notification): Response
    {
        $housing = $repo->find($id);

        if ($housing->getSlug() !== $slug) {
            return $this->redirectToRoute('app_view_housing', [
                'id' => $housing->getId(),
                'slug' => $housing->getSlug()
            ], 301);
        }

        $contact = new Contact();
        $contact->setHousing($housing);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a été bien envoyé.');
            // return $this->redirectToRoute('app_view_housing', [
            //     'id' => $housing->getId(),
            //     'slug' => $housing->getSlug()
            // ]);
        }

        return $this->renderForm('view_housing/show.html.twig', [
            'controller_name' => 'ViewHousingController',
            'housing' => $housing,
            'form' => $form
        ]);
    }
}
