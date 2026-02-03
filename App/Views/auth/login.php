<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                    <h2 class="fw-bold">Connexion</h2>
                    <p class="text-muted">Accédez à votre compte EventHub</p>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" 
                               name="email" 
                               class="form-control" 
                               placeholder="votre@email.com"
                               required 
                               autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mot de passe *</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="••••••••"
                               required>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="remember">
                            <label class="form-check-label" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i> Se connecter
                    </button>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-0">
                        Pas encore de compte ?
                        <a href="?controller=auth&action=register" class="text-decoration-none fw-bold">
                            S'inscrire gratuitement
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>