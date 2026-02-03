<?php
/** @var \App\Entities\EventEntity $evenement */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><?= htmlspecialchars($evenement->getTitle() ?? 'Événement') ?></h1>
    
    <div class="d-flex gap-2">
        <a class="btn btn-outline-primary"
           href="?controller=event&action=edit&id=<?= (int)$evenement->getId() ?>">
            ✏️ Modifier
        </a>

        <a class="btn btn-outline-danger"
           href="?controller=event&action=delete&id=<?= (int)$evenement->getId() ?>"
           onclick="return confirm('Supprimer cet événement ?');">
            🗑 Supprimer
        </a>

        <a class="btn btn-secondary"
           href="?controller=event&action=index">
            ↩ Retour
        </a>
    </div>
</div>

<!-- Image -->
<?php if ($evenement->getImage()): ?>
    <div class="mb-4" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        <img src="<?= $BASE_URL ?>/<?= htmlspecialchars($evenement->getImage()) ?>" 
             alt="<?= htmlspecialchars($evenement->getTitle()) ?>" 
             style="width: 100%; max-width: 1200px; height: 500px; object-fit: cover; display: block;">
    </div>
<?php else: ?>
    <div class="alert alert-info">Aucune image pour cet événement</div>
<?php endif; ?>

<!-- INFORMATIONS -->
<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <h5 class="fw-bold mb-3">📋 Informations</h5>

                <p class="mb-2">
                    <strong>Type :</strong>
                    <span class="badge bg-primary"><?= htmlspecialchars($evenement->getType() ?? '') ?></span>
                </p>

                <p class="mb-2">
                    <strong>📅 Date :</strong>
                    <?= htmlspecialchars($evenement->getFormattedDateStart('d/m/Y') ?? 'Non définie') ?>
                    <?php $time = $evenement->getFormattedTimeStart('H:i'); ?>
                    <?php if ($time): ?>
                        à <?= htmlspecialchars($time) ?>
                    <?php endif; ?>
                </p>

                <p class="mb-2">
                    <strong>📍 Ville :</strong>
                    <?= htmlspecialchars($evenement->getLocationCity() ?? 'Non définie') ?>
                </p>

                <p class="mb-2">
                    <strong>📮 Code postal :</strong>
                    <?= htmlspecialchars($evenement->getLocationPostalCode() ?? '-') ?>
                </p>

                <p class="mb-2">
                    <strong>💰 Prix :</strong>
                    <span class="text-success fw-bold"><?= htmlspecialchars($evenement->getFormattedPrice()) ?></span>
                </p>

                <p class="mb-2">
                    <strong>👥 Places restantes :</strong>
                    <span class="badge bg-warning text-dark"><?= (int)$evenement->getAvailableSpots() ?></span>
                </p>
            </div>

            <div class="col-md-6">
                <h5 class="fw-bold mb-3">📝 Description</h5>

                <?php if (!empty($evenement->getShortDescription())): ?>
                    <p class="text-muted fst-italic mb-3">
                        <?= nl2br(htmlspecialchars($evenement->getShortDescription())) ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($evenement->getDescription())): ?>
                    <p>
                        <?= nl2br(htmlspecialchars($evenement->getDescription())) ?>
                    </p>
                <?php else: ?>
                    <p class="text-muted">Aucune description disponible.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>