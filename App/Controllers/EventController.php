<?php

namespace App\Controllers;

use App\Models\Event;
use App\Entities\EventEntity;

class EventController extends Controller
{
    public function index(): void
    {
        $model = new Event();
        
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        
        if ($categoryId) {
            $evenements = $model->getByTypeAndCategory('evenement', $categoryId);
        } else {
            $evenements = $model->getAllByType('evenement');
        }
        
        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('event/index', [
            'title' => $categoryId ? 'Événements - Filtrés' : 'Tous les événements',
            'evenements' => $evenements,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }

    public function show(int $id): void
    {
        $model = new Event();
        $evenement = $model->getById($id);

        if (!$evenement || $evenement->getType() !== 'evenement') {
            $this->setFlash('error', 'Événement introuvable.');
            $this->redirect('event', 'index');
        }

        $model->incrementViews($id);

        $this->render('event/show', [
            'title' => $evenement->getTitle() ?? 'Événement',
            'evenement' => $evenement
        ]);
    }

    public function create(): void
    {
        // 🔒 PROTECTION ADMIN
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
                $this->redirect('event', 'create');
            }

            $slug = strtolower(trim(preg_replace(
                '/[^A-Za-z0-9-]+/',
                '-',
                iconv('UTF-8', 'ASCII//TRANSLIT', $title)
            )));
            $slug = trim($slug, '-');

            $uploadedPath = $this->uploadImage('image_file');

            $evenement = new EventEntity();
            $evenement
                ->setTitle($title)
                ->setSlug($slug)
                ->setType('evenement')
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
                ->setCapacity((int)($_POST['capacity'] ?? 50))
                ->setAvailableSpots((int)($_POST['available_spots'] ?? 50))
                ->setMinParticipants((int)($_POST['min_participants'] ?? 1))
                ->setPrice((float) str_replace(',', '.', $_POST['price'] ?? 0))
                ->setCurrency('EUR')
                ->setImage($uploadedPath)
                ->setCategoryId(!empty($_POST['category_id']) ? (int)$_POST['category_id'] : null)
                ->setOrganizerId($_SESSION['user_id'] ?? 1)
                ->setStatus('published')
                ->setIsFeatured(0);

            $model = new Event();
            $idInserted = $model->insert($evenement);

            if ($idInserted) {
                $this->setFlash('success', 'Événement créé ✅');
                $this->redirect('event', 'index');
            }

            $this->setFlash('error', 'Erreur lors de la création ❌');
            $this->redirect('event', 'create');
        }

        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('event/create', [
            'title' => 'Créer un événement',
            'categories' => $categories
        ]);
    }

    public function edit(int $id): void
    {
        // 🔒 PROTECTION ADMIN
        $this->requireAdmin();

        $model = new Event();
        $evenement = $model->getById($id);

        if (!$evenement || $evenement->getType() !== 'evenement') {
            $this->setFlash('error', 'Événement introuvable.');
            $this->redirect('event', 'index');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $title = trim($_POST['title'] ?? '');
            $location = trim($_POST['location'] ?? '');

            if ($title === '') {
                $this->setFlash('error', 'Le titre est obligatoire.');
                $this->redirect('event', 'edit', ['id' => $id]);
            }

            if ($location === '') {
                $this->setFlash('error', 'Le lieu/adresse est obligatoire.');
                $this->redirect('event', 'edit', ['id' => $id]);
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
                $this->redirect('event', 'edit', ['id' => $id]);
            }

            $uploadedPath = $this->uploadImage('image_file');
            if (!empty($uploadedPath)) {
                $evenement->setImage($uploadedPath);
            }

            $evenement
                ->setTitle($title)
                ->setSlug($slug)
                ->setType('evenement')
                ->setDescription(trim($_POST['description'] ?? ''))
                ->setShortDescription(trim($_POST['short_description'] ?? ''))
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ->setLocation($location)
                ->setLocationCity(trim($_POST['location_city'] ?? ''))
                ->setLocationPostalCode(trim($_POST['location_postal_code'] ?? ''))
                ->setCapacity((int)($_POST['capacity'] ?? 50))
                ->setAvailableSpots((int)($_POST['available_spots'] ?? 50))
                ->setMinParticipants((int)($_POST['min_participants'] ?? 1))
                ->setPrice((float) str_replace(',', '.', $_POST['price'] ?? 0))
                ->setCategoryId(!empty($_POST['category_id']) ? (int)$_POST['category_id'] : null);

            $ok = $model->update($evenement);

            if ($ok) {
                $this->setFlash('success', 'Événement modifié ✅');
                $this->redirect('event', 'show', ['id' => $id]);
            }

            $this->setFlash('error', 'Erreur lors de la modification ❌');
            $this->redirect('event', 'edit', ['id' => $id]);
        }

        $categoryModel = new \App\Models\Category();
        $categories = $categoryModel->getAllActive();

        $this->render('event/edit', [
            'title' => 'Modifier un événement',
            'evenement' => $evenement,
            'categories' => $categories
        ]);
    }

    public function delete(int $id): void
    {
        // 🔒 PROTECTION ADMIN
        $this->requireAdmin();

        $model = new Event();
        $evenement = $model->getById($id);

        if (!$evenement || $evenement->getType() !== 'evenement') {
            $this->setFlash('error', 'Événement introuvable.');
            $this->redirect('event', 'index');
        }

        $ok = $model->delete($id);

        if ($ok) {
            $this->setFlash('success', 'Événement supprimé ✅');
        } else {
            $this->setFlash('error', 'Erreur lors de la suppression ❌');
        }

        $this->redirect('event', 'index');
    }

    private function uploadImage(string $field = 'image_file'): ?string
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
    }
}