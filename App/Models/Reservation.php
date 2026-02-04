<?php

namespace App\Models;

use App\Core\DbConnect;
use App\Entities\ReservationEntity;

class Reservation extends DbConnect
{
    /**
     * Récupère toutes les réservations d'un utilisateur
     */
    public function getByUserId(int $userId): array
    {
        $sql = "SELECT r.*, u.username as user_name, e.title as event_title, e.date_start as event_date
                FROM reservations r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN events e ON r.event_id = e.id
                WHERE r.user_id = :user_id
                ORDER BY r.created_at DESC";
        
        $data = $this->fetchAll($sql, [':user_id' => $userId]);
        return $this->toEntities($data);
    }

    /**
     * Récupère une réservation par ID
     */
    public function getById(int $id): ?ReservationEntity
    {
        $sql = "SELECT r.*, u.username as user_name, e.title as event_title, e.date_start as event_date
                FROM reservations r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN events e ON r.event_id = e.id
                WHERE r.id = :id";
        
        $data = $this->fetchOne($sql, [':id' => $id]);
        return $data ? $this->toEntity($data) : null;
    }

    /**
     * Récupère toutes les réservations (admin)
     */
    public function getAll(): array
    {
        $sql = "SELECT r.*, u.username as user_name, e.title as event_title, e.date_start as event_date
                FROM reservations r
                LEFT JOIN users u ON r.user_id = u.id
                LEFT JOIN events e ON r.event_id = e.id
                ORDER BY r.created_at DESC";
        
        $data = $this->fetchAll($sql);
        return $this->toEntities($data);
    }

    /**
     * Crée une nouvelle réservation
     */
    public function insert(ReservationEntity $reservation): ?int
    {
        $sql = "INSERT INTO reservations (
                    user_id, event_id, reservation_number, status, number_of_seats,
                    amount_paid, payment_status, payment_method, user_notes
                ) VALUES (
                    :user_id, :event_id, :reservation_number, :status, :number_of_seats,
                    :amount_paid, :payment_status, :payment_method, :user_notes
                )";
        
        $bindings = [
            ':user_id' => $reservation->getUserId(),
            ':event_id' => $reservation->getEventId(),
            ':reservation_number' => $reservation->getReservationNumber(),
            ':status' => $reservation->getStatus() ?? 'confirmed',
            ':number_of_seats' => $reservation->getNumberOfSeats() ?? 1,
            ':amount_paid' => $reservation->getAmountPaid() ?? 0.00,
            ':payment_status' => $reservation->getPaymentStatus() ?? 'pending',
            ':payment_method' => $reservation->getPaymentMethod(),
            ':user_notes' => $reservation->getUserNotes()
        ];
        
        return $this->executeInsert($sql, $bindings);
    }

    /**
     * Annule une réservation
     */
    public function cancel(int $id, string $reason = null): bool
    {
        $sql = "UPDATE reservations 
                SET status = 'cancelled',
                    cancelled_at = NOW(),
                    cancellation_reason = :reason
                WHERE id = :id";
        
        return $this->execute($sql, [
            ':id' => $id,
            ':reason' => $reason
        ]);
    }

    /**
     * Génère un numéro de réservation unique
     */
    public function generateReservationNumber(): string
    {
        return 'RES-' . date('Y') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Vérifie si un utilisateur a déjà réservé cet événement
     */
    public function hasUserReserved(int $userId, int $eventId): bool
    {
        $sql = "SELECT COUNT(*) as total 
                FROM reservations 
                WHERE user_id = :user_id 
                AND event_id = :event_id 
                AND status != 'cancelled'";
        
        $result = $this->fetchOne($sql, [
            ':user_id' => $userId,
            ':event_id' => $eventId
        ]);
        
        return ((int)$result->total) > 0;
    }

    /**
     * Convertit un tableau en ReservationEntity
     */
    protected function toEntity($data): ReservationEntity
    {
        if (is_object($data)) {
            $data = (array)$data;
        }

        $reservation = new ReservationEntity();
        
        if (isset($data['id'])) $reservation->setId((int)$data['id']);
        if (isset($data['user_id'])) $reservation->setUserId((int)$data['user_id']);
        if (isset($data['event_id'])) $reservation->setEventId((int)$data['event_id']);
        if (isset($data['reservation_number'])) $reservation->setReservationNumber($data['reservation_number']);
        if (isset($data['status'])) $reservation->setStatus($data['status']);
        if (isset($data['number_of_seats'])) $reservation->setNumberOfSeats((int)$data['number_of_seats']);
        if (isset($data['amount_paid'])) $reservation->setAmountPaid((float)$data['amount_paid']);
        if (isset($data['payment_status'])) $reservation->setPaymentStatus($data['payment_status']);
        if (isset($data['payment_method'])) $reservation->setPaymentMethod($data['payment_method']);
        if (isset($data['reserved_at'])) $reservation->setReservedAt($data['reserved_at']);
        if (isset($data['confirmed_at'])) $reservation->setConfirmedAt($data['confirmed_at']);
        if (isset($data['cancelled_at'])) $reservation->setCancelledAt($data['cancelled_at']);
        if (isset($data['cancellation_reason'])) $reservation->setCancellationReason($data['cancellation_reason']);
        if (isset($data['user_notes'])) $reservation->setUserNotes($data['user_notes']);
        if (isset($data['admin_notes'])) $reservation->setAdminNotes($data['admin_notes']);
        if (isset($data['created_at'])) $reservation->setCreatedAt($data['created_at']);
        if (isset($data['updated_at'])) $reservation->setUpdatedAt($data['updated_at']);
        if (isset($data['user_name'])) $reservation->setUserName($data['user_name']);
        if (isset($data['event_title'])) $reservation->setEventTitle($data['event_title']);
        if (isset($data['event_date'])) $reservation->setEventDate($data['event_date']);
        
        return $reservation;
    }

    /**
     * Convertit un tableau d'arrays en tableau de ReservationEntity
     */
    protected function toEntities(array $dataList): array
    {
        $reservations = [];
        foreach ($dataList as $data) {
            $reservations[] = $this->toEntity($data);
        }
        return $reservations;
    }
}