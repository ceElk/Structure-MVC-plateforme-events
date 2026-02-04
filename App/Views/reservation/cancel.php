<?php /** @var \App\Entities\ReservationEntity $reservation */ ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="mb-4">
            <a href="?controller=reservation&action=show&id=<?= (int)$reservation->getId() ?>" 
               class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white py-3">
                <h2 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i> Annuler la réservation
                </h2>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-warning mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Attention :</strong> Cette action est irréversible.
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold">Récapitulatif</h5>
                    <p class="mb-2">
                        <strong>Événement :</strong> 
                        <?= htmlspecialchars($reservation->getEventTitle()) ?>
                    </p>
                    <p class="mb-2">
                        <strong>Numéro :</strong> 
                        <code><?= htmlspecialchars($reservation->getReservationNumber()) ?></code>
                    </p>
                    <p class="mb-0">
                        <strong>Places :</strong> 
                        <?= (int)$reservation->getNumberOfSeats() ?>
                    </p>
                </div>

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Raison de l'annulation (optionnel)
                        </label>
                        <textarea name="cancellation_reason" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Ex: Empêchement, changement de programme..."></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times-circle me-2"></i> Confirmer l'annulation
                        </button>
                        <a href="?controller=reservation&action=show&id=<?= (int)$reservation->getId() ?>" 
                           class="btn btn-outline-secondary">
                            Ne pas annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>