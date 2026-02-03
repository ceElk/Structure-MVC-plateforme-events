<h1 class="mb-4">Créer un événement</h1>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">

    <div class="mb-3">
        <label class="form-label">Titre *</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Lieu / Adresse *</label>
        <input type="text" name="location" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="5"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Description courte</label>
        <textarea name="short_description" class="form-control" rows="2"></textarea>
    </div>

    <!-- Sélecteur de catégorie -->
    <div class="mb-3">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select">
            <option value="">-- Aucune catégorie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= (int)$cat->id ?>">
                    <?= htmlspecialchars($cat->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Date début *</label>
            <input type="datetime-local" name="date_start" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date fin</label>
            <input type="datetime-local" name="date_end" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Ville</label>
            <input type="text" name="location_city" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Code postal</label>
            <input type="text" name="location_postal_code" class="form-control">
        </div>
    </div>

    <!-- Upload image -->
    <div class="mb-3">
        <label class="form-label">Image (jpg/png/webp)</label>
        <input type="file" name="image_file" class="form-control" accept="image/*">
        <div class="form-text">Taille max conseillée : 2 Mo</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Prix (€)</label>
        <input type="number" step="0.01" name="price" class="form-control" value="0">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Capacité</label>
            <input type="number" name="capacity" class="form-control" value="50">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Places disponibles</label>
            <input type="number" name="available_spots" class="form-control" value="50">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Min participants</label>
            <input type="number" name="min_participants" class="form-control" value="1">
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">
            ✅ Enregistrer
        </button>

        <a href="?controller=event&action=index" class="btn btn-secondary">
            ↩ Retour
        </a>
    </div>

</form>