<?php
/** @var \App\Entities\EventEntity $atelier */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><?= htmlspecialchars($atelier->getTitle() ?? 'Atelier') ?></h1>
    
    <div class="d-flex gap-2">
        <!-- 🔒 BOUTONS MODIFIER/SUPPRIMER visibles uniquement pour admin -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a class="btn btn-outline-primary"
               href="?controller=atelier&action=edit&id=<?= (int)$atelier->getId() ?>">
                ✏️ Modifier
            </a>

            <a class="btn btn-outline-danger"
               href="?controller=atelier&action=delete&id=<?= (int)$atelier->getId() ?>"
               onclick="return confirm('Supprimer cet atelier ?');">
                🗑 Supprimer
            </a>
        <?php endif; ?>

        <a class="btn btn-secondary"
           href="?controller=atelier&action=index">
            ↩ Retour
        </a>
    </div>
</div>

<!-- Image -->
<?php if ($atelier->getImage()): ?>
    <div class="mb-4" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <img src="<?= $BASE_URL ?>/<?= htmlspecialchars($atelier->getImage()) ?>" 
             alt="<?= htmlspecialchars($atelier->getTitle()) ?>" 
             style="width: 100%; max-width: 1200px; height: 500px; object-fit: cover; display: block;">
    </div>
<?php else: ?>
    <div class="alert alert-info">Aucune image pour cet atelier</div>
<?php endif; ?>

<!-- INFORMATIONS -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">📋 Informations</h5>

                <p class="mb-2">
                    <strong>Type :</strong>
                    <span class="badge bg-primary"><?= htmlspecialchars($atelier->getType() ?? '') ?></span>
                </p>

                <p class="mb-2">
                    <strong>📅 Date :</strong>
                    <?= htmlspecialchars($atelier->getFormattedDateStart('d/m/Y') ?? 'Non définie') ?>
                    <?php $time = $atelier->getFormattedTimeStart('H:i'); ?>
                    <?php if ($time): ?>
                        à <?= htmlspecialchars($time) ?>
                    <?php endif; ?>
                </p>

                <p class="mb-2">
                    <strong>📍 Ville :</strong>
                    <?= htmlspecialchars($atelier->getLocationCity() ?? 'Non définie') ?>
                </p>

                <p class="mb-2">
                    <strong>📮 Code postal :</strong>
                    <?= htmlspecialchars($atelier->getLocationPostalCode() ?? '-') ?>
                </p>

                <p class="mb-2">
                    <strong>💰 Prix :</strong>
                    <span class="text-success fw-bold"><?= htmlspecialchars($atelier->getFormattedPrice()) ?></span>
                </p>

                <p class="mb-2">
                    <strong>👥 Places restantes :</strong>
                    <span class="badge bg-warning text-dark"><?= (int)$atelier->getAvailableSpots() ?></span>
                </p>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">📝 Description</h5>

                <?php if (!empty($atelier->getShortDescription())): ?>
                    <p class="text-muted fst-italic mb-3">
                        <?= nl2br(htmlspecialchars($atelier->getShortDescription())) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($atelier->getDescription())): ?>
                    <p>
                        <?= nl2br(htmlspecialchars($atelier->getDescription())) ?>
                    </p>
                <?php else: ?>
                    <p class="text-muted">Aucune description disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ✅ BOUTON RÉSERVER (visible uniquement pour les utilisateurs connectés NON ADMIN) -->
<?php if (isset($_SESSION['user_id']) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')): ?>
    <?php if ($atelier->getAvailableSpots() > 0): ?>
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center p-4">
                <h4 class="fw-bold mb-3">
                    <i class="fas fa-ticket-alt me-2 text-warning"></i>
                    Réservez votre place maintenant !
                </h4>
                <p class="text-muted mb-4">
                    Il reste <strong><?= (int)$atelier->getAvailableSpots() ?></strong> place(s) disponible(s)
                </p>
                <a href="?controller=reservation&action=create&eventId=<?= (int)$atelier->getId() ?>" 
                   class="btn btn-warning btn-lg">
                    <i class="fas fa-check-circle me-2"></i> Réserver maintenant
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Complet !</strong> Il n'y a plus de places disponibles pour cet atelier.
        </div>
    <?php endif; ?>
<?php elseif (!isset($_SESSION['user_id'])): ?>
    <!-- Si non connecté, bouton pour se connecter -->
    <div class="card border-0 shadow-sm bg-light">
        <div class="card-body text-center p-4">
            <h4 class="fw-bold mb-3">
                <i class="fas fa-lock me-2 text-warning"></i>
                Connectez-vous pour réserver
            </h4>
            <p class="text-muted mb-4">
                Vous devez être connecté pour réserver une place à cet atelier.
            </p>
            <a href="?controller=auth&action=login" class="btn btn-warning btn-lg me-2">
                <i class="fas fa-sign-in-alt me-2"></i> Se connecter
            </a>
            <a href="?controller=auth&action=register" class="btn btn-outline-warning btn-lg">
                <i class="fas fa-user-plus me-2"></i> S'inscrire
            </a>
        </div>
    </div>
<?php endif; ?>