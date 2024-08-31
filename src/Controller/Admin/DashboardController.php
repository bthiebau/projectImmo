<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(): Response
    {
        // Afficher une vue Twig spécifique pour la page d'accueil
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/admin/bienImmo', name: 'bienImmo_crud')]
    public function bienImmoCrud(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BienImmoCrudController::class)->generateUrl());
    }

    #[Route('/admin/city', name: 'city_crud')]
    public function cityCrud(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CityCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProjectImmo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-home', 'admin_home');
        yield MenuItem::linkToRoute('Biens Immobiliers', 'fa fa-building', 'bienImmo_crud');
        yield MenuItem::linkToRoute('Villes', 'fa fa-city', 'city_crud');
        // Vous pouvez ajouter d'autres éléments de menu ici
    }
}
