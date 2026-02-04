<?php /** @var \App\Entities\ReservationEntity $reservation */ ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="?controller=reservation&action=myReservations" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à mes réservations
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h2 class="mb-0">
                    <i class="fas fa-ticket-alt me-2"></i> Détails de la réservation
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Numéro et statut -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Numéro de réservation :</strong><br>
                            <code class="fs-5"><?= htmlspecialchars($reservation->getReservationNumber()) ?></code>
                        </div>
                        <div>
                            <?= $reservation->getStatusBadge() ?>
                        </div>
                    </div>
                </div>

                <!-- Informations événement -->
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-calendar-alt me-2"></i> Événement
                </h5>
                <div class="mb-4">
                    <p class="mb-2">
                        <strong>Titre :</strong> 
                        <?= htmlspecialchars($reservation->getEventTitle() ?? 'N/A') ?>
                    </p>
                    <p class="mb-2">
                        <strong>Date :</strong> 
                        <?= htmlspecialchars($reservation->getFormattedEventDate('d/m/Y à H:i')) ?>
                    </p>
                </div>

                <!-- Informations réservation -->
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-info-circle me-2"></i> Informations
                </h5>
                <div class="mb-4">
                    <p class="mb-2">
                        <strong>Nombre de places :</strong> 
                        <?= (int)$reservation->getNumberOfSeats() ?>
                    </p>
                    <p class="mb-2">
                        <strong>Montant total :</strong> 
                        <span class="text-success fw-bold">
                            <?= number_format($reservation->getAmountPaid(), 2, ',', ' ') ?> €
                        </span>
                    </p>
                    <p class="mb-2">
                        <strong>Statut du paiement :</strong> 
                        <?= $reservation->getPaymentStatusBadge() ?>
                    </p>
                    <?php if ($reservation->getPaymentMethod()): ?>
                        <p class="mb-2">
                            <strong>Méthode de paiement :</strong> 
                            <?= htmlspecialchars($reservation->getPaymentMethod()) ?>
                        </p>
                    <?php endif; ?>
                    <p class="mb-2">
                        <strong>Réservé le :</strong> 
                        <?= htmlspecialchars($reservation->getFormattedReservedAt('d/m/Y à H:i')) ?>
                    </p>
                </div>

                <!-- Notes utilisateur -->
                <?php if ($reservation->getUserNotes()): ?>
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-comment me-2"></i> Vos notes
                    </h5>
                    <div class="alert alert-secondary mb-4">
                        <?= nl2br(htmlspecialchars($reservation->getUserNotes())) ?>
                    </div>
                <?php endif; ?>

                <!-- Annulation -->
                <?php if ($reservation->getStatus() === 'cancelled'): ?>
                    <div class="alert alert-danger">
                        <h5 class="fw-bold mb-2">
                            <i class="fas fa-times-circle me-2"></i> Réservation annulée
                        </h5>
                        <?php if ($reservation->getCancelledAt()): ?>
                            <p class="mb-2">
                                <strong>Date d'annulation :</strong> 
                                <?= (new DateTime($reservation->getCancelledAt()))->format('d/m/Y à H:i') ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($reservation->getCancellationReason()): ?>
                            <p class="mb-0">
                                <strong>Raison :</strong> 
                                <?= htmlspecialchars($reservation->getCancellationReason()) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <?php if ($reservation->getStatus() !== 'cancelled'): ?>
                    <div class="d-grid gap-2">
                        <a href="?controller=reservation&action=cancel&id=<?= (int)$reservation->getId() ?>" 
                           class="btn btn-danger">
                            <i class="fas fa-times-circle me-2"></i> Annuler cette réservation
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>