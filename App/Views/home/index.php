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
                <a href="?controller=event&action=index" class="btn btn-hero btn-primary btn-lg">
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
<style>
    /* ========================================
     HERO SECTION - Argenté/Doré luxueux
  ======================================== */
.hero-section {
  position: relative;
  min-height: 700px;
  background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%);
  color: #ffffff;
  overflow: hidden;
  display: flex;
  align-items: center;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(
      ellipse at top right,
      rgba(212, 175, 55, 0.15) 0%,
      transparent 50%
    ),
    radial-gradient(
      ellipse at bottom left,
      rgba(192, 192, 192, 0.1) 0%,
      transparent 50%
    );
  z-index: 1;
}

.hero-content-wrapper {
  position: relative;
  z-index: 2;
  width: 100%;
  padding: 100px 0;
}

.hero-content {
  max-width: 1000px;
  margin: 0 auto;
  text-align: center;
  padding: 0 30px;
}

.hero-title {
  font-size: 4.5rem;
  font-weight: 900;
  margin-bottom: 2rem;
  line-height: 1.1;
  color: #ffffff;
  text-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
  letter-spacing: -2px;
}

.gradient-text {
  background: linear-gradient(135deg, #c0c0c0 0%, #f4d03f 50%, #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  position: relative;
  display: inline-block;
  font-weight: 900;
}

.gradient-text::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(
    90deg,
    transparent 0%,
    #d4af37 50%,
    transparent 100%
  );
  border-radius: 2px;
}

.hero-subtitle {
  font-size: 1.5rem;
  margin-bottom: 3rem;
  opacity: 0.95;
  font-weight: 300;
  letter-spacing: 0.5px;
  color: #e0e0e0;
}

.hero-buttons {
  display: flex;
  gap: 2rem;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 5rem;
}

.btn-hero {
  padding: 18px 45px;
  font-size: 1.15rem;
  border-radius: 50px;
  font-weight: 800;
  transition: all 0.4s ease;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
  text-transform: uppercase;
  letter-spacing: 1.5px;
  position: relative;
  overflow: hidden;
}

.btn-hero::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn-hero:hover::before {
  width: 300px;
  height: 300px;
}

.btn-hero.btn-primary {
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  color: #1a1a1a;
  border: none;
}

.btn-hero.btn-primary:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 50px rgba(212, 175, 55, 0.6);
  background: linear-gradient(135deg, #f4d03f 0%, #d4af37 100%);
}

.btn-outline-white {
  border: 3px solid #c0c0c0;
  color: #ffffff;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
}

.btn-outline-white:hover {
  background: linear-gradient(135deg, #c0c0c0 0%, #a8a8a8 100%);
  color: #1a1a1a;
  border-color: #ffffff;
  transform: translateY(-5px);
  box-shadow: 0 15px 50px rgba(192, 192, 192, 0.6);
}

.hero-stats {
  display: flex;
  gap: 4rem;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  padding: 2.5rem 3rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(30px);
  border-radius: 25px;
  border: 2px solid rgba(192, 192, 192, 0.2);
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 3.5rem;
  font-weight: 900;
  background: linear-gradient(135deg, #c0c0c0 0%, #f4d03f 50%, #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
  margin-bottom: 0.75rem;
}

.stat-label {
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  opacity: 0.9;
  color: #c0c0c0;
  font-weight: 600;
}

.stat-divider {
  width: 2px;
  height: 70px;
  background: linear-gradient(
    180deg,
    transparent 0%,
    rgba(212, 175, 55, 0.8) 50%,
    transparent 100%
  );
}
</style>

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
                        <a href="?controller=event&action=index&category=<?= (int)$category->id ?>" class="category-card">
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

                    // Date formatée via Entity
                    $dateFormatted = $event->getFormattedDateStart('d M Y') ?? 'Date à définir';

                    // Type via getter
                    $type = $event->getType();
                    $iconClass = ($type === 'atelier') ? 'fa-palette' : 'fa-glass-cheers';

                    // Couleur de fond aléatoire pour l'image
                     // ✅ NOUVEAUX GRADIENTS : Argenté, Doré, Bordeaux, Vert foncé, Bleu foncé, Noir
                     $gradients = [
                        'linear-gradient(135deg, #c0c0c0 0%, #808080 100%)', // Argenté
                        'linear-gradient(135deg, #d4af37 0%, #c9a227 100%)', // Doré
                        'linear-gradient(135deg, #8b1538 0%, #5d0e26 100%)', // Bordeaux
                        'linear-gradient(135deg, #2d5016 0%, #1a3009 100%)', // Vert foncé
                        'linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%)', // Bleu foncé
                        'linear-gradient(135deg, #1a1a1a 0%, #000000 100%)', // Noir
                    ];
                    $randomGradient = $gradients[array_rand($gradients)];

                    // Description courte
                    $desc = $event->getShortDescription() ?? $event->getDescription() ?? '';
                    $desc = substr($desc, 0, 100);

                    // Places disponibles
                    $spots = (int)$event->getAvailableSpots();

                    // ID event
                    $eventId = (int)($event->getId() ?? 0);
                    
                    // Contrôleur selon le type
                    $controller = ($type === 'atelier') ? 'atelier' : 'event';
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
                                    <a href="?controller=<?= $controller ?>&action=show&id=<?= $eventId ?>" class="btn btn-sm btn-primary">
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
            <a href="?controller=event&action=index" class="btn btn-lg btn-primary">
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
                <a href="?controller=event&action=index" class="btn btn-outline-white btn-lg">
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
<style>
    /* ========================================
   ANIMATIONS
======================================== */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes shimmer {
  0%, 100% {
    opacity: 0.7;
    transform: translateX(-100%);
  }
  50% {
    opacity: 1;
    transform: translateX(100%);
  }
}

.animate-fade-in {
  animation: fadeIn 1s ease-out;
}

.animate-fade-in-delay {
  animation: fadeIn 1s ease-out 0.3s both;
}

.animate-fade-in-delay-2 {
  animation: fadeIn 1s ease-out 0.6s both;
}

.animate-fade-in-delay-3 {
  animation: fadeIn 1s ease-out 0.9s both;
}

/* ========================================
   HERO SECTION - Argenté/Doré luxueux
======================================== */
.hero-section {
  position: relative;
  min-height: 700px;
  background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%);
  color: #ffffff;
  overflow: hidden;
  display: flex;
  align-items: center;
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: radial-gradient(ellipse at top right, 
    rgba(212, 175, 55, 0.15) 0%, 
    transparent 50%),
    radial-gradient(ellipse at bottom left, 
    rgba(192, 192, 192, 0.1) 0%, 
    transparent 50%);
  z-index: 1;
}

.hero-content-wrapper {
  position: relative;
  z-index: 2;
  width: 100%;
  padding: 100px 0;
}

.hero-content {
  max-width: 1000px;
  margin: 0 auto;
  text-align: center;
  padding: 0 30px;
}

.hero-title {
  font-size: 4.5rem;
  font-weight: 900;
  margin-bottom: 2rem;
  line-height: 1.1;
  color: #ffffff;
  text-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
  letter-spacing: -2px;
}

.gradient-text {
  background: linear-gradient(135deg, 
    #c0c0c0 0%, 
    #f4d03f 50%, 
    #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  position: relative;
  display: inline-block;
  font-weight: 900;
}

.gradient-text::after {
  content: '';
  position: absolute;
  bottom: -15px;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, 
    transparent 0%, 
    #d4af37 50%, 
    transparent 100%);
  border-radius: 2px;
}

.hero-subtitle {
  font-size: 1.5rem;
  margin-bottom: 3rem;
  opacity: 0.95;
  font-weight: 300;
  letter-spacing: 0.5px;
  color: #e0e0e0;
}

.hero-buttons {
  display: flex;
  gap: 2rem;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 5rem;
}

.btn-hero {
  padding: 18px 45px;
  font-size: 1.15rem;
  border-radius: 50px;
  font-weight: 800;
  transition: all 0.4s ease;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
  text-transform: uppercase;
  letter-spacing: 1.5px;
  position: relative;
  overflow: hidden;
}

.btn-hero::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn-hero:hover::before {
  width: 300px;
  height: 300px;
}

.btn-hero.btn-primary {
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  color: #1a1a1a;
  border: none;
}

.btn-hero.btn-primary:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 50px rgba(212, 175, 55, 0.6);
  background: linear-gradient(135deg, #f4d03f 0%, #d4af37 100%);
}

.btn-outline-white {
  border: 3px solid #c0c0c0;
  color: #ffffff;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
}

.btn-outline-white:hover {
  background: linear-gradient(135deg, #c0c0c0 0%, #a8a8a8 100%);
  color: #1a1a1a;
  border-color: #ffffff;
  transform: translateY(-5px);
  box-shadow: 0 15px 50px rgba(192, 192, 192, 0.6);
}

.hero-stats {
  display: flex;
  gap: 4rem;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  padding: 2.5rem 3rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(30px);
  border-radius: 25px;
  border: 2px solid rgba(192, 192, 192, 0.2);
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}

.stat-item {
  text-align: center;
}

.stat-number {
  display: block;
  font-size: 3.5rem;
  font-weight: 900;
  background: linear-gradient(135deg, #c0c0c0 0%, #f4d03f 50%, #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  line-height: 1;
  margin-bottom: 0.75rem;
}

.stat-label {
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  opacity: 0.9;
  color: #c0c0c0;
  font-weight: 600;
}

.stat-divider {
  width: 2px;
  height: 70px;
  background: linear-gradient(180deg, 
    transparent 0%, 
    rgba(212, 175, 55, 0.8) 50%, 
    transparent 100%);
}

/* ========================================
   SECTIONS - Style moderne
======================================== */
.categories-section,
.upcoming-events,
.cta-section {
  padding: 120px 0;
}

.section-header {
  margin-bottom: 5rem;
}

.section-title {
  font-size: 3.5rem;
  font-weight: 900;
  margin-bottom: 1.5rem;
  background: linear-gradient(135deg, 
    #1a1a1a 0%, 
    #2d2d2d 40%, 
    #d4af37 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  letter-spacing: -1px;
}

.section-subtitle {
  font-size: 1.4rem;
  color: #6c757d;
  font-weight: 300;
  letter-spacing: 0.5px;
}

/* ========================================
   CATEGORY CARDS - Argenté premium
======================================== */
.category-card {
  display: block;
  background: linear-gradient(135deg, #ffffff 0%, #f8f8f8 100%);
  border: 2px solid transparent;
  border-radius: 28px;
  padding: 3rem 2rem;
  text-align: center;
  transition: all 0.5s ease;
  text-decoration: none;
  color: inherit;
  height: 100%;
  position: relative;
  overflow: hidden;
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
}

.category-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 5px;
  background: linear-gradient(90deg, 
    transparent 0%, 
    #c0c0c0 25%, 
    #d4af37 50%, 
    #c0c0c0 75%, 
    transparent 100%);
  transition: left 0.8s ease;
}

.category-card:hover::before {
  left: 100%;
}

.category-card:hover {
  transform: translateY(-15px);
  border-color: #d4af37;
  box-shadow: 0 25px 70px rgba(212, 175, 55, 0.3);
  text-decoration: none;
}

.category-icon {
  width: 110px;
  height: 110px;
  margin: 0 auto 2rem;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
  transition: all 0.5s ease;
  position: relative;
}

.category-icon::after {
  content: '';
  position: absolute;
  inset: -5px;
  border-radius: 50%;
  background: linear-gradient(135deg, #c0c0c0 0%, #d4af37 100%);
  opacity: 0;
  z-index: -1;
  transition: opacity 0.5s ease;
}

.category-card:hover .category-icon {
  transform: scale(1.15) rotate(10deg);
  box-shadow: 0 15px 50px rgba(0, 0, 0, 0.35);
}

.category-card:hover .category-icon::after {
  opacity: 1;
}

.category-card h3 {
  font-size: 1.75rem;
  font-weight: 800;
  margin-bottom: 1.25rem;
  color: #1a1a1a;
  letter-spacing: -0.5px;
}

.category-card p {
  color: #6c757d;
  font-size: 1.05rem;
  margin-bottom: 2rem;
  line-height: 1.7;
}

.category-count {
  display: inline-block;
  padding: 10px 24px;
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  color: #1a1a1a;
  border-radius: 30px;
  font-weight: 800;
  font-size: 0.95rem;
  box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* ========================================
   MODERN EVENT CARDS - Design argenté/doré premium
======================================== */
.modern-event-card {
  background: #ffffff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  height: 100%;
  display: flex;
  flex-direction: column;
  position: relative;
  border: 2px solid transparent;
}

.modern-event-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, 
    #c0c0c0 0%, 
    #d4af37 50%, 
    #c0c0c0 100%);
  opacity: 0;
  transition: opacity 0.4s ease;
}

.modern-event-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 25px 60px rgba(212, 175, 55, 0.25);
  border-color: #d4af37;
}

.modern-event-card:hover::before {
  opacity: 1;
}

/* Image avec overlay */
.event-image-wrapper {
  position: relative;
  height: 280px !important;
  overflow: hidden !important;
  background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
}

.event-image {
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
  transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-event-card:hover .event-image {
  transform: scale(1.08);
}

.event-image-placeholder {
  width: 100% !important;
  height: 280px !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  color: rgba(255, 255, 255, 0.6);
}

/* Badges flottants */
.event-type-badge {
  position: absolute;
  top: 16px;
  left: 16px;
  padding: 8px 16px;
  border-radius: 50px;
  color: #ffffff;
  font-weight: 700;
  font-size: 0.85rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(10px);
  z-index: 2;
}

.event-price-badge {
  position: absolute;
  top: 16px;
  right: 16px;
  padding: 10px 20px;
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  color: #1a1a1a;
  border-radius: 50px;
  font-weight: 900;
  font-size: 1.1rem;
  box-shadow: 0 4px 20px rgba(212, 175, 55, 0.5);
  z-index: 2;
}

/* Contenu de la card */
.event-card-content {
  padding: 2rem;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.event-category-tag {
  display: inline-block;
  padding: 6px 14px;
  background: linear-gradient(135deg, 
    rgba(192, 192, 192, 0.15) 0%, 
    rgba(212, 175, 55, 0.15) 100%);
  color: #d4af37;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 1rem;
  align-self: flex-start;
  border: 1px solid rgba(212, 175, 55, 0.3);
}

.event-card-title {
  font-size: 1.5rem;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 1rem;
  line-height: 1.3;
  letter-spacing: -0.5px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.event-card-description {
  color: #6c757d;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

/* Métadonnées avec icônes */
.event-metadata {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  margin-bottom: 1.5rem;
  padding: 1.25rem;
  background: linear-gradient(135deg, 
    rgba(245, 245, 245, 0.5) 0%, 
    rgba(255, 255, 255, 0.5) 100%);
  border-radius: 12px;
  border-left: 4px solid #d4af37;
}

.metadata-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #2d2d2d;
  font-size: 0.9rem;
  font-weight: 500;
}

.metadata-item i {
  width: 20px;
  color: #d4af37;
  font-size: 1rem;
}

/* Bouton de réservation premium */
.btn-reserve {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  padding: 16px 28px;
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  color: #1a1a1a;
  border: none;
  border-radius: 50px;
  font-weight: 800;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-decoration: none;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
  position: relative;
  overflow: hidden;
}

.btn-reserve::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 0;
  height: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.3);
  transform: translate(-50%, -50%);
  transition: width 0.6s, height 0.6s;
}

.btn-reserve:hover::before {
  width: 300px;
  height: 300px;
}

.btn-reserve:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 35px rgba(212, 175, 55, 0.5);
  color: #000000;
  text-decoration: none;
}

.btn-reserve i {
  transition: transform 0.3s ease;
}

.btn-reserve:hover i {
  transform: translateX(5px);
}

/* ========================================
   CTA SECTION - Luxe argenté/doré
======================================== */
.cta-section {
  background: linear-gradient(135deg, #000000 0%, #1a1a1a 50%, #2d2d2d 100%);
  color: #ffffff;
  position: relative;
  overflow: hidden;
}

.cta-section::before {
  content: '';
  position: absolute;
  top: -50%;
  right: -10%;
  width: 600px;
  height: 600px;
  background: radial-gradient(circle, 
    rgba(212, 175, 55, 0.2) 0%, 
    transparent 70%);
  border-radius: 50%;
  animation: shimmer 8s infinite;
}

.cta-card {
  max-width: 1000px;
  margin: 0 auto;
  position: relative;
  z-index: 2;
  padding: 4rem 3rem;
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(30px);
  border-radius: 35px;
  border: 2px solid rgba(192, 192, 192, 0.3);
  box-shadow: 0 20px 70px rgba(0, 0, 0, 0.5);
}

.cta-title {
  font-size: 3.5rem;
  font-weight: 900;
  background: linear-gradient(135deg, 
    #c0c0c0 0%, 
    #f4d03f 50%, 
    #ffffff 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 1.5rem;
  letter-spacing: -1px;
}

.cta-subtitle {
  font-size: 1.4rem;
  opacity: 0.95;
  font-weight: 300;
  letter-spacing: 0.5px;
  margin-bottom: 3rem;
  color: #e0e0e0;
}

.cta-buttons {
  display: flex;
  gap: 2rem;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 3rem;
}

.btn-white {
  background: #ffffff;
  color: #1a1a1a;
  border: none;
  font-weight: 800;
  padding: 18px 45px;
  border-radius: 50px;
  transition: all 0.4s ease;
  box-shadow: 0 10px 40px rgba(255, 255, 255, 0.4);
  text-transform: uppercase;
  letter-spacing: 1.5px;
  font-size: 1.05rem;
}

.btn-white:hover {
  background: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
  transform: translateY(-5px);
  box-shadow: 0 15px 50px rgba(212, 175, 55, 0.6);
}

.cta-note {
  font-size: 1.1rem;
  opacity: 0.9;
  color: #c0c0c0;
  font-weight: 600;
}

/* ========================================
   RESPONSIVE
======================================== */
@media (max-width: 768px) {
  .hero-title {
    font-size: 2.75rem;
  }

  .hero-subtitle {
    font-size: 1.15rem;
  }

  .hero-stats {
    gap: 2rem;
    padding: 2rem;
  }

  .stat-number {
    font-size: 2.5rem;
  }

  .stat-divider {
    display: none;
  }

  .section-title {
    font-size: 2.25rem;
  }

  .hero-buttons,
  .cta-buttons {
    flex-direction: column;
    width: 100%;
  }

  .btn-hero {
    width: 100%;
  }

  .cta-title {
    font-size: 2.25rem;
  }

  .event-image-wrapper {
    height: 220px !important;
  }
  
  .event-card-content {
    padding: 1.5rem;
  }
  
  .event-card-title {
    font-size: 1.25rem;
  }
  
  .event-metadata {
    padding: 1rem;
  }
  
  .btn-reserve {
    padding: 14px 24px;
    font-size: 0.9rem;
  }
}


/* ========================================
   OLD EVENT CARDS (si tu utilises encore l'ancien code)
======================================== */
.event-card {
  background: #ffffff;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.event-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 45px rgba(212, 175, 55, 0.3);
}

.event-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  display: flex;
  align-items: center;
  justify-content: center;
}

.event-body {
  padding: 1.5rem;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.event-category {
  color: #d4af37;
  font-size: 0.85rem;
  font-weight: 700;
  text-transform: uppercase;
  margin-bottom: 0.75rem;
}

.event-title {
  font-size: 1.35rem;
  font-weight: 800;
  color: #1a1a1a;
  margin-bottom: 1rem;
  line-height: 1.3;
}

.event-description {
  color: #6c757d;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.event-meta {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 10px;
}

.event-date,
.event-location,
.event-price {
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  color: #2d2d2d;
}

.event-date i,
.event-location i,
.event-price i {
  color: #d4af37;
  margin-right: 0.5rem;
}

.event-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 1rem;
  border-top: 2px solid #f0f0f0;
}

.event-spots {
  display: flex;
  align-items: center;
  font-size: 0.9rem;
  font-weight: 600;
  color: #2d2d2d;
}

.event-spots i {
  color: #d4af37;
}
</style>