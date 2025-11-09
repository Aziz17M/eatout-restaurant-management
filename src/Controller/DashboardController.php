<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use App\Repository\DishRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        RestaurantRepository $restaurantRepository,
        DishRepository $dishRepository,
        ReservationRepository $reservationRepository
    ): Response
    {
        // Fetch all data
        $restaurants = $restaurantRepository->findAll();
        $dishes = $dishRepository->findAll();
        $reservations = $reservationRepository->findAll();

        // Latest entries (last 5)
        $latestRestaurants = $restaurantRepository->findBy([], ['id' => 'DESC'], 5);
        $latestDishes = $dishRepository->findBy([], ['id' => 'DESC'], 5);
        $latestReservations = $reservationRepository->findBy([], ['id' => 'DESC'], 5);

        // Today's reservations
        $today = new \DateTime('today');
        $reservationsToday = $reservationRepository->createQueryBuilder('r')
            ->where('r.dateTime >= :today')
            ->setParameter('today', $today)
            ->getQuery()
            ->getResult();

        return $this->render('dashboard/index.html.twig', [
            'restaurants' => $restaurants,
            'dishes' => $dishes,
            'reservations' => $reservations,
            'latestRestaurants' => $latestRestaurants,
            'latestDishes' => $latestDishes,
            'latestReservations' => $latestReservations,
            'reservationsToday' => $reservationsToday,
        ]);
    }
}
