<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation')]
final class ReservationController extends AbstractController
{
    #[Route(name: 'app_reservation_index', methods: ['GET'])]
    public function index(Request $request, ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();
        $status = $request->query->get('status');
        
        // Admin sees all reservations, regular users see only their own
        if ($this->isGranted('ROLE_ADMIN')) {
            if ($status) {
                $reservations = $reservationRepository->findBy(['status' => $status], ['dateTime' => 'DESC']);
            } else {
                $reservations = $reservationRepository->findBy([], ['dateTime' => 'DESC']);
            }
        } else {
            if ($status) {
                $reservations = $reservationRepository->findBy(['user' => $user, 'status' => $status], ['dateTime' => 'DESC']);
            } else {
                $reservations = $reservationRepository->findBy(['user' => $user], ['dateTime' => 'DESC']);
            }
        }

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'currentStatus' => $status,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Automatically assign the current user to the reservation
            $reservation->setUser($this->getUser());
            $reservation->setStatus('pending');
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/confirm', name: 'app_reservation_confirm', methods: ['POST'])]
    public function confirm(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Only admins can confirm reservations.');
        }

        if ($this->isCsrfTokenValid('confirm'.$reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus('confirmed');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/complete', name: 'app_reservation_complete', methods: ['POST'])]
    public function complete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Only admins can complete reservations.');
        }

        if ($this->isCsrfTokenValid('complete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus('completed');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/cancel', name: 'app_reservation_cancel', methods: ['POST'])]
    public function cancel(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Users can cancel their own reservations, admins can cancel any
        if (!$this->isGranted('ROLE_ADMIN') && $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot cancel this reservation.');
        }

        if ($this->isCsrfTokenValid('cancel'.$reservation->getId(), $request->request->get('_token'))) {
            $reservation->setStatus('cancelled');
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        // Check if user owns this reservation or is admin
        if (!$this->isGranted('ROLE_ADMIN') && $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot view this reservation.');
        }

        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Check if user owns this reservation or is admin
        if (!$this->isGranted('ROLE_ADMIN') && $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot edit this reservation.');
        }

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Check if user owns this reservation or is admin
        if (!$this->isGranted('ROLE_ADMIN') && $reservation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot delete this reservation.');
        }

        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
