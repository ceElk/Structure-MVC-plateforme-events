<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-key me-2"></i> Changer mon mot de passe
            </h1>
            <a href="?controller=user&action=profile" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    Votre nouveau mot de passe doit contenir au moins 6 caractères.
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Mot de passe actuel *</label>
                        <input type="password" 
                               name="current_password" 
                               class="form-control" 
                               placeholder="••••••••"
                               required>
                        <small class="form-text text-muted">
                            Entrez votre mot de passe actuel pour confirmer
                        </small>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe *</label>
                        <input type="password" 
                               name="new_password" 
                               class="form-control" 
                               placeholder="••••••••"
                               minlength="6"
                               required>
                        <small class="form-text text-muted">
                            Minimum 6 caractères
                        </small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirmer le nouveau mot de passe *</label>
                        <input type="password" 
                               name="confirm_password" 
                               class="form-control" 
                               placeholder="••••••••"
                               minlength="6"
                               required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-lock me-2"></i> Modifier le mot de passe
                        </button>
                        <a href="?controller=user&action=profile" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-shield-alt me-2 text-success"></i>
                    Conseils de sécurité
                </h6>
                <ul class="small text-muted mb-0">
                    <li>Utilisez un mot de passe unique et complexe</li>
                    <li>Ne partagez jamais votre mot de passe</li>
                    <li>Changez votre mot de passe régulièrement</li>
                    <li>Utilisez un mélange de lettres, chiffres et symboles</li>
                </ul>
            </div>
        </div>
    </div>
</div>