<?php /** @var \App\Entities\EventEntity $event */ ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="?controller=<?= $event->getType() === 'atelier' ? 'atelier' : 'event' ?>&action=show&id=<?= $event->getId() ?>" 
               class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à l'événement
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h2 class="mb-0">
                    <i class="fas fa-ticket-alt me-2"></i> Réserver votre place
                </h2>
            </div>

            <div class="card-body p-4">
                <!-- Récapitulatif événement -->
                <div class="alert alert-info mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-calendar-check me-2"></i>
                        <?= htmlspecialchars($event->getTitle()) ?>
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>📅 Date :</strong> 
                            <?= htmlspecialchars($event->getFormattedDateStart('d/m/Y')) ?>
                            <?php if ($event->getFormattedTimeStart('H:i')): ?>
                                à <?= htmlspecialchars($event->getFormattedTimeStart('H:i')) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>📍 Lieu :</strong> 
                            <?= htmlspecialchars($event->getLocationCity() ?? 'Non défini') ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>💰 Prix unitaire :</strong> 
                            <span class="text-success fw-bold"><?= htmlspecialchars($event->getFormattedPrice()) ?></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>👥 Places disponibles :</strong> 
                            <span class="badge bg-warning text-dark"><?= (int)$event->getAvailableSpots() ?></span>
                        </div>
                    </div>
                </div>

                <!-- Formulaire de réservation -->
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-users me-2"></i>Nombre de places *
                        </label>
                        <input type="number" 
                               name="number_of_seats" 
                               class="form-control" 
                               min="1" 
                               max="<?= (int)$event->getAvailableSpots() ?>"
                               value="1"
                               required
                               id="numberOfSeats">
                        <small class="form-text text-muted">
                            Maximum : <?= (int)$event->getAvailableSpots() ?> place(s)
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-comment me-2"></i>Notes (optionnel)
                        </label>
                        <textarea name="user_notes" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Informations complémentaires, besoins spécifiques..."></textarea>
                    </div>

                    <!-- Récapitulatif prix -->
                    <div class="alert alert-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total à payer :</span>
                            <span class="fs-4 fw-bold" id="totalAmount">
                                <?= htmlspecialchars($event->getFormattedPrice()) ?>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-check-circle me-2"></i> Confirmer ma réservation
                        </button>
                        <a href="?controller=<?= $event->getType() === 'atelier' ? 'atelier' : 'event' ?>&action=show&id=<?= $event->getId() ?>" 
                           class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Calculer le total dynamiquement
const pricePerSeat = <?= $event->getPrice() ?>;
const numberOfSeatsInput = document.getElementById('numberOfSeats');
const totalAmountSpan = document.getElementById('totalAmount');

numberOfSeatsInput.addEventListener('input', function() {
    const seats = parseInt(this.value) || 1;
    const total = (pricePerSeat * seats).toFixed(2);
    totalAmountSpan.textContent = total + ' €';
});
</script>