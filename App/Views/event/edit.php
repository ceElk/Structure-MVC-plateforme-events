<?php
/** @var \App\Entities\EventEntity $evenement */
?>

<h1 class="mb-4">Modifier un événement</h1>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Titre *</label>
        <input type="text" 
               name="title" 
               class="form-control" 
               value="<?= htmlspecialchars($evenement->getTitle() ?? '') ?>" 
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Lieu / Adresse *</label>
        <input type="text" 
               name="location" 
               class="form-control" 
               value="<?= htmlspecialchars($evenement->getLocation() ?? '') ?>" 
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($evenement->getDescription() ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Description courte</label>
        <textarea name="short_description" class="form-control" rows="2"><?= htmlspecialchars($evenement->getShortDescription() ?? '') ?></textarea>
    </div>

    <!-- ✅ SÉLECTEUR DE CATÉGORIE AVEC PRÉ-SÉLECTION -->
    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select">
            <option value="">-- Aucune catégorie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat->id ?>" 
                        <?= ($evenement->getCategoryId() == $cat->id) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Date début *</label>
            <?php 
            $dateStartValue = '';
            if ($evenement->getDateStart()) {
                $dateStartValue = date('Y-m-d\TH:i', strtotime($evenement->getDateStart()));
            }
            ?>
            <input type="datetime-local" 
                   name="date_start" 
                   class="form-control" 
                   value="<?= $dateStartValue ?>" 
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date fin</label>
            <?php 
            $dateEndValue = '';
            if ($evenement->getDateEnd()) {
                $dateEndValue = date('Y-m-d\TH:i', strtotime($evenement->getDateEnd()));
            }
            ?>
            <input type="datetime-local" 
                   name="date_end" 
                   class="form-control" 
                   value="<?= $dateEndValue ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ville</label>
            <input type="text" 
                   name="location_city" 
                   class="form-control" 
                   value="<?= htmlspecialchars($evenement->getLocationCity() ?? '') ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Code postal</label>
            <input type="text" 
                   name="location_postal_code" 
                   class="form-control" 
                   value="<?= htmlspecialchars($evenement->getLocationPostalCode() ?? '') ?>">
        </div>
    </div>

    <!-- Image actuelle -->
    <?php if ($evenement->getImage()): ?>
        <div class="mb-3">
            <label class="form-label">Image actuelle</label>
            <div>
                <img src="<?= $BASE_URL ?>/<?= htmlspecialchars($evenement->getImage()) ?>" 
                     alt="Image actuelle" 
                     style="max-width: 300px; height: auto; border-radius: 8px;">
            </div>
        </div>
    <?php endif; ?>

    <!-- Upload nouvelle image -->
    <div class="mb-3">
        <label class="form-label">Nouvelle image (optionnel)</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
        <div class="form-text">Laissez vide pour conserver l'image actuelle</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Prix (€)</label>
        <input type="number" 
               step="0.01" 
               name="price" 
               class="form-control" 
               value="<?= $evenement->getPrice() ?>">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Capacité</label>
            <input type="number" 
                   name="capacity" 
                   class="form-control" 
                   value="<?= (int)$evenement->getCapacity() ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number" 
                   name="available_spots" 
                   class="form-control" 
                   value="<?= (int)$evenement->getAvailableSpots() ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Min participants</label>
            <input type="number" 
                   name="min_participants" 
                   class="form-control" 
                   value="<?= (int)$evenement->getMinParticipants() ?>">
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            ✅ Enregistrer
        </button>

        <a href="?controller=event&action=show&id=<?= (int)$evenement->getId() ?>" class="btn btn-secondary">
            ↩ Retour
        </a>
    </div>

</form>