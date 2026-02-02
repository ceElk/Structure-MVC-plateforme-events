<!-- Section Hero avec animation -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content-wrapper">
        <div class="hero-content">
            <h1 class="hero-title animate-fade-in">
                Découvrez des <span class="gradient-text">Ateliers</span> et <span class="gradient-text">Événements</span> uniques
            </h1>
            <p class="hero-subtitle animate-fade-in-delay">
                Réservez votre place pour des expériences inoubliables : art, cuisine, sport, culture et bien plus encore
            </p>
            <div class="hero-buttons animate-fade-in-delay-2">
                <a href="?controller=event&action=list" class="btn btn-hero btn-primary btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i> Voir tous les événements
                </a>
                <a href="?controller=auth&action=register" class="btn btn-hero btn-outline-white btn-lg">
                    <i class="fas fa-user-plus me-2"></i> S'inscrire gratuitement
                </a>
            </div>
            <div class="hero-stats animate-fade-in-delay-3">
                <div class="stat-item">
                    <strong class="stat-number"><?= (int)$totalEvents ?>+</strong>
                    <span class="stat-label">Événements</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <strong class="stat-number">2500+</strong>
                    <span class="stat-label">Participants</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <strong class="stat-number">4.8/5</strong>
                    <span class="stat-label">Satisfaction</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Catégories populaires -->
<section class="categories-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Explorez par catégorie</h2>
            <p class="section-subtitle">Trouvez l'activité qui vous correspond</p>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($categoryStats)): ?>
                <?php foreach ($categoryStats as $category): ?>
                    <div class="col-md-4">
                        <a href="?controller=event&action=list&category=<?= (int)$category->id ?>" class="category-card">
                            <div class="category-icon" style="background: <?= htmlspecialchars($category->color) ?>;">
                                <i class="<?= htmlspecialchars($category->icon) ?> fa-3x"></i>
                            </div>
                            <h3><?= htmlspecialchars($category->name) ?></h3>
                            <p><?= htmlspecialchars($category->description) ?></p>
                            <span class="category-count">
                                <?= (int)$category->event_count ?> <?= ((int)$category->event_count > 1) ? 'événements' : 'événement' ?>
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Aucune catégorie disponible pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Section Événements à venir -->
<section class="upcoming-events py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title">Prochains événements populaires</h2>
            <p class="section-subtitle">Ne manquez pas ces rendez-vous exceptionnels</p>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($featuredEvents)): ?>
                <?php foreach ($featuredEvents as $event): ?>
                    <?php
                    /** @var \App\Entities\EventEntity $event */

                    // ✅ Date formatée via Entity (aucun strtotime(null))
                    $dateFormatted = $event->getFormattedDateStart('d M Y') ?? 'Date à définir';

                    // ✅ Type via getter (plus de propriété private)
                    $iconClass = ($event->getType() === 'atelier') ? 'fa-palette' : 'fa-glass-cheers';

                    // Couleur de fond aléatoire pour l'image
                    $gradients = [
                        'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                        'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)',
                        'linear-gradient(135deg, #3498db 0%, #2980b9 100%)',
                        'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)',
                    ];
                    $randomGradient = $gradients[array_rand($gradients)];

                    // ✅ Description courte
                    $desc = $event->getShortDescription() ?? $event->getDescription() ?? '';
                    $desc = substr($desc, 0, 100);

                    // ✅ Places disponibles
                    $spots = (int)$event->getAvailableSpots();

                    // ✅ ID event
                    $eventId = (int)($event->getId() ?? 0);
                    ?>
                    
                    <div class="col-md-6 col-lg-4">
                        <div class="event-card">
                            <div class="event-image" style="background: <?= $randomGradient ?>; height: 200px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas <?= $iconClass ?> fa-4x text-white"></i>
                            </div>
                            
                            <div class="event-body">
                                <div class="event-category">
                                    <i class="fas fa-tag me-1"></i> <?= htmlspecialchars($event->getCategoryName() ?? 'Non catégorisé') ?>
                                </div>
                                
                                <h3 class="event-title"><?= htmlspecialchars($event->getTitle() ?? '') ?></h3>
                                
                                <p class="event-description">
                                    <?= htmlspecialchars($desc) ?>...
                                </p>
                                
                                <div class="event-meta">
                                    <div class="event-date">
                                        <i class="fas fa-calendar me-2"></i>
                                        <span><?= htmlspecialchars($dateFormatted) ?></span>
                                    </div>
                                    <div class="event-location">
                                        <i class="fas fa-map-marker-alt me-2"></i>
                                        <span><?= htmlspecialchars($event->getLocationCity() ?? 'À définir') ?></span>
                                    </div>
                                    <div class="event-price">
                                        <i class="fas fa-tag me-2"></i>
                                        <strong><?= htmlspecialchars($event->getFormattedPrice()) ?></strong>
                                    </div>
                                </div>
                                
                                <div class="event-footer">
                                    <div class="event-spots">
                                        <i class="fas fa-users me-2"></i>
                                        <span>
                                            <?= $spots ?> place<?= ($spots > 1) ? 's' : '' ?>
                                            restante<?= ($spots > 1) ? 's' : '' ?>
                                        </span>
                                    </div>
                                    <a href="?controller=event&action=detail&id=<?= $eventId ?>" class="btn btn-sm btn-primary">
                                        Réserver <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Aucun événement à venir pour le moment.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="?controller=event&action=list" class="btn btn-lg btn-primary">
                Voir tous les événements <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Section CTA finale -->
<section class="cta-section py-5">
    <div class="container">
        <div class="cta-card text-center">
            <h2 class="cta-title mb-3">Prêt à vivre de nouvelles expériences ?</h2>
            <p class="cta-subtitle mb-4">Rejoignez notre communauté et réservez votre prochain atelier ou événement</p>
            <div class="cta-buttons">
                <a href="?controller=auth&action=register" class="btn btn-white btn-lg me-3">
                    <i class="fas fa-user-plus me-2"></i> Créer un compte gratuit
                </a>
                <a href="?controller=event&action=list" class="btn btn-outline-white btn-lg">
                    <i class="fas fa-search me-2"></i> Explorer les événements
                </a>
            </div>
            <p class="cta-note mt-4">
                <i class="fas fa-check-circle me-2"></i> Aucune carte bancaire requise
                <i class="fas fa-check-circle mx-3"></i> Inscription en 2 minutes
            </p>
        </div>
    </div>
</section>
