<?php

namespace App\Controller;

use App\Entity\BienImmo;
use App\Repository\BienImmoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BienImmoController extends AbstractController
{
    #[Route('/properties', name: 'properties_list')]
    public function list(BienImmoRepository $bienImmoRepository): Response
    {
        $properties = $bienImmoRepository->findAll();
        return $this->render('bien_immo/list.html.twig', [
            'properties' => $properties,
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
