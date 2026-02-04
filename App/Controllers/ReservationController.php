<?php

namespace App\Controllers;

use App\Models\Reservation;
use App\Models\Event;
use App\Entities\ReservationEntity;

class ReservationController extends Controller
{
    // ============================================================
    // CRÉER UNE RÉSERVATION
    // ============================================================
    /**
 * CRÉER UNE RÉSERVATION
 */
public function create(): void
{
    // 🔒 Protection : utilisateur connecté
    $this->requireLogin();

    // ✅ Récupérer eventId depuis $_GET
    $eventId = isset($_GET['eventId']) ? (int)$_GET['eventId'] : null;

    if (!$eventId) {
        $this->setFlash('error', 'Événement non spécifié.');
        $this->redirect('home', 'index');
    }

    $eventModel = new Event();
    $event = $eventModel->getById($eventId);

    if (!$event) {
        $this->setFlash('error', 'Événement introuvable.');
        $this->redirect('home', 'index');
    }

    // Vérifier les places disponibles
    if ($event->getAvailableSpots() <= 0) {
        $this->setFlash('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement.');
        $controller = $event->getType() === 'atelier' ? 'atelier' : 'event';
        $this->redirect($controller, 'show', ['id' => $eventId]);
    }

    $reservationModel = new Reservation();

    // Vérifier si l'utilisateur a déjà réservé
    if ($reservationModel->hasUserReserved($_SESSION['user_id'], $eventId)) {
        $this->setFlash('warning', 'Vous avez déjà une réservation pour cet événement.');
        $this->redirect('reservation', 'myReservations');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $numberOfSeats = (int)($_POST['number_of_seats'] ?? 1);
        $userNotes = trim($_POST['user_notes'] ?? '');

        // Validation
        if ($numberOfSeats < 1) {
            $this->setFlash('error', 'Le nombre de places doit être au moins 1.');
            $this->redirect('reservation', 'create', ['eventId' => $eventId]);
        }

        if ($numberOfSeats > $event->getAvailableSpots()) {
            $this->setFlash('error', 'Pas assez de places disponibles.');
            $this->redirect('reservation', 'create', ['eventId' => $eventId]);
        }

        // Calculer le montant
        $amountPaid = $event->getPrice() * $numberOfSeats;

        // Créer la réservation
        $reservation = new ReservationEntity();
        $reservation
            ->setUserId($_SESSION['user_id'])
            ->setEventId($eventId)
            ->setReservationNumber($reservationModel->generateReservationNumber())
            ->setStatus('confirmed')
            ->setNumberOfSeats($numberOfSeats)
            ->setAmountPaid($amountPaid)
            ->setPaymentStatus('pending')
            ->setPaymentMethod('CB')
            ->setUserNotes($userNotes);

        $reservationId = $reservationModel->insert($reservation);

        if ($reservationId) {
            // Mettre à jour les places disponibles
            $newAvailableSpots = $event->getAvailableSpots() - $numberOfSeats;
            $event->setAvailableSpots($newAvailableSpots);
            $eventModel->update($event);

            $this->setFlash('success', 'Réservation confirmée ! Numéro : ' . $reservation->getReservationNumber() . ' 🎉');
            $this->redirect('reservation', 'myReservations');
        }

        $this->setFlash('error', 'Erreur lors de la réservation.');
        $this->redirect('reservation', 'create', ['eventId' => $eventId]);
    }

    $this->render('reservation/create', [
        'title' => 'Réserver - ' . $event->getTitle(),
        'event' => $event
    ]);
}
    // ============================================================
    // MES RÉSERVATIONS
    // ============================================================
    public function myReservations(): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        $model = new Reservation();
        $reservations = $model->getByUserId($_SESSION['user_id']);

        $this->render('reservation/my-reservations', [
            'title' => 'Mes réservations',
            'reservations' => $reservations
            // nom => valeur
        ]);
    }// ça dit: "Charge le fichier App/Views/reservation/my-reservations.php
//et donne-lui accès à une variable $reservations qui contient $reservations" qui sera utilisées dans la vue "admin/reservations"

    // ============================================================
    // ANNULER UNE RÉSERVATION
    // ============================================================
    public function cancel(int $id): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        $model = new Reservation();
        $reservation = $model->getById($id);

        if (!$reservation) {
            $this->setFlash('error', 'Réservation introuvable.');
            $this->redirect('reservation', 'myReservations');
        }

        // Vérifier que c'est bien la réservation de l'utilisateur
        if ($reservation->getUserId() !== $_SESSION['user_id']) {
            $this->setFlash('error', 'Vous ne pouvez pas annuler cette réservation.');
            $this->redirect('reservation', 'myReservations');
        }

        // Vérifier que la réservation n'est pas déjà annulée
        if ($reservation->getStatus() === 'cancelled') {
            $this->setFlash('warning', 'Cette réservation est déjà annulée.');
            $this->redirect('reservation', 'myReservations');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reason = trim($_POST['cancellation_reason'] ?? 'Annulation par l\'utilisateur');

            $ok = $model->cancel($id, $reason);

            if ($ok) {
                // Remettre les places disponibles
                $eventModel = new Event();
                $event = $eventModel->getById($reservation->getEventId());
                
                if ($event) {
                    $newAvailableSpots = $event->getAvailableSpots() + $reservation->getNumberOfSeats();
                    $event->setAvailableSpots($newAvailableSpots);
                    $eventModel->update($event);
                }

                $this->setFlash('success', 'Réservation annulée avec succès.');
                $this->redirect('reservation', 'myReservations');
            }

            $this->setFlash('error', 'Erreur lors de l\'annulation.');
            $this->redirect('reservation', 'myReservations');
        }

        $this->render('reservation/cancel', [
            'title' => 'Annuler la réservation',
            'reservation' => $reservation
        ]);
    }

    // ============================================================
    // DÉTAILS D'UNE RÉSERVATION
    // ============================================================
    public function show(int $id): void
    {
        // 🔒 Protection : utilisateur connecté
        $this->requireLogin();

        $model = new Reservation();
        $reservation = $model->getById($id);

        if (!$reservation) {
            $this->setFlash('error', 'Réservation introuvable.');
            $this->redirect('reservation', 'myReservations');
        }

        // Vérifier que c'est bien la réservation de l'utilisateur (ou admin)
        $isAdmin = ($_SESSION['role'] ?? '') === 'admin';
        if ($reservation->getUserId() !== $_SESSION['user_id'] && !$isAdmin) {
            $this->setFlash('error', 'Vous ne pouvez pas voir cette réservation.');
            $this->redirect('reservation', 'myReservations');
        }

        $this->render('reservation/show', [
            'title' => 'Détails de la réservation',
            'reservation' => $reservation
            
        ]);
    }
}