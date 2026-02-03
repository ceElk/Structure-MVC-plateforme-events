<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
    </h1>
    <span class="badge bg-primary fs-5">Administrateur</span>
</div>

<!-- Statistiques -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-users fa-3x text-primary mb-3"></i>
                <h3 class="fw-bold"><?= (int)$totalUsers ?></h3>
                <p class="text-muted mb-0">Utilisateurs</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-shield-alt fa-3x text-success mb-3"></i>
                <h3 class="fw-bold"><?= (int)$totalAdmins ?></h3>
                <p class="text-muted mb-0">Administrateurs</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
                <h3 class="fw-bold"><?= (int)$totalEvents ?></h3>
                <p class="text-muted mb-0">Événements</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-tag fa-3x text-danger mb-3"></i>
                <h3 class="fw-bold"><?= (int)$totalCategories ?></h3>
                <p class="text-muted mb-0">Catégories</p>
            </div>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                <h5 class="fw-bold mb-3">Gérer les utilisateurs</h5>
                <p class="text-muted mb-4">Voir, modifier ou supprimer les utilisateurs</p>
                <a href="?controller=admin&action=users" class="btn btn-primary">
                    <i class="fas fa-arrow-right me-2"></i> Accéder
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-calendar-check fa-3x text-warning mb-3"></i>
                <h5 class="fw-bold mb-3">Gérer les événements</h5>
                <p class="text-muted mb-4">Créer, modifier ou supprimer des événements</p>
                <a href="?controller=event&action=index" class="btn btn-warning">
                    <i class="fas fa-arrow-right me-2"></i> Accéder
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <i class="fas fa-palette fa-3x text-success mb-3"></i>
                <h5 class="fw-bold mb-3">Gérer les ateliers</h5>
                <p class="text-muted mb-4">Créer, modifier ou supprimer des ateliers</p>
                <a href="?controller=atelier&action=index" class="btn btn-success">
                    <i class="fas fa-arrow-right me-2"></i> Accéder
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Derniers utilisateurs inscrits -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-user-plus me-2 text-primary"></i>
            Derniers utilisateurs inscrits
        </h5>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($recentUsers)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentUsers as $user): ?>
                            <?php /** @var \App\Entities\UserEntity $user */ ?>
                            <tr>
                                <td><?= (int)$user->getId() ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($user->getUsername()) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                                <td>
                                    <?php if ($user->getRoleName() === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">User</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($user->getFormattedCreatedAt('d/m/Y')) ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="?controller=admin&action=editUser&id=<?= (int)$user->getId() ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-4 text-center text-muted">
                <i class="fas fa-user-slash fa-3x mb-3"></i>
                <p class="mb-0">Aucun utilisateur inscrit récemment</p>
            </div>
        <?php endif; ?>
    </div>
</div>