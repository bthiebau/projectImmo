<?php

namespace App\Controller;

use App\Entity\BienImmo;
use App\Form\BienImmoType;
use App\Repository\BienImmoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(BienImmoRepository $bienImmoRepository): Response
    {
        return $this->render('profile/index.html.twig', [
            'bien_immos' => $bienImmoRepository->findAll(),
        ]);
    }

    #[Route('/property/new', name: 'app_profile_new_property', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bienImmo = new BienImmo();
        $form = $this->createForm(BienImmoType::class, $bienImmo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $bienImmo->setOwner($user);

            $now = new DateTime;
            $bienImmo->setPublicationDate($now);

            $faker = Factory::create('fr_FR');
            $bienImmo->setReference($faker->bothify('??-####'));

            $entityManager->persist($bienImmo);
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/new.html.twig', [
            'bien_immo' => $bienImmo,
            'form' => $form,
        ]);
    }

    #[Route('/property/{id}', name: 'app_profile_property', methods: ['GET'])]
    public function show(BienImmo $bienImmo): Response
    {
        return $this->render('profile/show.html.twig', [
            'bien_immo' => $bienImmo,
        ]);
    }

    #[Route('/property/{id}/edit', name: 'app_profile_edit_property', methods: ['GET', 'POST'])]
    public function edit(Request $request, BienImmo $bienImmo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BienImmoType::class, $bienImmo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/edit.html.twig', [
            'bien_immo' => $bienImmo,
            'form' => $form,
        ]);
    }

    #[Route('/property/{id}', name: 'app_profile_delete_property', methods: ['POST'])]
    public function delete(Request $request, BienImmo $bienImmo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bienImmo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($bienImmo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    }
}
