<?php

namespace App\Entities;

class ReservationEntity
{
    private ?int $id = null;
    private ?int $userId = null;
    private ?int $eventId = null;
    private ?string $reservationNumber = null;
    private ?string $status = 'confirmed';
    private ?int $numberOfSeats = 1;
    private ?float $amountPaid = 0.00;
    private ?string $paymentStatus = 'pending';
    private ?string $paymentMethod = null;
    private ?string $reservedAt = null;
    private ?string $confirmedAt = null;
    private ?string $cancelledAt = null;
    private ?string $cancellationReason = null;
    private ?string $userNotes = null;
    private ?string $adminNotes = null;
    private ?string $createdAt = null;
    private ?string $updatedAt = null;

    // Relations
    private ?string $userName = null;
    private ?string $eventTitle = null;
    private ?string $eventDate = null;

    // ========== GETTERS ==========
    
    public function getId(): ?int { return $this->id; }
    public function getUserId(): ?int { return $this->userId; }
    public function getEventId(): ?int { return $this->eventId; }
    public function getReservationNumber(): ?string { return $this->reservationNumber; }
    public function getStatus(): ?string { return $this->status; }
    public function getNumberOfSeats(): ?int { return $this->numberOfSeats; }
    public function getAmountPaid(): ?float { return $this->amountPaid; }
    public function getPaymentStatus(): ?string { return $this->paymentStatus; }
    public function getPaymentMethod(): ?string { return $this->paymentMethod; }
    public function getReservedAt(): ?string { return $this->reservedAt; }
    public function getConfirmedAt(): ?string { return $this->confirmedAt; }
    public function getCancelledAt(): ?string { return $this->cancelledAt; }
    public function getCancellationReason(): ?string { return $this->cancellationReason; }
    public function getUserNotes(): ?string { return $this->userNotes; }
    public function getAdminNotes(): ?string { return $this->adminNotes; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function getUserName(): ?string { return $this->userName; }
    public function getEventTitle(): ?string { return $this->eventTitle; }
    public function getEventDate(): ?string { return $this->eventDate; }

    // ========== SETTERS ==========
    
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function setUserId(?int $userId): self { $this->userId = $userId; return $this; }
    public function setEventId(?int $eventId): self { $this->eventId = $eventId; return $this; }
    public function setReservationNumber(?string $reservationNumber): self { $this->reservationNumber = $reservationNumber; return $this; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }
    public function setNumberOfSeats(?int $numberOfSeats): self { $this->numberOfSeats = $numberOfSeats; return $this; }
    public function setAmountPaid(?float $amountPaid): self { $this->amountPaid = $amountPaid; return $this; }
    public function setPaymentStatus(?string $paymentStatus): self { $this->paymentStatus = $paymentStatus; return $this; }
    public function setPaymentMethod(?string $paymentMethod): self { $this->paymentMethod = $paymentMethod; return $this; }
    public function setReservedAt(?string $reservedAt): self { $this->reservedAt = $reservedAt; return $this; }
    public function setConfirmedAt(?string $confirmedAt): self { $this->confirmedAt = $confirmedAt; return $this; }
    public function setCancelledAt(?string $cancelledAt): self { $this->cancelledAt = $cancelledAt; return $this; }
    public function setCancellationReason(?string $cancellationReason): self { $this->cancellationReason = $cancellationReason; return $this; }
    public function setUserNotes(?string $userNotes): self { $this->userNotes = $userNotes; return $this; }
    public function setAdminNotes(?string $adminNotes): self { $this->adminNotes = $adminNotes; return $this; }
    public function setCreatedAt(?string $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(?string $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
    public function setUserName(?string $userName): self { $this->userName = $userName; return $this; }
    public function setEventTitle(?string $eventTitle): self { $this->eventTitle = $eventTitle; return $this; }
    public function setEventDate(?string $eventDate): self { $this->eventDate = $eventDate; return $this; }

    // ========== MÉTHODES UTILES ==========
    
    public function getFormattedReservedAt(string $format = 'd/m/Y H:i'): ?string
    {
        if (!$this->reservedAt) return null;
        try {
            return (new \DateTime($this->reservedAt))->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getFormattedEventDate(string $format = 'd/m/Y H:i'): ?string
    {
        if (!$this->eventDate) return null;
        try {
            return (new \DateTime($this->eventDate))->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getStatusBadge(): string
    {
        return match($this->status) {
            'confirmed' => '<span class="badge bg-success">Confirmée</span>',
            'pending' => '<span class="badge bg-warning">En attente</span>',
            'cancelled' => '<span class="badge bg-danger">Annulée</span>',
            'attended' => '<span class="badge bg-info">Présent</span>',
            default => '<span class="badge bg-secondary">Inconnue</span>'
        };
    }

    public function getPaymentStatusBadge(): string
    {
        return match($this->paymentStatus) {
            'paid' => '<span class="badge bg-success">Payé</span>',
            'pending' => '<span class="badge bg-warning">En attente</span>',
            'refunded' => '<span class="badge bg-danger">Remboursé</span>',
            default => '<span class="badge bg-secondary">Inconnu</span>'
        };
    }
}