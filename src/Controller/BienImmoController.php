<?php

namespace App\Controller;

use App\Entity\BienImmo;
use App\Repository\BienImmoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BienImmoController extends AbstractController
{
    // #[Route('/properties', name: 'properties_list')]
    // public function list(BienImmoRepository $bienImmoRepository): Response
    // {
    //     $properties = $bienImmoRepository->findAll();
    //     return $this->render('bien_immo/list.html.twig', [
    //         'properties' => $properties,
    //     ]);
    // }

    #[Route('/properties', name: 'properties_list')]
    public function list(BienImmoRepository $bienImmoRepository, Request $request): Response
    {
        // Récupération des paramètres de tri depuis la requête
        $sortField = $request->query->get('sort', 'price'); // Par défaut, on trie par prix
        $sortOrder = $request->query->get('order', 'asc');  // Par défaut, ordre croissant

        // Recherche avec tri
        $properties = $bienImmoRepository->findBy([], [$sortField => $sortOrder]);

        return $this->render('bien_immo/list.html.twig', [
            'properties' => $properties,
            'sortField' => $sortField,
            'sortOrder' => $sortOrder,
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
