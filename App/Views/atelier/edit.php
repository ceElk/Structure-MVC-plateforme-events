<?php
/** @var \App\Entities\EventEntity $atelier */
?>

<h1 class="mb-4">Modifier un atelier</h1>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Titre *</label>
        <input type="text"
               name="title"
               class="form-control"
               required
               value="<?= htmlspecialchars($atelier->getTitle() ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Lieu / Adresse *</label>
        <input type="text"
               name="location"
               class="form-control"
               required
               value="<?= htmlspecialchars($atelier->getLocation() ?? '') ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description"
                  class="form-control"
                  rows="5"><?= htmlspecialchars($atelier->getDescription() ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Description courte</label>
        <textarea name="short_description"
                  class="form-control"
                  rows="2"><?= htmlspecialchars($atelier->getShortDescription() ?? '') ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Date début *</label>
            <input type="datetime-local"
                   name="date_start"
                   class="form-control"
                   required
                   value="<?= $atelier->getDateStart() ? date('Y-m-d\TH:i', strtotime($atelier->getDateStart())) : '' ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date fin</label>
            <input type="datetime-local"
                   name="date_end"
                   class="form-control"
                   value="<?= $atelier->getDateEnd() ? date('Y-m-d\TH:i', strtotime($atelier->getDateEnd())) : '' ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ville</label>
            <input type="text"
                   name="location_city"
                   class="form-control"
                   value="<?= htmlspecialchars($atelier->getLocationCity() ?? '') ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Code postal</label>
            <input type="text"
                   name="location_postal_code"
                   class="form-control"
                   value="<?= htmlspecialchars($atelier->getLocationPostalCode() ?? '') ?>">
        </div>
    </div>

    <!-- ✅ Image actuelle + upload nouvelle -->
    <div class="mb-3">
        <label class="form-label">Image actuelle</label>

        <?php if (!empty($atelier->getImage())): ?>
            <div class="mb-2">
                <img src="<?= htmlspecialchars($atelier->getImage()) ?>"
                     alt="Image atelier"
                     style="max-width: 250px; height:auto;"
                     class="rounded shadow-sm">
            </div>
            <small class="text-muted d-block"><?= htmlspecialchars($atelier->getImage()) ?></small>
        <?php else: ?>
            <p class="text-muted mb-2">Aucune image.</p>
        <?php endif; ?>

        <label class="form-label mt-3">Changer l’image</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
        <div class="form-text">Si tu n’en choisis pas, l’image actuelle reste.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Prix</label>
        <input type="number"
               step="0.01"
               name="price"
               class="form-control"
               value="<?= htmlspecialchars((string)$atelier->getPrice()) ?>">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Capacité</label>
            <input type="number"
                   name="capacity"
                   class="form-control"
                   value="<?= (int)$atelier->getCapacity() ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number"
                   name="available_spots"
                   class="form-control"
                   value="<?= (int)$atelier->getAvailableSpots() ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Min participants</label>
            <input type="number"
                   name="min_participants"
                   class="form-control"
                   value="<?= (int)$atelier->getMinParticipants() ?>">
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-success">
            ✅ Valider la modification
        </button>

        <a href="?controller=atelier&action=show&id=<?= (int)$atelier->getId() ?>" class="btn btn-outline-secondary">
            Annuler
        </a>
    </div>

</form>
