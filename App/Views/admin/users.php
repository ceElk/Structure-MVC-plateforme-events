<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">
        <i class="fas fa-users me-2"></i> Gestion des utilisateurs
    </h1>
    <a href="?controller=admin&action=dashboard" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour au dashboard
    </a>
</div>

<?php if (!empty($users)): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Email</th>
                            <th>Nom complet</th>
                            <th>Rôle</th>
                            <th>Statut</th>
                            <th>Inscrit le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <?php /** @var \App\Entities\UserEntity $user */ ?>
                            <tr>
                                <td><?= (int)$user->getId() ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($user->getUsername()) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                                <td>
                                    <?= htmlspecialchars($user->getFullName()) ?>
                                </td>
                                <td>
                                    <?php if ($user->getRoleName() === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">User</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->getIsActive()): ?>
                                        <span class="badge bg-success">Actif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($user->getFormattedCreatedAt('d/m/Y')) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="?controller=admin&action=editUser&id=<?= (int)$user->getId() ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user->getId() !== $_SESSION['user_id']): ?>
                                            <a href="?controller=admin&action=deleteUser&id=<?= (int)$user->getId() ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Supprimer cet utilisateur ?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i>
        Aucun utilisateur trouvé.
    </div>
<?php endif; ?>