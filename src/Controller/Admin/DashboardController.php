<?php

namespace App\Controller\Admin;

use App\Entity\DonationPromise;
use App\Entity\Present;
use App\Entity\PresentCategory;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{

    public function __construct()
    {
    }

    #[Route('/admin', name: 'admin')]
    public function DonationPromisesView(EntityManagerInterface $entityManager)
    {
        $donationPromises = $entityManager->getRepository(DonationPromise::class)->findByView(false);
        $allPresents = $entityManager->getRepository(Present::class)->findAll();
        $presents = array();
        foreach ($allPresents as $present) {
            $present->setTotalAmount();
            $present->setProgression();
            if ($present->getTotalAmount() > 0) {
                array_push($presents, $present);
            }
        }

        return $this->render('admin/dashboard.html.twig', [
            'donationPromises' => $donationPromises,
            'presents' => $presents,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Maxime Et Claire')
            ->setFaviconPath('favicon.svg')
            ->renderContentMaximized()
            ->renderSidebarMinimized()
            ->disableDarkMode();
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud('Utilsateurs', 'fa fa-user', User::class)->setPermission('ROLE_SUPERADMIN'),
            MenuItem::linkToCrud('Cadeaux', 'fa fa-gift', Present::class),
            MenuItem::linkToCrud('Catégories de cadeaux', 'fa fa-list', PresentCategory::class),
            MenuItem::linkToCrud('Tags', 'fa fa-tags', Tag::class),
            MenuItem::linkToCrud('Promesses de dons', 'fa fa-hand-holding-heart', DonationPromise::class),
        ];
    }
}
