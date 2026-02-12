<?php
/** @var \App\Entities\EventEntity[] $ateliers */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Ateliers</h1>

    <!-- 🔒 BOUTON CRÉER visible uniquement pour admin -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a class="btn btn-primary" href="?controller=atelier&action=create">
            ➕ Créer un atelier
        </a>
    <?php endif; ?>
</div>

<?php if (empty($ateliers)): ?>
    <div class="alert alert-info shadow-sm">
        Aucun atelier pour le moment.
    </div>
<?php else: ?>
    <!-- Filtres avancés -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">
            <i class="fas fa-filter me-2"></i> Filtres avancés
        </h5>
        
        <form method="GET" class="row g-3">
            <input type="hidden" name="controller" value="<?= $type === 'atelier' ? 'atelier' : 'event' ?>">
            <input type="hidden" name="action" value="index">
            
            <div class="col-md-3">
                <label class="form-label">Ville</label>
                <input type="text" 
                       name="city" 
                       class="form-control" 
                       placeholder="Paris, Lyon..."
                       value="<?= htmlspecialchars($_GET['city'] ?? '') ?>">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Prix minimum</label>
                <input type="number" 
                       name="price_min" 
                       class="form-control" 
                       placeholder="0"
                       min="0"
                       step="0.01"
                       value="<?= htmlspecialchars($_GET['price_min'] ?? '') ?>">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Prix maximum</label>
                <input type="number" 
                       name="price_max" 
                       class="form-control" 
                       placeholder="100"
                       min="0"
                       step="0.01"
                       value="<?= htmlspecialchars($_GET['price_max'] ?? '') ?>">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">Date à partir de</label>
                <input type="date" 
                       name="date_min" 
                       class="form-control"
                       value="<?= htmlspecialchars($_GET['date_min'] ?? '') ?>">
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search me-2"></i> Appliquer les filtres
                </button>
                <a href="?controller=<?= $type === 'atelier' ? 'atelier' : 'event' ?>&action=index" 
                   class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

    <div class="row g-4">
        <?php foreach ($ateliers as $atelier): ?>

            <?php
            $id = (int)$atelier->getId();
            $title = $atelier->getTitle() ?? 'Sans titre';

            $date = $atelier->getFormattedDateStart('d/m/Y') ?? 'Date inconnue';
            $time = $atelier->getFormattedTimeStart('H:i');

            $city = $atelier->getLocationCity() ?? 'Lieu non précisé';
            $postal = $atelier->getLocationPostalCode();
            $price = $atelier->getFormattedPrice();

            $short = $atelier->getShortDescription() ?? '';
            $short = mb_substr($short, 0, 110);
            if ($short !== '') $short .= '...';

            $image = $atelier->getImage();

            $urlShow = "?controller=atelier&action=show&id=$id";
            $urlEdit = "?controller=atelier&action=edit&id=$id";
            $urlDelete = "?controller=atelier&action=delete&id=$id";
            ?>

            <div class="col-12 col-md-6 col-lg-4">
                <article class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                    <!-- Image -->
                    <?php if (!empty($image)): ?>
                        <img src="<?= htmlspecialchars($image) ?>"
                             alt="<?= htmlspecialchars($title) ?>"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center"
                             style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-palette text-white" style="font-size: 50px; opacity: 0.85;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <!-- titre -->
                        <h2 class="h5 fw-bold mb-2">
                            <?= htmlspecialchars($title) ?>
                        </h2>

                        <!-- infos -->
                        <ul class="list-unstyled small text-muted mb-3">
                            <li class="mb-1">
                                <i class="fas fa-calendar-day me-2"></i>
                                <?= htmlspecialchars($date) ?>
                                <?php if ($time): ?>
                                    <span class="ms-1">à <?= htmlspecialchars($time) ?></span>
                                <?php endif; ?>
                            </li>

                            <li class="mb-1">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <?= htmlspecialchars(trim(($postal ?? '') . ' ' . ($city ?? ''))) ?>
                            </li>

                            <li class="mb-1">
                                <i class="fas fa-users me-2"></i>
                                <?= (int)$atelier->getAvailableSpots() ?> place(s) restante(s)
                            </li>

                            <li>
                                <i class="fas fa-tag me-2"></i>
                                <strong><?= htmlspecialchars($price) ?></strong>
                            </li>
                        </ul>

                        <!-- description courte -->
                        <?php if (!empty($short)): ?>
                            <p class="text-muted mb-0">
                                <?= htmlspecialchars($short) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer bg-white border-0 pt-0 pb-4 px-3">
    <div class="d-flex gap-2">
        <button type="button" 
                class="btn btn-outline-dark w-100 rounded-pill" 
                onclick="openAtelierModal(<?= $atelier->getId() ?>)">
            👁 Voir
        </button>

                            <!-- 🔒 BOUTONS MODIFIER visible uniquement pour admin -->
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <button type="button" 
        class="btn-edit" 
        onclick="openEditAtelierModal(<?= $atelier->getId() ?>)">
    ✏️ Modifier
</button>
                            <?php endif; ?>
                        </div>

                        <!-- 🔒 BOUTON SUPPRIMER visible uniquement pour admin -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a class="btn btn-outline-danger w-100 rounded-pill mt-2"
                               href="<?= $urlDelete ?>"
                               onclick="return confirm('Supprimer cet atelier ?');">
                                🗑 Supprimer
                            </a>
                        <?php endif; ?>
                    </div>

                </article>
            </div>

        <?php endforeach; ?>
    </div>

<?php endif; ?>

<!-- ========== MODALE DÉTAILS ATELIER ========== -->
<div class="modal fade" id="atelierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #d4af37;">
                <h5 class="modal-title" id="atelierModalTitle">
                    <i class="fas fa-spinner fa-spin"></i> Chargement...
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="atelierModalBody">
                <!-- Spinner de chargement -->
                <div class="text-center py-5">
                    <div class="spinner-border" style="color: #d4af37;" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-3 text-muted">Chargement des détails...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <a href="#" id="atelierReserveBtn" class="btn btn-primary" style="display:none; background-color: #d4af37; border-color: #d4af37;">
                    <i class="fas fa-ticket-alt me-2"></i> Réserver
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script modale atelier -->
<script src="App/public/assets/js/atelier-modal.js"></script>

<!-- ✅ Script modale édition atelier -->
<script src="App/public/assets/js/atelier-edit-modal.js"></script>


<!-- ========== MODALE MODIFICATION ATELIER ========== -->
<div class="modal fade" id="editAtelierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #d4af37;">
                <h5 class="modal-title" id="editAtelierModalTitle">
                    <i class="fas fa-spinner fa-spin"></i> Chargement...
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editAtelierModalBody">
                <!-- Spinner de chargement -->
                <div class="text-center py-5">
                    <div class="spinner-border" style="color: #d4af37;"></div>
                    <p class="mt-3 text-muted">Chargement du formulaire...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="saveAtelierBtn" style="display:none; background-color: #d4af37; border-color: #d4af37;">
                    <span id="saveText">💾 Enregistrer</span>
                    <span id="saveSpinner" class="spinner-border spinner-border-sm" style="display:none;"></span>
                </button>
            </div>
        </div>
    </div>
</div>