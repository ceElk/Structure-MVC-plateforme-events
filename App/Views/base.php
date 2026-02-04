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

// ✅ Charger les catégories pour le menu dynamique 
$categoryModel = new \App\Models\Category();
$menuCategories = $categoryModel->getAllActive();

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
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= $BASE_URL ?>/assets/css/home.css?v=<?= time() ?>">
</head>

<body class="d-flex flex-column min-vh-100">

<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
     style="background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%) !important;
            border-bottom: 3px solid #d4af37 !important;">

    <div class="container-fluid px-4">

        <!-- Logo -->
        <a class="navbar-brand fw-bold d-flex align-items-center" 
           href="<?= $BASE_URL ?>?controller=home&action=index"
           style="font-size: 1.5rem; color: #d4af37;">
            <i class="fas fa-calendar-star me-2" style="font-size: 1.8rem;"></i>
            <span>EventHub</span>
        </a>

        <!-- ✅ BARRE DE RECHERCHE GLOBALE -->
        <form class="d-none d-lg-flex mx-auto" 
              style="max-width: 500px; width: 100%;" 
              action="<?= $BASE_URL ?>" 
              method="GET">
            <input type="hidden" name="controller" value="search">
            <input type="hidden" name="action" value="index">
            <div class="input-group">
                <input type="text" 
                       name="q" 
                       class="form-control" 
                       placeholder="Rechercher un événement, atelier, ville..."
                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                       style="border-radius: 50px 0 0 50px; padding: 0.6rem 1.2rem;">
                <button class="btn" 
                        type="submit"
                        style="background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%); 
                               color: #1a1a1a; 
                               border-radius: 0 50px 50px 0; 
                               font-weight: bold;
                               padding: 0.6rem 1.5rem;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

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
            <!-- ✅ BARRE DE RECHERCHE MOBILE -->
            <form class="d-lg-none my-3" 
                  action="<?= $BASE_URL ?>" 
                  method="GET">
                <input type="hidden" name="controller" value="search">
                <input type="hidden" name="action" value="index">
                <div class="input-group">
                    <input type="text" 
                           name="q" 
                           class="form-control" 
                           placeholder="Rechercher..."
                           value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav ms-auto">

                <!-- ========== VISITEUR NON CONNECTÉ ========== -->
                <?php if (!$isLogged): ?>

                    <li class="nav-item">
                        <a class="nav-link <?= isActive('home', 'index') ?>"
                           href="<?= $BASE_URL ?>?controller=home&action=index">
                            <i class="fas fa-home me-1"></i>Accueil
                        </a>
                    </li>

                    <!-- Dropdown Ateliers - DYNAMIQUE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'atelier') ? 'active' : '' ?>"
                           href="<?= $BASE_URL ?>?controller=atelier&action=index"
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
                            <?php if (!empty($menuCategories)): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($menuCategories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=<?= (int)$cat->id ?>">
                                            <i class="<?= htmlspecialchars($cat->icon ?? 'fas fa-tag') ?> me-2"></i>
                                            <?= htmlspecialchars($cat->name) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- Dropdown Événements - DYNAMIQUE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'event') ? 'active' : '' ?>"
                           href="<?= $BASE_URL ?>?controller=event&action=index"
                           id="evenementsDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-glass-cheers me-1"></i>Événements
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="evenementsDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=event&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les événements
                                </a>
                            </li>
                            <?php if (!empty($menuCategories)): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($menuCategories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=event&action=index&category=<?= (int)$cat->id ?>">
                                            <i class="<?= htmlspecialchars($cat->icon ?? 'fas fa-tag') ?> me-2"></i>
                                            <?= htmlspecialchars($cat->name) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
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

                    <!-- Dropdown Ateliers - DYNAMIQUE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'atelier') ? 'active' : '' ?>"
                           href="<?= $BASE_URL ?>?controller=atelier&action=index"
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
                            <?php if (!empty($menuCategories)): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($menuCategories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=atelier&action=index&category=<?= (int)$cat->id ?>">
                                            <i class="<?= htmlspecialchars($cat->icon ?? 'fas fa-tag') ?> me-2"></i>
                                            <?= htmlspecialchars($cat->name) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <!-- Dropdown Événements - DYNAMIQUE -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= ($currentController === 'event') ? 'active' : '' ?>"
                           href="<?= $BASE_URL ?>?controller=event&action=index"
                           id="evenementsDropdownConnected"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-glass-cheers me-1"></i>Événements
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="evenementsDropdownConnected">
                            <li>
                                <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=event&action=index">
                                    <i class="fas fa-list me-2"></i>Tous les événements
                                </a>
                            </li>
                            <?php if (!empty($menuCategories)): ?>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($menuCategories as $cat): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= $BASE_URL ?>?controller=event&action=index&category=<?= (int)$cat->id ?>">
                                            <i class="<?= htmlspecialchars($cat->icon ?? 'fas fa-tag') ?> me-2"></i>
                                            <?= htmlspecialchars($cat->name) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
                               href="<?= $BASE_URL ?>?controller=admin&action=dashboard"
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
                                       href="<?= $BASE_URL ?>?controller=admin&action=users">
                                        <i class="fas fa-users me-2"></i>Gérer Utilisateurs
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=event&action=index">
                                        <i class="fas fa-calendar-check me-2"></i>Gérer Événements
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                       href="<?= $BASE_URL ?>?controller=atelier&action=index">
                                        <i class="fas fa-palette me-2"></i>Gérer Ateliers
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- User -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="<?= $BASE_URL ?>?controller=user&action=profile"
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

<!-- ========== CONTENU ========== -->
<main class="flex-grow-1">
    <div class="container my-4">
        
        <!-- ✅ MESSAGES FLASH -->
        <?php if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <!-- ✅ CONTENU DE LA PAGE -->
        <?= $content ?>
        
    </div>
</main>

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white py-5 mt-auto">
    <div class="container">
        <div class="row g-4">
            <!-- À propos -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">
                    <i class="fas fa-calendar-star me-2" style="color: #d4af37;"></i>
                    EventHub
                </h5>
                <p class="text-muted">
                    Votre plateforme de découverte et de réservation d'événements et d'ateliers.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
<!-- Liens rapides -->
<div class="col-md-4">
    <h5 class="fw-bold mb-3">Liens rapides</h5>
    <ul class="list-unstyled">
        <li class="mb-2">
            <a href="?controller=event&action=index" class="text-decoration-none" style="color: #b8b8b8;">
                <i class="fas fa-chevron-right me-2"></i>Événements
            </a>
        </li>
        <li class="mb-2">
            <a href="?controller=atelier&action=index" class="text-decoration-none" style="color: #b8b8b8;">
                <i class="fas fa-chevron-right me-2"></i>Ateliers
            </a>
        </li>
        <li class="mb-2">
            <a href="?controller=page&action=about" class="text-decoration-none" style="color: #b8b8b8;">
                <i class="fas fa-chevron-right me-2"></i>À propos
            </a>
        </li>
        <li class="mb-2">
            <a href="?controller=page&action=contact" class="text-decoration-none" style="color: #b8b8b8;">
                <i class="fas fa-chevron-right me-2"></i>Contact
            </a>
        </li>
    </ul>
</div>

            <!-- Newsletter -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Newsletter</h5>
                <p class="text-muted">
                    Restez informé des nouveaux événements !
                </p>
                <form id="newsletterForm">
                    <div class="input-group mb-3">
                        <input type="email" 
                               class="form-control" 
                               placeholder="Votre email"
                               id="newsletterEmail"
                               required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
                <div id="newsletterMessage"></div>
            </div>
        </div>

        <hr class="my-4 border-secondary">

        <div class="text-center">
            <p class="mb-0 text-muted">
                &copy; <?= date('Y') ?> EventHub - Tous droits réservés
            </p>
        </div>
    </div>
</footer>

<!-- Script Newsletter -->
<script>
document.getElementById('newsletterForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('newsletterEmail').value;
    const messageDiv = document.getElementById('newsletterMessage');
    
    // Simulation d'envoi
    messageDiv.innerHTML = '<div class="alert alert-success alert-sm mt-2">✅ Merci ! Vous êtes inscrit à notre newsletter.</div>';
    document.getElementById('newsletterEmail').value = '';
    
    setTimeout(() => {
        messageDiv.innerHTML = '';
    }, 5000);
});
</script>

<!-- ✅ Bootstrap JS (OBLIGATOIRE pour les dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    /* ✅ Fix footer qui se fait écraser */
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1 0 auto;
}

footer {
    flex-shrink: 0;
    z-index: 1;
}

/* ✅ S'assurer que les liens du footer sont cliquables */
footer a {
    position: relative;
    z-index: 10;
}
</style>
</body>
</html>
