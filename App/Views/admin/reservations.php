cat > /Applications/MAMP/htdocs/coursPhp2025/POO/plateforme-events/App/Views/admin/reservations.php << 'EOF'
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">
        <i class="fas fa-clipboard-list me-2"></i> Toutes les réservations
    </h1>
    <a href="?controller=admin&action=dashboard" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour au dashboard
    </a>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-ticket-alt fa-2x text-primary mb-2"></i>
                <h3 class="fw-bold mb-1"><?= count($reservations) ?></h3>
                <p class="text-muted mb-0">Total réservations</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3 class="fw-bold mb-1">
                    <?= count(array_filter($reservations, fn($r) => $r->getStatus() === 'confirmed')) ?>
                </h3>
                <p class="text-muted mb-0">Confirmées</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-hourglass-half fa-2x text-warning mb-2"></i>
                <h3 class="fw-bold mb-1">
                    <?= count(array_filter($reservations, fn($r) => $r->getStatus() === 'pending')) ?>
                </h3>
                <p class="text-muted mb-0">En attente</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                <h3 class="fw-bold mb-1">
                    <?= count(array_filter($reservations, fn($r) => $r->getStatus() === 'cancelled')) ?>
                </h3>
                <p class="text-muted mb-0">Annulées</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="reservations">
            
            <div class="col-md-3">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="confirmed" <?= ($_GET['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmées</option>
                    <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>En attente</option>
                    <option value="cancelled" <?= ($_GET['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Annulées</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Recherche</label>
                <input type="text" name="search" class="form-control" placeholder="N° réservation, nom..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i> Filtrer
                </button>
                <a href="?controller=admin&action=reservations" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des réservations -->
<?php if (empty($reservations)): ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Aucune réservation pour le moment.
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N° Réservation</th>
                            <th>Utilisateur</th>
                            <th>Événement</th>
                            <th>Date événement</th>
                            <th>Places</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Date réservation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Filtrage
                        $filteredReservations = $reservations;
                        
                        if (!empty($_GET['status'])) {
                            $filteredReservations = array_filter($filteredReservations, function($r) {
                                return $r->getStatus() === $_GET['status'];
                            });
                        }
                        
                        if (!empty($_GET['search'])) {
                            $search = strtolower($_GET['search']);
                            $filteredReservations = array_filter($filteredReservations, function($r) use ($search) {
                                return str_contains(strtolower($r->getReservationNumber()), $search) ||
                                       str_contains(strtolower($r->getUserName() ?? ''), $search) ||
                                       str_contains(strtolower($r->getEventTitle() ?? ''), $search);
                            });
                        }
                        ?>
                        
                        <?php foreach ($filteredReservations as $reservation): ?>
                            <?php /** @var \App\Entities\ReservationEntity $reservation */ ?>
                            <tr>
                                <td>
                                    <code><?= htmlspecialchars($reservation->getReservationNumber()) ?></code>
                                </td>
                                <td>
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    <?= htmlspecialchars($reservation->getUserName() ?? 'N/A') ?>
                                </td>
                                <td>
                                    <i class="fas fa-calendar me-2 text-muted"></i>
                                    <?= htmlspecialchars($reservation->getEventTitle() ?? 'N/A') ?>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars($reservation->getFormattedEventDate('d/m/Y') ?? '-') ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary"><?= (int)$reservation->getNumberOfSeats() ?></span>
                                </td>
                                <td>
                                    <strong><?= number_format($reservation->getAmountPaid(), 2, ',', ' ') ?> €</strong>
                                </td>
                                <td>
                                    <?= $reservation->getStatusBadge() ?>
                                </td>
                                <td>
                                    <small><?= htmlspecialchars($reservation->getFormattedReservedAt('d/m/Y H:i')) ?></small>
                                </td>
                                <td>
                                    <a href="?controller=reservation&action=show&id=<?= (int)$reservation->getId() ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
EOF