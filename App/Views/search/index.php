<div class="mb-4">
    <h1 class="mb-2">
        <i class="fas fa-search me-2"></i> Résultats de recherche
    </h1>
    <p class="text-muted">
        <?= (int)$count ?> résultat<?= $count > 1 ? 's' : '' ?> pour 
        <strong>"<?= htmlspecialchars($query) ?>"</strong>
    </p>
</div>

<?php if (!empty($results)): ?>
    <div class="row g-4">
        <?php foreach ($results as $event): ?>
            <?php
            /** @var \App\Entities\EventEntity $event */
            $type = $event->getType();
            $controller = ($type === 'atelier') ? 'atelier' : 'event';
            $iconClass = ($type === 'atelier') ? 'fa-palette' : 'fa-glass-cheers';
            $badgeClass = ($type === 'atelier') ? 'bg-primary' : 'bg-success';
            ?>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <?php if ($event->getImage()): ?>
                        <img src="<?= $BASE_URL ?>/<?= htmlspecialchars($event->getImage()) ?>" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas <?= $iconClass ?> fa-4x text-white"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <span class="badge <?= $badgeClass ?> mb-2">
                            <i class="fas <?= $iconClass ?> me-1"></i>
                            <?= ucfirst($type) ?>
                        </span>
                        
                        <h5 class="card-title"><?= htmlspecialchars($event->getTitle() ?? '') ?></h5>
                        
                        <?php if ($event->getShortDescription()): ?>
                            <p class="card-text text-muted">
                                <?= htmlspecialchars(substr($event->getShortDescription(), 0, 100)) ?>...
                            </p>
                        <?php endif; ?>
                        
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?= htmlspecialchars($event->getFormattedDateStart('d/m/Y') ?? 'Date à définir') ?>
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <?= htmlspecialchars($event->getLocationCity() ?? 'Non défini') ?>
                            </small>
                        </div>
                        
                        <a href="?controller=<?= $controller ?>&action=show&id=<?= (int)$event->getId() ?>" 
                           class="btn btn-sm btn-outline-primary w-100">
                            Voir les détails
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle me-2"></i>
        Aucun résultat trouvé pour "<?= htmlspecialchars($query) ?>".
    </div>
    
    <div class="text-center mt-4">
        <a href="?controller=event&action=index" class="btn btn-primary me-2">
            <i class="fas fa-calendar-alt me-2"></i> Voir tous les événements
        </a>
        <a href="?controller=atelier&action=index" class="btn btn-warning">
            <i class="fas fa-palette me-2"></i> Voir tous les ateliers
        </a>
    </div>
<?php endif; ?>