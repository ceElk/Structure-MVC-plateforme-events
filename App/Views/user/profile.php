<?php /** @var \App\Entities\UserEntity $user */ ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-user-circle me-2"></i> Mon profil
            </h1>
            <a href="?controller=user&action=editProfile" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Modifier
            </a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-info-circle me-2"></i> Informations personnelles
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Nom d'utilisateur :</strong><br>
                            <?= htmlspecialchars($user->getUsername()) ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Email :</strong><br>
                            <?= htmlspecialchars($user->getEmail()) ?>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Prénom :</strong><br>
                            <?= htmlspecialchars($user->getFirstName() ?? '-') ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Nom :</strong><br>
                            <?= htmlspecialchars($user->getLastName() ?? '-') ?>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Téléphone :</strong><br>
                            <?= htmlspecialchars($user->getPhone() ?? '-') ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Rôle :</strong><br>
                            <?php if ($user->isAdmin()): ?>
                                <span class="badge bg-danger">Administrateur</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Utilisateur</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Membre depuis :</strong><br>
                            <small class="text-muted">
                                <?= htmlspecialchars($user->getFormattedCreatedAt('d/m/Y')) ?>
                            </small>
                        </p>
                    </div>
                    <?php if ($user->getLastLogin()): ?>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Dernière connexion :</strong><br>
                                <small class="text-muted">
                                    <?= htmlspecialchars($user->getFormattedLastLogin('d/m/Y H:i')) ?>
                                </small>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-cog me-2"></i> Paramètres du compte
                </h5>

                <div class="d-grid gap-3">
                    <a href="?controller=user&action=changePassword" class="btn btn-outline-primary">
                        <i class="fas fa-key me-2"></i> Changer mon mot de passe
                    </a>

                    <a href="?controller=user&action=myReservations" class="btn btn-outline-secondary">
                        <i class="fas fa-calendar-check me-2"></i> Mes réservations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>