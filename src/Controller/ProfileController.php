<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\BienImmo;
use App\Form\BienImmoType;
use App\Form\ProfileType;
use App\Repository\BienImmoRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'app_profile_index', methods: ['GET'])]
    public function index(BienImmoRepository $bienImmoRepository, UserInterface $user): Response
    {
        // Récupérer uniquement les biens immobiliers de l'utilisateur connecté
        $properties = $bienImmoRepository->findBy(['owner' => $user]);

        return $this->render('profile/index.html.twig', [
            'properties' => $properties,
            'user' => $user,
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

            $now = new DateTime();
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
        // Sécurité : Vérifier que l'utilisateur connecté est bien le propriétaire du bien
        if ($bienImmo->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez voir que vos propres biens.');
        }

        return $this->render('profile/show.html.twig', [
            'property' => $bienImmo,
        ]);
    }

    #[Route('/property/{id}/edit', name: 'app_profile_edit_property', methods: ['GET', 'POST'])]
    public function edit(Request $request, BienImmo $bienImmo, EntityManagerInterface $entityManager): Response
    {
        // Sécurité : Vérifier que l'utilisateur connecté est bien le propriétaire du bien
        if ($bienImmo->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que vos propres biens.');
        }

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
        // Sécurité : Vérifier que l'utilisateur connecté est bien le propriétaire du bien
        if ($bienImmo->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez supprimer que vos propres biens.');
        }

        if ($this->isCsrfTokenValid('delete'.$bienImmo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($bienImmo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_profile_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /** @var User $user */
        $user = $this->getUser(); // Récupère l'utilisateur connecté

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier si l'utilisateur souhaite changer son mot de passe
            $newPassword = $form->get('plainPassword')->getData();
            if ($newPassword) {
                $hashedPassword = $userPasswordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            // Sauvegarde des modifications
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('app_profile_index');
        }

        return $this->render('profile/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

