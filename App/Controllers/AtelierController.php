<?php

namespace App\Controllers;

use App\Models\Event;
use App\Entities\EventEntity;

class AtelierController extends Controller
{
    public function index(): void
    {
        $model = new Event();
        
        $filters = [
            'type' => 'atelier',
            'category' => $_GET['category'] ?? null,
            'city' => $_GET['city'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
            'date_min' => $_GET['date_min'] ?? null,
            'date_max' => $_GET['date_max'] ?? null,
        ];
        
        $ateliers = $model->advancedSearch($filters);
        
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('atelier/index', [
            'title' => 'Tous les ateliers',
            'ateliers' => $ateliers,
            'categories' => $categories,
            'selectedCategory' => $filters['category'],
            'type' => 'atelier' // ✅ AJOUTÉ
        ]);
    }

    public function show(int $id): void
    {
        $model = new Event();
        $atelier = $model->getById($id);

        if (!$atelier || $atelier->getType() !== 'atelier') {
            $this->setFlash('error', 'Atelier introuvable.');
            $this->redirect('atelier', 'index');
        }

        $this->render('atelier/show', [
            'title' => $atelier->getTitle() ?? 'Atelier',
            'atelier' => $atelier
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $location = trim($_POST['location'] ?? '');

            $dateStart = !empty($_POST['date_start'])
                ? str_replace('T', ' ', $_POST['date_start']) . ':00'
                : null;

            $dateEnd = !empty($_POST['date_end'])
                ? str_replace('T', ' ', $_POST['date_end']) . ':00'
                : null;

            if ($title === '' || $location === '' || $dateStart === null) {
                $this->setFlash('error', 'Titre, lieu et date de début obligatoires.');
                $this->redirect('atelier', 'create');
            }

            $slug = strtolower(trim(preg_replace(
                '/[^A-Za-z0-9-]+/',
                '-',
                iconv('UTF-8', 'ASCII//TRANSLIT', $title)
            )));
            $slug = trim($slug, '-');

            $uploadedPath = $this->uploadImage('image_file');

            $atelier = new EventEntity();
            $atelier
                ->setTitle($title)
                ->setSlug($slug)
                ->setType('atelier')
                ->setDescription(trim($_POST['description'] ?? ''))
                ->setShortDescription(trim($_POST['short_description'] ?? ''))
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ->setDuration(null)
                ->setLocation($location)
                ->setLocationCity(trim($_POST['location_city'] ?? ''))
                ->setLocationPostalCode(trim($_POST['location_postal_code'] ?? ''))
                ->setIsOnline(isset($_POST['is_online']))
                ->setOnlineLink(trim($_POST['online_link'] ?? ''))
                ->setCapacity((int)($_POST['capacity'] ?? 20))
                ->setAvailableSpots((int)($_POST['available_spots'] ?? 20))
                ->setMinParticipants((int)($_POST['min_participants'] ?? 1))
                ->setPrice((float) str_replace(',', '.', $_POST['price'] ?? 0))
                ->setCurrency('EUR')
                ->setImage($uploadedPath)
                ->setCategoryId(!empty($_POST['category_id']) ? (int)$_POST['category_id'] : null)
                ->setOrganizerId($_SESSION['user_id'] ?? 1)
                ->setStatus('published')
                ->setIsFeatured(0);

            $model = new Event();
            $idInserted = $model->insert($atelier);

            if ($idInserted) {
                $this->setFlash('success', 'Atelier créé ✅');
                $this->redirect('atelier', 'index');
            }

            $this->setFlash('error', 'Erreur lors de la création ❌');
            $this->redirect('atelier', 'create');
        }

        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('atelier/create', [
            'title' => 'Créer un atelier',
            'categories' => $categories
        ]);
    }

    public function edit(int $id): void
    {
        $this->requireAdmin();

        $model = new Event();
        $atelier = $model->getById($id);

        if (!$atelier || $atelier->getType() !== 'atelier') {
            $this->setFlash('error', 'Atelier introuvable.');
            $this->redirect('atelier', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $location = trim($_POST['location'] ?? '');

            if ($title === '') {
                $this->setFlash('error', 'Le titre est obligatoire.');
                $this->redirect('atelier', 'edit', ['id' => $id]);
            }

            if ($location === '') {
                $this->setFlash('error', 'Le lieu/adresse est obligatoire.');
                $this->redirect('atelier', 'edit', ['id' => $id]);
            }

            $slug = strtolower(trim(preg_replace(
                '/[^A-Za-z0-9-]+/',
                '-',
                iconv('UTF-8', 'ASCII//TRANSLIT', $title)
            )));
            $slug = trim($slug, '-');

            $dateStart = !empty($_POST['date_start'])
                ? str_replace('T', ' ', $_POST['date_start']) . ':00'
                : null;

            $dateEnd = !empty($_POST['date_end'])
                ? str_replace('T', ' ', $_POST['date_end']) . ':00'
                : null;

            if ($dateStart === null) {
                $this->setFlash('error', 'La date de début est obligatoire.');
                $this->redirect('atelier', 'edit', ['id' => $id]);
            }

            $uploadedPath = $this->uploadImage('image_file');
            if (!empty($uploadedPath)) {
                $atelier->setImage($uploadedPath);
            }

            $atelier
                ->setTitle($title)
                ->setSlug($slug)
                ->setType('atelier')
                ->setDescription(trim($_POST['description'] ?? ''))
                ->setShortDescription(trim($_POST['short_description'] ?? ''))
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ->setLocation($location)
                ->setLocationCity(trim($_POST['location_city'] ?? ''))
                ->setLocationPostalCode(trim($_POST['location_postal_code'] ?? ''))
                ->setCapacity((int)($_POST['capacity'] ?? 20))
                ->setAvailableSpots((int)($_POST['available_spots'] ?? 20))
                ->setMinParticipants((int)($_POST['min_participants'] ?? 1))
                ->setPrice((float) str_replace(',', '.', $_POST['price'] ?? 0))
                ->setCategoryId(!empty($_POST['category_id']) ? (int)$_POST['category_id'] : null);

            $ok = $model->update($atelier);

            if ($ok) {
                $this->setFlash('success', 'Atelier modifié ✅');
                $this->redirect('atelier', 'show', ['id' => $id]);
            }

            $this->setFlash('error', 'Erreur lors de la modification ❌');
            $this->redirect('atelier', 'edit', ['id' => $id]);
        }

        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('atelier/edit', [
            'title' => 'Modifier un atelier',
            'atelier' => $atelier,
            'categories' => $categories
        ]);
    }

    public function delete(int $id): void
    {
        $this->requireAdmin();

        $model = new Event();
        $atelier = $model->getById($id);

        if (!$atelier || $atelier->getType() !== 'atelier') {
            $this->setFlash('error', 'Atelier introuvable.');
            $this->redirect('atelier', 'index');
        }

        $ok = $model->delete($id);

        $this->setFlash($ok ? 'success' : 'error', $ok ? 'Atelier supprimé ✅' : 'Erreur lors de la suppression ❌');
        $this->redirect('atelier', 'index');
    }

    /**************** UPLOAD D'IMAGE SI LE CODE COMMENTER NE FONCTIONNE PAS !!!!!!!! */
    /*private function uploadImage(string $field = 'image_file'): ?string
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            $this->setFlash('error', "Erreur upload (code " . $_FILES[$field]['error'] . ")");
            return null;
        }

        $tmp = $_FILES[$field]['tmp_name'];
        $originalName = $_FILES[$field]['name'];

        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed, true)) {
            $this->setFlash('error', 'Format invalide (jpg/jpeg/png/webp uniquement).');
            return null;
        }

        if ($_FILES[$field]['size'] > 5 * 1024 * 1024) {
            $this->setFlash('error', 'Image trop lourde (max 5 Mo).');
            return null;
        }

        $uploadDir = __DIR__ . '/../../public/uploads/events/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            $this->setFlash('error', 'Le dossier upload n\'est pas accessible en écriture.');
            return null;
        }

        $fileName = uniqid('event_', true) . '.' . $ext;
        $dest = $uploadDir . $fileName;

        if (!move_uploaded_file($tmp, $dest)) {
            $this->setFlash('error', 'Échec de l\'upload.');
            return null;
        }

        return 'public/uploads/events/' . $fileName;
    }*/


/**************** UPLOAD D'IMAGE COMMENTÉ */
    // Fonction privée pour uploader une image
// $field = nom du champ input file dans ton formulaire
private function uploadImage(string $field = 'image_file'): ?string
{
    // Vérifie si un fichier est envoyé
    // OU si l'utilisateur n'a rien choisi
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null; // rien à uploader
    }

    // Vérifie s'il y a une erreur pendant l'upload
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        $this->setFlash('error', "Erreur upload (code " . $_FILES[$field]['error'] . ")");
        return null;
    }

    // Chemin temporaire du fichier sur le serveur
    $tmp = $_FILES[$field]['tmp_name'];

    // Nom original du fichier envoyé par l'utilisateur
    $originalName = $_FILES[$field]['name'];

    // Récupère l'extension du fichier (.jpg, .png...)
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    // Extensions autorisées
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    // Vérifie que l'extension est autorisée
    if (!in_array($ext, $allowed, true)) {
        $this->setFlash('error', 'Format invalide (jpg/jpeg/png/webp uniquement).');
        return null;
    }

    // Vérifie la taille max : 5 Mo
    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) {
        $this->setFlash('error', 'Image trop lourde (max 5 Mo).');
        return null;
    }

    // Dossier où stocker l'image
    $uploadDir = __DIR__ . '/../../public/uploads/events/';

    // Si le dossier n'existe pas → on le crée
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Vérifie que PHP peut écrire dans ce dossier
    if (!is_writable($uploadDir)) {
        $this->setFlash('error', 'Le dossier upload n\'est pas accessible en écriture.');
        return null;
    }

    // Génère un nom unique pour éviter collisions
    // exemple : event_65f4d3e45c2.jpg
    $fileName = uniqid('event_', true) . '.' . $ext;

    // Chemin final du fichier
    $dest = $uploadDir . $fileName;

    // Déplace le fichier temporaire vers le dossier final
    if (!move_uploaded_file($tmp, $dest)) {
        $this->setFlash('error', 'Échec de l\'upload.');
        return null;
    }

    // Retourne le chemin du fichier pour l'enregistrer en BDD
    return 'public/uploads/events/' . $fileName;
}

    /**
 * Récupère les détails d'un atelier en JSON (pour AJAX)
 */
public function showAjax(): void
{
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    
    if (!$id) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID manquant'
        ]);
        exit;
    }
    
    $model = new \App\Models\Event();
    $atelier = $model->getById($id);
    
    if (!$atelier || $atelier->getType() !== 'atelier') {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Atelier non trouvé'
        ]);
        exit;
    }
    
    // Vérifie si l'utilisateur peut réserver
    $canReserve = isset($_SESSION['user_id']) && !isset($_SESSION['admin']);
    
    // Prépare les données
    $data = [
        'id' => $atelier->getId(),
     'image' => $atelier->getImage() ? str_replace('public/', '', $atelier->getImage()) : null,
        'title' => $atelier->getTitle(),
        'description' => $atelier->getDescription(),
        'date_formatted' => $atelier->getFormattedDateStart('d/m/Y'),
       'time_start' => $atelier->getFormattedTimeStart() ?? 'Non spécifié',
        'location' => $atelier->getLocation(),
        'location_city' => $atelier->getLocationCity(),
        'price' => number_format($atelier->getPrice(), 2, ',', ' '),
        'capacity' => $atelier->getCapacity(),
        'available_spots' => $atelier->getAvailableSpots(),
        'image' => $atelier->getImage(),
        'category_name' => $atelier->getCategoryName(),
        'category_color' => $atelier->getCategoryColor(),
        'category_icon' => $atelier->getCategoryIcon(),
        'can_reserve' => $canReserve
    ];
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'data' => $data
    ]);
    exit;
}

/**
 * Récupère les données d'un atelier pour le formulaire d'édition (AJAX)
 */
public function editAjax(): void
{
    // ✅ Protection admin
        // Si pas admin, refuser l'accès
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Accès refusé'
        ]);
        exit;
    }

        // ========== 2. RÉCUPÉRER L'ID DE L'ATELIER ==========
    
    // L'ID arrive via l'URL : ?controller=atelier&action=editAjax&id=5
    $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
    
        // Si pas d'ID, erreur
    if (!$id) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID manquant'
        ]);
        exit;
    }
     // ========== 3. RÉCUPÉRER L'ATELIER EN BASE DE DONNÉES ==========
    
    $model = new \App\Models\Event();// Crée une instance du modèle
    $atelier = $model->getById($id); // SELECT * FROM events WHERE id = 5
    
     // Si l'atelier n'existe pas OU ce n'est pas un atelier (c'est un événement) => erreur 404
    if (!$atelier || $atelier->getType() !== 'atelier') {
        http_response_code(404); // Code HTTP "Not Found" (Pas trouvé)
        echo json_encode([
            'success' => false,
            'message' => 'Atelier non trouvé'
        ]);
        exit;
    }
    
 

    // ========== 4. PRÉPARER LES DONNÉES POUR LE JAVASCRIPT ==========
    
    // On crée un tableau associatif avec toutes les données nécessaires
       // Prépare les données pour le formulaire d'edition
    $data = [
        'id' => $atelier->getId(),
        'title' => $atelier->getTitle(),
        'description' => $atelier->getDescription(),
        'date_start' => $atelier->getDateStart() ? date('Y-m-d', strtotime($atelier->getDateStart())) : '',
        'location' => $atelier->getLocation(),
        'location_city' => $atelier->getLocationCity(),
        'price' => $atelier->getPrice(),
        'capacity' => $atelier->getCapacity(),
        'available_spots' => $atelier->getAvailableSpots(),
        'image' => $atelier->getImage()
    ];
    
        // ========== 5. RENVOYER LES DONNÉES EN JSON ==========
    http_response_code(200); // Code HTTP "OK" (Tout va bien)
    echo json_encode([
        'success' => true,
        'data' => $data // JavaScript recevra ce tableau associatid dans la prorpiété data de l areponse 
    ]);
    exit;
}


/**
 * Met à jour un atelier via AJAX
 */
public function updateAjax(): void
{
        // ========== 1. PROTECTION ADMIN ==========
    // ✅ Protection admin
    if (!isset($_SESSION['admin'])) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Accès refusé'
        ]);
        exit;
    }

     // ========== 2. VÉRIFIER QUE C'EST BIEN UNE REQUÊTE POST ==========
    
    // Le formulaire envoie les données en POST (pas GET)
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405); // Code HTTP "Method Not Allowed"
        echo json_encode([
            'success' => false,
            'message' => 'Méthode non autorisée'
        ]);
        exit;
    }

        // ========== 3. RÉCUPÉRER L'ID ==========
    
    // Cette fois l'ID arrive via $_POST (dans le formulaire)
    // <input type="hidden" name="id" value="5">
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    
    if (!$id) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'ID manquant'
        ]);
        exit;
    }

       // ========== 4. VALIDATION DES CHAMPS OBLIGATOIRES ==========
    $errors = [];  // Tableau pour stocker les erreurs

       // Vérifie que le titre n'est pas vide
    if (empty($_POST['title'])) {
        $errors[] = "Le titre est obligatoire";
    }
    // Vérifie que la date n'est pas vide
    if (empty($_POST['date_start'])) {
        $errors[] = "La date est obligatoire";
    }

    // ===== GESTION DE L'IMAGE =====

    // ========== 5. RÉCUPÉRER L'ATELIER EXISTANT ==========
    $imageName = null;
    $model = new \App\Models\Event();
    $atelier = $model->getById($id);


    // Si l'atelier n'existe pas ou si ce n'est pas un atelier (peut etre un evenement => erreur 404)
    if (!$atelier) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Atelier non trouvé'
        ]);
        exit;
    }

      // ========== 6. GESTION DE L'IMAGE ==========
    
    // Par défaut, on garde l'ancienne image (l'affiche) 
    $imageName = $atelier->getImage();

    // Si NOUVELLE image uploadée
    if (!empty($_FILES['picture']['name'])) {
        
          // ✅ VALIDATION DU TYPE DE FICHIER
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['picture']['type'];
        
              // Vérifie que le type est dans la liste autorisée
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = "Type de fichier non autorisé";
        }
              
        // ✅ VALIDATION DE LA TAILLE (5 MB maximum)
        $maxSize = 5 * 1024 * 1024;
        $fileSize = $_FILES['picture']['size'];
        
        if ($fileSize > $maxSize) {
            $errors[] = "Fichier trop volumineux (max 5 MB)";
        }
              // Si pas  (vide) d'erreurs, on upload la nouvelle image
        if (empty($errors)) {
             // Génère un nom unique : timestamp + nom original
            // Ex: 1707065432_mon_image.jpg
            $imageName = time() . '_' . basename($_FILES['picture']['name']);
                  // Chemin complet où sauvegarder le fichier
            $destination = dirname(__DIR__, 2) . '/App/public/uploads/events/' . $imageName;
            
              // Déplace le fichier uploadé vers la destination
            if (!move_uploaded_file($_FILES['picture']['tmp_name'], $destination)) {
                $errors[] = "Erreur lors de l'upload";
            } else {
                     // Ajoute le chemin relatif complet pour la BDD
                $imageName = 'public/uploads/events/' . $imageName;
            }
        }
    }

     // ========== 7. SI ERREURS, RETOURNER JSON AVEC ERREURS ==========
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Erreurs de validation',
            'errors' => $errors
        ]);
        exit;
    }

    // ✅ MISE À JOUR EN BASE DE DONNÉES avec les setters
    try {
          // On utilise les setters de l'entité pour modifier les valeurs
        $atelier
            ->setTitle($_POST['title'])
            ->setDescription($_POST['description'] ?? '')
            ->setDateStart($_POST['date_start'])
            ->setLocation($_POST['location'] ?? '')
            ->setLocationCity($_POST['location_city'] ?? '')
            ->setPrice((float)($_POST['price'] ?? 0))
            ->setCapacity((int)($_POST['capacity'] ?? 20))
            ->setAvailableSpots((int)($_POST['available_spots'] ?? 20))
            ->setImage($imageName);

               // Appelle la méthode update() du modèle
        // Exécute : UPDATE events SET title=?, description=?, ... WHERE id=?
        $model->update($atelier);


        // ========== SUCCÈS ==========
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => 'Atelier modifié avec succès ! 🎉'
        ]);

    } catch (\Exception $e) {
           // ========== EN CAS D'ERREUR SQL OU AUTRE ==========
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de l\'enregistrement',
            'errors' => [$e->getMessage()]
        ]);
    }

    exit;
}


}