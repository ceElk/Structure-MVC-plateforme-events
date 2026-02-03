<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">
        <i class="fas fa-calendar-check me-2"></i> Mes réservations
    </h1>
    <a href="?controller=user&action=profile" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour au profil
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-5 text-center">
        <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
        <h3 class="fw-bold mb-3">Système de réservation en cours de développement</h3>
        <p class="text-muted mb-4">
            Cette fonctionnalité sera bientôt disponible ! Vous pourrez bientôt réserver des ateliers et événements directement depuis votre compte.
        </p>
        
        <div class="alert alert-info d-inline-block">
            <i class="fas fa-info-circle me-2"></i>
            Fonctionnalités à venir :
            <ul class="text-start mt-3 mb-0">
                <li>Réserver des événements et ateliers</li>
                <li>Consulter l'historique de vos réservations</li>
                <li>Annuler ou modifier vos réservations</li>
                <li>Recevoir des confirmations par email</li>
            </ul>
        </div>

        <div class="mt-4">
            <a href="?controller=event&action=index" class="btn btn-primary me-2">
                <i class="fas fa-calendar-alt me-2"></i> Voir les événements
            </a>
            <a href="?controller=atelier&action=index" class="btn btn-warning">
                <i class="fas fa-palette me-2"></i> Voir les ateliers
            </a>
        </div>
    </div>
</div>

<!-- Aperçu des prochains événements -->
<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-star me-2 text-warning"></i>
            En attendant, découvrez nos prochains événements
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 border rounded">
                    <i class="fas fa-calendar-alt fa-2x text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-bold">Événements</h6>
                        <small class="text-muted">Concerts, festivals, conférences...</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center p-3 border rounded">
                    <i class="fas fa-palette fa-2x text-warning me-3"></i>
                    <div>
                        <h6 class="mb-1 fw-bold">Ateliers</h6>
                        <small class="text-muted">Cours, formations, activités créatives...</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>