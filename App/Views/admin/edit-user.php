<?php /** @var \App\Entities\UserEntity $user */ ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">
        <i class="fas fa-user-edit me-2"></i> Modifier l'utilisateur
    </h1>
    <a href="?controller=admin&action=users" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nom d'utilisateur *</label>
                        <input type="text" 
                               name="username" 
                               class="form-control" 
                               value="<?= htmlspecialchars($user->getUsername() ?? '') ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               value="<?= htmlspecialchars($user->getEmail() ?? '') ?>"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Rôle *</label>
                        <select name="role_id" class="form-select" required>
                            <option value="1" <?= $user->getRoleId() === 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $user->getRoleId() === 2 ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Enregistrer
                        </button>
                        <a href="?controller=admin&action=users" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-info-circle me-2"></i> Informations
                </h5>
                <p class="mb-2">
                    <strong>ID :</strong> <?= (int)$user->getId() ?>
                </p>
                <p class="mb-2">
                    <strong>Inscrit le :</strong><br>
                    <small class="text-muted"><?= htmlspecialchars($user->getFormattedCreatedAt('d/m/Y H:i')) ?></small>
                </p>
                <?php if ($user->getLastLogin()): ?>
                    <p class="mb-2">
                        <strong>Dernière connexion :</strong><br>
                        <small class="text-muted"><?= htmlspecialchars($user->getFormattedLastLogin('d/m/Y H:i')) ?></small>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>