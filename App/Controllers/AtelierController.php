<?php

namespace App\Controllers;

use App\Models\Event;
use App\Entities\EventEntity;

class AtelierController extends Controller
{
    public function index(): void
    {
        $model = new Event();
        
        // ✅ Récupère le paramètre category de l'URL
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        
        // ✅ Si une catégorie est spécifiée, filtre par catégorie
        if ($categoryId) {
            $ateliers = $model->getByTypeAndCategory('atelier', $categoryId);
        } else {
            // Sinon, affiche TOUS les ateliers
            $ateliers = $model->getAllByType('atelier');
        }
        
        // ✅ Charge les catégories pour le filtre
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();
    
        $this->render('atelier/index', [
            'title' => $categoryId ? 'Ateliers - Filtrés' : 'Tous les ateliers',
            'ateliers' => $ateliers,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }
    public function show(int $id): void
    {
        $model = new Event();
        $atelier = $model->getById($id);

        if (!$atelier || $atelier->getType() !== 'atelier') {
            $_SESSION['flash']['error'] = "Atelier introuvable.";
            header('Location: ?controller=atelier&action=index');
            exit;
        }

        $this->render('atelier/show', [
            'title' => $atelier->getTitle() ?? 'Atelier',
            'atelier' => $atelier
        ]);
    }

    public function create(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        
        // ✅ AJOUTE CE DEBUG ICI
        echo "<div style='background: red; padding: 20px; color: white; margin: 20px;'>";
        echo "<h2>🔍 DEBUG CREATE - POST REÇU</h2>";
        echo "<strong>\$_FILES :</strong><br>";
        echo "<pre>" . print_r($_FILES, true) . "</pre>";
        echo "<strong>\$_POST :</strong><br>";
        echo "<pre>" . print_r($_POST, true) . "</pre>";
        echo "</div>";

        $title = trim($_POST['title'] ?? '');
        $location = trim($_POST['location'] ?? '');

        $title = trim($_POST['title'] ?? '');
        $location = trim($_POST['location'] ?? '');

        $dateStart = !empty($_POST['date_start'])
            ? str_replace('T', ' ', $_POST['date_start']) . ':00'
            : null;

        $dateEnd = !empty($_POST['date_end'])
            ? str_replace('T', ' ', $_POST['date_end']) . ':00'
            : null;

        if ($title === '' || $location === '' || $dateStart === null) {
            $_SESSION['flash']['error'] = "Titre, lieu et date de début obligatoires.";
            header('Location: ?controller=atelier&action=create');
            exit;
        }

        // slug
        $slug = strtolower(trim(preg_replace(
            '/[^A-Za-z0-9-]+/',
            '-',
            iconv('UTF-8', 'ASCII//TRANSLIT', $title)
        )));
        $slug = trim($slug, '-');

        // upload (optionnel)
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
            $_SESSION['flash']['success'] = "Atelier créé ✅";
            header('Location: ?controller=atelier&action=index');
            exit;
        }

        $_SESSION['flash']['error'] = "Erreur lors de la création ❌";
        header('Location: ?controller=atelier&action=create');
        exit;
    }

    // ✅ AJOUTÉ : Charge les catégories pour le formulaire
    $categoryModel = new \App\Models\Category();
    $categories = $categoryModel->getAllActive();

    $this->render('atelier/create', [
        'title' => 'Créer un atelier',
        'categories' => $categories  // ✅ AJOUTÉ
    ]);
}
public function edit(int $id): void
{
    $model = new Event();
    $atelier = $model->getById($id);

    if (!$atelier || $atelier->getType() !== 'atelier') {
        $_SESSION['flash']['error'] = "Atelier introuvable.";
        header('Location: ?controller=atelier&action=index');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $title = trim($_POST['title'] ?? '');
        $location = trim($_POST['location'] ?? '');

        if ($title === '') {
            $_SESSION['flash']['error'] = "Le titre est obligatoire.";
            header('Location: ?controller=atelier&action=edit&id=' . (int)$atelier->getId());
            exit;
        }

        if ($location === '') {
            $_SESSION['flash']['error'] = "Le lieu/adresse est obligatoire.";
            header('Location: ?controller=atelier&action=edit&id=' . (int)$atelier->getId());
            exit;
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
            $_SESSION['flash']['error'] = "La date de début est obligatoire.";
            header('Location: ?controller=atelier&action=edit&id=' . (int)$atelier->getId());
            exit;
        }

        // upload image (optionnel)
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
            $_SESSION['flash']['success'] = "Atelier modifié ✅";
            header('Location: ?controller=atelier&action=show&id=' . (int)$atelier->getId());
            exit;
        }

        $_SESSION['flash']['error'] = "Erreur lors de la modification ❌";
        header('Location: ?controller=atelier&action=edit&id=' . (int)$atelier->getId());
        exit;
    }

    // ✅ AJOUTE ICI : Charge les catégories pour le formulaire
    $categoryModel = new \App\Models\Category();
    $categories = $categoryModel->getAllActive();

    $this->render('atelier/edit', [
        'title' => 'Modifier un atelier',
        'atelier' => $atelier,
        'categories' => $categories  // ✅ AJOUTE cette ligne
    ]);
}
    public function delete(int $id): void
    {
        $model = new Event();
        $atelier = $model->getById($id);

        if (!$atelier || $atelier->getType() !== 'atelier') {
            $_SESSION['flash']['error'] = "Atelier introuvable.";
            header('Location: ?controller=atelier&action=index');
            exit;
        }

        $ok = $model->delete($id);

        $_SESSION['flash'][$ok ? 'success' : 'error'] = $ok
            ? "Atelier supprimé ✅"
            : "Erreur lors de la suppression ❌";

        header('Location: ?controller=atelier&action=index');
        exit;
    }
    
    /**
     * Redimensionne une image en gardant le ratio
     */
    private function resizeImage(string $source, string $destination, int $maxWidth, int $maxHeight): bool
    {
        // Détecte le type d'image
        $imageInfo = getimagesize($source);
        if (!$imageInfo) {
            return false;
        }
    
        [$width, $height, $type] = $imageInfo;
    
        // Crée l'image source selon le type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($source);
                break;
            case IMAGETYPE_WEBP:
                $src = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }
    
        // Calcule les nouvelles dimensions en gardant le ratio
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        
        // Si l'image est déjà plus petite, on ne la redimensionne pas
        if ($ratio >= 1) {
            $newWidth = $width;
            $newHeight = $height;
        } else {
            $newWidth = (int)($width * $ratio);
            $newHeight = (int)($height * $ratio);
        }
    
        // Crée la nouvelle image
        $dst = imagecreatetruecolor($newWidth, $newHeight);
    
        // Préserve la transparence pour PNG et WEBP
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_WEBP) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
            $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
            imagefill($dst, 0, 0, $transparent);
        }
    
        // Redimensionne
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
        // Sauvegarde selon le type
        $result = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $result = imagejpeg($dst, $destination, 85); // Qualité 85%
                break;
            case IMAGETYPE_PNG:
                $result = imagepng($dst, $destination, 8); // Compression 8
                break;
            case IMAGETYPE_WEBP:
                $result = imagewebp($dst, $destination, 85); // Qualité 85%
                break;
        }
    
        // Libère la mémoire
        imagedestroy($src);
        imagedestroy($dst);
    
        return $result;
    }
    // ============================================================
// Upload image
// ============================================================
/*private function uploadImage(string $field = 'image_file'): ?string
{
    if (!isset($_FILES[$field])) {
        return null;
    }

    if ($_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['flash']['error'] = "Erreur upload (code " . $_FILES[$field]['error'] . ")";
        return null;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $originalName = $_FILES[$field]['name'];

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed, true)) {
        $_SESSION['flash']['error'] = "Format invalide (jpg/jpeg/png/webp uniquement).";
        return null;
    }

    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) {
        $_SESSION['flash']['error'] = "Image trop lourde (max 5 Mo).";
        return null;
    }

    // ✅ CORRIGÉ : Upload dans /public/ (pas /App/public/)
    $uploadDir = __DIR__ . '/../../public/uploads/events/';
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!is_writable($uploadDir)) {
        $_SESSION['flash']['error'] = "Le dossier upload n'est pas accessible en écriture.";
        return null;
    }

    $fileName = uniqid('event_', true) . '.' . $ext;
    $dest = $uploadDir . $fileName;

    if (!move_uploaded_file($tmp, $dest)) {
        $_SESSION['flash']['error'] = "Échec de l'upload.";
        return null;
    }

    // ✅ CORRIGÉ : Chemin web sans le /App/
    return 'public/uploads/events/' . $fileName;
}*/


private function uploadImage(string $field = 'image_file'): ?string
{
    // ✅ DEBUG 1 : Vérifie $_FILES
    echo "<div style='background: yellow; padding: 20px; border: 5px solid red;'>";
    echo "<h3>🔍 DEBUG UPLOAD</h3>";
    echo "<strong>\$_FILES contient :</strong><br>";  // ✅ CORRIGÉ : échapper le $
    echo "<pre>" . print_r($_FILES, true) . "</pre>";
    echo "</div>";

    if (!isset($_FILES[$field])) {
        echo "<div style='background: orange; padding: 10px;'>❌ Pas de fichier uploadé</div>";
        return null;
    }

    if ($_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<div style='background: orange; padding: 10px;'>❌ UPLOAD_ERR_NO_FILE</div>";
        return null;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        echo "<div style='background: red; padding: 10px; color: white;'>❌ Erreur : " . $_FILES[$field]['error'] . "</div>";
        $_SESSION['flash']['error'] = "Erreur upload (code " . $_FILES[$field]['error'] . ")";
        return null;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $originalName = $_FILES[$field]['name'];
    
    echo "<div style='background: lime; padding: 10px;'>✅ Fichier détecté : $originalName</div>";

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $allowed, true)) {
        echo "<div style='background: red; padding: 10px;'>❌ Format invalide</div>";
        $_SESSION['flash']['error'] = "Format invalide (jpg/jpeg/png/webp uniquement).";
        return null;
    }

    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) {
        echo "<div style='background: red; padding: 10px;'>❌ Fichier trop lourd</div>";
        $_SESSION['flash']['error'] = "Image trop lourde (max 5 Mo).";
        return null;
    }

    // ✅ CORRIGÉ : Upload dans /public/ (pas /App/public/)
    $uploadDir = __DIR__ . '/../../public/uploads/events/';
    
    echo "<div style='background: cyan; padding: 10px;'>";
    echo "📁 Upload dir : $uploadDir<br>";
    echo "📂 Dir existe ? " . (is_dir($uploadDir) ? '✅ OUI' : '❌ NON') . "<br>";
    echo "✍️ Dir writable ? " . (is_writable($uploadDir) ? '✅ OUI' : '❌ NON') . "<br>";
    echo "</div>";
    
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        echo "<div style='background: yellow; padding: 10px;'>📁 Dossier créé</div>";
    }

    if (!is_writable($uploadDir)) {
        echo "<div style='background: red; padding: 10px;'>❌ Dossier non accessible en écriture</div>";
        $_SESSION['flash']['error'] = "Le dossier upload n'est pas accessible en écriture.";
        return null;
    }

    $fileName = uniqid('event_', true) . '.' . $ext;
    $dest = $uploadDir . $fileName;
    
    echo "<div style='background: magenta; padding: 10px; color: white;'>";
    echo "💾 Destination : $dest<br>";
    echo "</div>";

    if (!move_uploaded_file($tmp, $dest)) {
        echo "<div style='background: red; padding: 10px; color: white;'>❌ move_uploaded_file() a échoué</div>";
        $_SESSION['flash']['error'] = "Échec de l'upload.";
        return null;
    }
    
    echo "<div style='background: green; padding: 10px; color: white;'>✅ Fichier uploadé avec succès !</div>";

    // ✅ CORRIGÉ : Chemin web sans le /App/
    $webPath = 'public/uploads/events/' . $fileName;
    echo "<div style='background: blue; padding: 10px; color: white;'>🌐 Chemin web enregistré en BDD : $webPath</div>";
    
    return $webPath;
}









/*private function uploadImage(string $field = 'image_file'): ?string
{
    // ✅ DEBUG 1 : Vérifie $_FILES
    echo "<div style='background: yellow; padding: 20px; border: 5px solid red;'>";
    echo "<h3>🔍 DEBUG UPLOAD</h3>";
    echo "<strong>$_FILES contient :</strong><br>";
    echo "<pre>" . print_r($_FILES, true) . "</pre>";
    echo "</div>";

    if (!isset($_FILES[$field])) {
        echo "<div style='background: orange; padding: 10px;'>❌ Pas de fichier uploadé</div>";
        return null;
    }

    if ($_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<div style='background: orange; padding: 10px;'>❌ UPLOAD_ERR_NO_FILE</div>";
        return null;
    }

    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        echo "<div style='background: red; padding: 10px; color: white;'>❌ Erreur : " . $_FILES[$field]['error'] . "</div>";
        $_SESSION['flash']['error'] = "Erreur upload (code " . $_FILES[$field]['error'] . ")";
        return null;
    }

    $tmp = $_FILES[$field]['tmp_name'];
    $originalName = $_FILES[$field]['name'];
    
    echo "<div style='background: lime; padding: 10px;'>✅ Fichier détecté : $originalName</div>";

    // ... reste de ton code ...
}*/
}
