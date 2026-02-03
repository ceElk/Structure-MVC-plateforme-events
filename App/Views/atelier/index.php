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
                            <a class="btn btn-outline-dark w-100 rounded-pill" href="<?= $urlShow ?>">
                                👁 Voir
                            </a>

                            <!-- 🔒 BOUTONS MODIFIER visible uniquement pour admin -->
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a class="btn btn-outline-primary w-100 rounded-pill" href="<?= $urlEdit ?>">
                                    ✏️ Modifier
                                </a>
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