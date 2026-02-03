<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">🎉 Événements</h1>
    
    <!-- 🔒 BOUTON CRÉER visible uniquement pour admin -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="?controller=event&action=create" class="btn btn-primary">
            ➕ Créer un événement
        </a>
    <?php endif; ?>
</div>

<!-- Filtres par catégorie -->
<?php if (!empty($categories)): ?>
    <div class="mb-4">
        <div class="btn-group" role="group">
            <a href="?controller=event&action=index" 
               class="btn <?= !isset($selectedCategory) ? 'btn-primary' : 'btn-outline-primary' ?>">
                Tous
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="?controller=event&action=index&category=<?= (int)$cat->id ?>" 
                   class="btn <?= (isset($selectedCategory) && $selectedCategory == $cat->id) ? 'btn-primary' : 'btn-outline-primary' ?>">
                    <i class="<?= htmlspecialchars($cat->icon ?? 'fas fa-tag') ?> me-1"></i>
                    <?= htmlspecialchars($cat->name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Liste des événements -->
<?php if (!empty($evenements)): ?>
    <div class="row g-4">
        <?php foreach ($evenements as $evenement): ?>
            <?php /** @var \App\Entities\EventEntity $evenement */ ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <?php if ($evenement->getImage()): ?>
                        <img src="<?= $BASE_URL ?>/<?= htmlspecialchars($evenement->getImage()) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($evenement->getTitle()) ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-glass-cheers fa-4x text-white"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($evenement->getTitle() ?? '') ?></h5>
                        
                        <?php if ($evenement->getShortDescription()): ?>
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(substr($evenement->getShortDescription(), 0, 100)) ?>...
                            </p>
                        <?php endif; ?>
                        
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?= htmlspecialchars($evenement->getFormattedDateStart('d/m/Y') ?? 'Date à définir') ?>
                            </small>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <?= htmlspecialchars($evenement->getLocationCity() ?? 'Non défini') ?>
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <span class="badge bg-primary">
                                <?= htmlspecialchars($evenement->getFormattedPrice()) ?>
                            </span>
                            <span class="badge bg-warning text-dark">
                                <?= (int)$evenement->getAvailableSpots() ?> places
                            </span>
                        </div>
                        
                        <a href="?controller=event&action=show&id=<?= (int)$evenement->getId() ?>" 
                           class="btn btn-sm btn-outline-primary w-100">
                            Voir les détails
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Aucun événement pour le moment.
    </div>
<?php endif; ?>