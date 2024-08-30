<?php

namespace App\Controller;

use App\Entity\BienImmo;
use App\Form\SearchPropertiesType;
use App\Repository\BienImmoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BienImmoController extends AbstractController
{
    #[Route('/properties', name: 'properties_list')]
    public function list(BienImmoRepository $bienImmoRepository, Request $request): Response
    {
        // Création du formulaire de recherche
        $form = $this->createForm(SearchPropertiesType::class);
        $form->handleRequest($request);

        // Par défaut, on récupère tous les biens
        $criteria = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $criteria = $form->getData();
        }

        // Récupération des paramètres de tri depuis la requête
        $sortField = $request->query->get('sort', 'price');
        $sortOrder = $request->query->get('order', 'asc');

        // Recherche avec critères et tri
        $properties = $bienImmoRepository->searchProperties($criteria, $sortField, $sortOrder);
 
        return $this->render('bien_immo/list.html.twig', [
            'properties' => $properties,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/property/{id}', name: 'property_item')]
    public function item(BienImmo $property): Response
    {
        return $this->render('bien_immo/item.html.twig', [
            'property' => $property,
        ]);
    }
}
