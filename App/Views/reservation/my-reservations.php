<div class="mb-4">
    <h1 class="mb-0">
        <i class="fas fa-ticket-alt me-2"></i> Mes réservations
    </h1>
</div>

<?php if (empty($reservations)): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
            <h3 class="fw-bold mb-3">Aucune réservation</h3>
            <p class="text-muted mb-4">
                Vous n'avez pas encore réservé d'événement ou d'atelier.
            </p>
            <div>
                <a href="?controller=event&action=index" class="btn btn-primary me-2">
                    <i class="fas fa-calendar-alt me-2"></i> Voir les événements
                </a>
                <a href="?controller=atelier&action=index" class="btn btn-warning">
                    <i class="fas fa-palette me-2"></i> Voir les ateliers
                </a>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="row g-4">
        <?php foreach ($reservations as $reservation): ?>
            <?php /** @var \App\Entities\ReservationEntity $reservation */ ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">
                                <?= htmlspecialchars($reservation->getEventTitle() ?? 'Événement') ?>
                            </h5>
                            <?= $reservation->getStatusBadge() ?>
                        </div>

                        <div class="mb-3">
                            <p class="mb-2">
                                <i class="fas fa-hashtag me-2 text-muted"></i>
                                <strong>N° :</strong> 
                                <code><?= htmlspecialchars($reservation->getReservationNumber()) ?></code>
                            </p>

                            <p class="mb-2">
                                <i class="fas fa-calendar me-2 text-muted"></i>
                                <strong>Date événement :</strong><br>
                                <small><?= htmlspecialchars($reservation->getFormattedEventDate('d/m/Y H:i')) ?></small>
                            </p>

                            <p class="mb-2">
                                <i class="fas fa-users me-2 text-muted"></i>
                                <strong>Places :</strong> <?= (int)$reservation->getNumberOfSeats() ?>
                            </p>

                            <p class="mb-2">
                                <i class="fas fa-euro-sign me-2 text-muted"></i>
                                <strong>Montant :</strong> 
                                <span class="text-success fw-bold">
                                    <?= number_format($reservation->getAmountPaid(), 2, ',', ' ') ?> €
                                </span>
                            </p>

                            <p class="mb-2">
                                <i class="fas fa-credit-card me-2 text-muted"></i>
                                <strong>Paiement :</strong> 
                                <?= $reservation->getPaymentStatusBadge() ?>
                            </p>

                            <p class="mb-0">
                                <i class="fas fa-clock me-2 text-muted"></i>
                                <strong>Réservé le :</strong><br>
                                <small><?= htmlspecialchars($reservation->getFormattedReservedAt('d/m/Y H:i')) ?></small>
                            </p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="?controller=reservation&action=show&id=<?= (int)$reservation->getId() ?>" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye me-2"></i> Voir les détails
                            </a>

                            <?php if ($reservation->getStatus() !== 'cancelled'): ?>
                                <a href="?controller=reservation&action=cancel&id=<?= (int)$reservation->getId() ?>" 
                                   class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-times-circle me-2"></i> Annuler
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>