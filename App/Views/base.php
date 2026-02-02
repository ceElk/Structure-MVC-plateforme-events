<?php
/**
 * Layout principal - Plateforme Ateliers & Événements
 */

// ✅ BASE_URL fiable : toujours le dossier public (App/public)
if (!isset($BASE_URL)) {
    // ex: /coursPhp2025/POO/plateforme-events/App/public/index.php
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $BASE_URL = str_replace('/index.php', '', $script);
    $BASE_URL = rtrim($BASE_URL, '/');
}

$isLogged = isset($_SESSION['user_id']);
$isAdmin  = ($isLogged && ($_SESSION['role'] ?? '') === 'admin');

$displayName = "Visiteur";
if ($isLogged) {
    $displayName = $_SESSION['username'] ?? $_SESSION['email'] ?? "Utilisateur";
}

$currentController = $_GET['controller'] ?? 'home';
$currentAction     = $_GET['action'] ?? 'index';

function isActive(string $controller, string $action = 'index'): string {
    $currentController = $_GET['controller'] ?? 'home';
    $currentAction     = $_GET['action'] ?? 'index';
    return ($currentController === $controller && $currentAction === $action) ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'EventHub - Ateliers & Événements' ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS projet -->
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/home.css">
</head>

<body class="d-flex flex-column min-vh-100">

<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
     style="background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%) !important;
            border-bottom: 3px solid #d4af37 !important;">

    <!-- ✅ container manquant ajouté -->
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="<?= $BASE_URL ?>?controller=home&action=index">
            <i class="fas fa-star me-2"></i>
            <span>EventHub</span>
        </a>

        <!-- Burger -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu principal -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <!-- ========== VISITEUR NON CONNECTÉ ========== -->
                <?php if (!$isLogged): ?>

                    <li class="nav-item">
                        <a class="nav-link <?= isActive('home', 'index') ?>"
                           href="<?= $BASE_URL ?>?controller=home&action=index">
                            <i class="fas fa-home me-1"></i>Accueil
                        </a>
                    </li>

                    <!-- Dropdown Ateliers -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'atelier') ? 'active' : '' ?>"
                           href="#"
                           id="ateliersDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-palette me-1"></i>Ateliers
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="ateliersDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les ateliers
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=1">
                                    <i class="fas fa-palette me-2"></i>Arts & Créativité
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=4">
                                    <i class="fas fa-utensils me-2"></i>Cuisine
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=3">
                                    <i class="fas fa-running me-2"></i>Sport
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Dropdown Événements -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'event') ? 'active' : '' ?>"
                           href="#"
                           id="evenementsDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-glass-cheers me-1"></i>Événements
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="evenementsDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=home&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les événements (bientôt)
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=home&action=index">
                                    <i class="fas fa-book-open me-2"></i>Culture
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=home&action=index">
                                    <i class="fas fa-laptop-code me-2"></i>Tech
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= isActive('auth', 'login') ?>"
                           href="<?= $BASE_URL ?>?controller=auth&action=login">
                            <i class="fas fa-sign-in-alt me-1"></i>Connexion
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2 px-3 <?= isActive('auth', 'register') ?>"
                           href="<?= $BASE_URL ?>?controller=auth&action=register">
                            <i class="fas fa-user-plus me-1"></i>Inscription
                        </a>
                    </li>

                <!-- ========== UTILISATEUR CONNECTÉ ========== -->
                <?php else: ?>

                    <!-- Dropdown Ateliers -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'atelier') ? 'active' : '' ?>"
                           href="#"
                           id="ateliersDropdownConnected"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-palette me-1"></i>Ateliers
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="ateliersDropdownConnected">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les ateliers
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=1">
                                    <i class="fas fa-palette me-2"></i>Arts & Créativité
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=4">
                                    <i class="fas fa-utensils me-2"></i>Cuisine
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=3">
                                    <i class="fas fa-running me-2"></i>Sport
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Dropdown Événements -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'event') ? 'active' : '' ?>"
                           href="#"
                           id="evenementsDropdownConnected"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-glass-cheers me-1"></i>Événements
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="evenementsDropdownConnected">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=home&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les événements (bientôt)
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Mes réservations -->
                    <?php if (!$isAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= isActive('reservation', 'myReservations') ?>"
                               href="<?= $BASE_URL ?>?controller=reservation&action=myReservations">
                                <i class="fas fa-ticket-alt me-1"></i>
                                Mes Réservations
                                <?php if (!empty($_SESSION['reservation_count'])): ?>
                                    <span class="badge bg-warning text-dark ms-1">
                                        <?= (int)$_SESSION['reservation_count'] ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Menu Admin -->
                    <?php if ($isAdmin): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               id="adminDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fas fa-shield-alt me-1"></i>Administration
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=admin&action=dashboard">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=admin&action=events">
                                        <i class="fas fa-calendar-check me-2"></i>Gérer Ateliers & Événements
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=admin&action=categories">
                                        <i class="fas fa-tags me-2"></i>Gérer Catégories
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=admin&action=reservations">
                                        <i class="fas fa-clipboard-list me-2"></i>Toutes les Réservations
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- User -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="userDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <?= htmlspecialchars($displayName) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item"
                                   href="<?= $BASE_URL ?>?controller=user&action=profile">
                                    <i class="fas fa-id-card me-2"></i>Mon Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger"
                                   href="<?= $BASE_URL ?>?controller=auth&action=logout">
                                    <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php endif; ?>
            </ul>
        </div>

    </div>
</nav>

<!-- ========== FLASH ========== -->
<?php if (isset($_SESSION['flash'])): ?>
    <div class="container mt-3">
        <?php foreach ($_SESSION['flash'] as $type => $message): ?>
            <?php
            $bootstrapType = match($type) {
                'error' => 'danger',
                'success' => 'success',
                'warning' => 'warning',
                'info' => 'info',
                default => 'secondary'
            };

            $icon = match($type) {
                'error' => 'exclamation-circle',
                'success' => 'check-circle',
                'warning' => 'exclamation-triangle',
                'info' => 'info-circle',
                default => 'bell'
            };
            ?>
            <div class="alert alert-<?= $bootstrapType ?> alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-<?= $icon ?> me-2"></i>
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<!-- ========== CONTENT ========== -->
<main class="flex-grow-1 py-4">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="mb-2">
                    <i class="fas fa-star me-2"></i>EventHub
                </h5>
                <p class="text-muted small mb-0">
                    Plateforme de gestion d'ateliers et d'événements
                </p>
            </div>

            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?= $BASE_URL ?>?controller=home&action=about" class="text-muted text-decoration-none small">
                        <i class="fas fa-info-circle me-1"></i>À propos
                    </a>
                    <a href="<?= $BASE_URL ?>?controller=home&action=contact" class="text-muted text-decoration-none small">
                        <i class="fas fa-envelope me-1"></i>Contact
                    </a>
                    <?php if (!$isLogged): ?>
                        <a href="<?= $BASE_URL ?>?controller=auth&action=register" class="text-warning text-decoration-none small">
                            <i class="fas fa-user-plus me-1"></i>S'inscrire
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-4 text-md-end">
                <p class="mb-1">&copy; <?= date('Y') ?> EventHub</p>
                <small class="text-muted">Développé avec 💜 par Cécilia</small>
            </div>

        </div>
    </div>
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
