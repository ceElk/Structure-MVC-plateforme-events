<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                    <h2 class="fw-bold">Inscription</h2>
                    <p class="text-muted">Créez votre compte EventHub gratuitement</p>
                </div>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" 
                                   name="first_name" 
                                   class="form-control" 
                                   placeholder="Jean">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" 
                                   name="last_name" 
                                   class="form-control" 
                                   placeholder="Dupont">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nom d'utilisateur *</label>
                        <input type="text" 
                               name="username" 
                               class="form-control" 
                               placeholder="jeandupont"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="jean@email.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" 
                               name="phone" 
                               class="form-control" 
                               placeholder="06 12 34 56 78">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe * (min. 6 caractères)</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="••••••••"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirmer le mot de passe *</label>
                        <input type="password" 
                               name="password_confirm" 
                               class="form-control" 
                               placeholder="••••••••"
                               required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fas fa-user-plus me-2"></i> Créer mon compte
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-0">
                        Déjà un compte ?
                        <a href="?controller=auth&action=login" class="text-decoration-none fw-bold">
                            Se connecter
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>