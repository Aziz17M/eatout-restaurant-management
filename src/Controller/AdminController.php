<?php

namespace App\Controller;

use App\Repository\DishRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboard(
        RestaurantRepository $restaurantRepo,
        DishRepository $dishRepo,
        ReservationRepository $reservationRepo
    ): Response {
        $allReservations = $reservationRepo->findAll();
        
        $stats = [
            'restaurants' => count($restaurantRepo->findAll()),
            'dishes' => count($dishRepo->findAll()),
            'reservations' => count($allReservations),
            'pending' => count($reservationRepo->findBy(['status' => 'pending'])),
            'confirmed' => count($reservationRepo->findBy(['status' => 'confirmed'])),
            'completed' => count($reservationRepo->findBy(['status' => 'completed'])),
            'cancelled' => count($reservationRepo->findBy(['status' => 'cancelled'])),
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats' => $stats,
        ]);
    }
}
