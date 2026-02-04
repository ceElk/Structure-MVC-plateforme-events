cat > /Applications/MAMP/htdocs/coursPhp2025/POO/plateforme-events/App/Views/page/contact.php << 'EOF'
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- En-tête -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3">Nous contacter</h1>
            <p class="lead text-muted">
                Une question ? Une suggestion ? N'hésitez pas à nous écrire !
            </p>
        </div>

        <!-- Formulaire de contact -->
        <div class="card border-0 shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Nom complet *
                            </label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   placeholder="Jean Dupont"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fas fa-envelope me-2"></i>Email *
                            </label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="jean.dupont@example.com"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tag me-2"></i>Sujet *
                            </label>
                            <input type="text" 
                                   name="subject" 
                                   class="form-control" 
                                   placeholder="Objet de votre message"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">
                                <i class="fas fa-comment me-2"></i>Message *
                            </label>
                            <textarea name="message" 
                                      class="form-control" 
                                      rows="6" 
                                      placeholder="Votre message..."
                                      required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-paper-plane me-2"></i> Envoyer le message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100 p-4">
                    <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Adresse</h5>
                    <p class="text-muted mb-0">
                        123 Rue de l'Innovation<br>
                        75001 Paris, France
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100 p-4">
                    <i class="fas fa-phone fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Téléphone</h5>
                    <p class="text-muted mb-0">
                        <a href="tel:+33123456789" class="text-decoration-none text-muted">
                            +33 1 23 45 67 89
                        </a>
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100 p-4">
                    <i class="fas fa-envelope fa-3x text-danger mb-3"></i>
                    <h5 class="fw-bold">Email</h5>
                    <p class="text-muted mb-0">
                        <a href="mailto:contact@eventhub.com" class="text-decoration-none text-muted">
                            contact@eventhub.com
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body text-center p-4">
                <h5 class="fw-bold mb-3">Suivez-nous</h5>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-outline-primary btn-lg">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-lg">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-danger btn-lg">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-lg">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
