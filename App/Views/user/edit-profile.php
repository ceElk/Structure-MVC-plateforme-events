<?php /** @var \App\Entities\UserEntity $user */ ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-user-edit me-2"></i> Modifier mon profil
            </h1>
            <a href="?controller=user&action=profile" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" 
                                   name="first_name" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($user->getFirstName() ?? '') ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" 
                                   name="last_name" 
                                   class="form-control" 
                                   value="<?= htmlspecialchars($user->getLastName() ?? '') ?>">
                        </div>
                    </div>

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
                        <label class="form-label">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               class="form-control" 
                               value="<?= htmlspecialchars($user->getPhone() ?? '') ?>"
                               placeholder="06 12 34 56 78">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Enregistrer les modifications
                        </button>
                        <a href="?controller=user&action=profile" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>