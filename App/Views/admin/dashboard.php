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

<!-- ========== SECTION UTILISATEURS AVEC RECHERCHE ========== -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <div class="row align-items-center g-3">
            <!-- Titre -->
            <div class="col-md-4">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-users me-2 text-primary"></i>
                    Utilisateurs
                </h5>
            </div>
            
            <!-- Barre de recherche -->
            <div class="col-md-8">
                <div class="row g-2">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0" 
                                   id="searchUsers" 
                                   placeholder="Rechercher par nom ou email..."
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterRole">
                            <option value="">Tous les rôles</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary w-100" id="resetSearch">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted" id="searchCount"></small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <!-- Spinner de chargement -->
        <div id="loadingSpinner" style="display:none;" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-3 text-muted">Recherche en cours...</p>
        </div>
        
        <!-- Conteneur des résultats -->
        <div id="usersTableContainer">
            <?php if (!empty($recentUsers)): ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="usersTable">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i> ID</th>
                                <th><i class="fas fa-user me-1"></i> Nom d'utilisateur</th>
                                <th><i class="fas fa-envelope me-1"></i> Email</th>
                                <th><i class="fas fa-shield-alt me-1"></i> Rôle</th>
                                <th><i class="fas fa-calendar me-1"></i> Inscription</th>
                                <th><i class="fas fa-cog me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            <?php foreach ($recentUsers as $user): ?>
                                <?php /** @var \App\Entities\UserEntity $user */ ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark"><?= (int)$user->getId() ?></span></td>
                                    <td>
                                        <strong><?= htmlspecialchars($user->getUsername()) ?></strong>
                                    </td>
                                    <td>
                                        <small class="text-muted"><?= htmlspecialchars($user->getEmail()) ?></small>
                                    </td>
                                    <td>
                                        <?php if ($user->getRoleName() === 'admin'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-crown me-1"></i> Admin
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-user me-1"></i> User
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            <?= htmlspecialchars($user->getFormattedCreatedAt('d/m/Y')) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <a href="?controller=admin&action=editUser&id=<?= (int)$user->getId() ?>" 
                                           class="btn btn-sm btn-outline-primary"
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-5 text-center text-muted">
                    <i class="fas fa-user-slash fa-4x mb-3 opacity-50"></i>
                    <p class="mb-0 fs-5">Aucun utilisateur inscrit récemment</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ✅ SCRIPT AJAX RECHERCHE -->
<script src="App/public/assets/js/admin-search-users.js"></script>