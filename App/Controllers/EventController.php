<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;

class EventController extends Controller
{
    /**
     * Liste des événements avec filtres
     * URL ex:
     * ?controller=event&action=list
     * ?controller=event&action=list&type=atelier
     * ?controller=event&action=list&type=evenement
     * ?controller=event&action=list&type=atelier&category=1
     */
    public function list(): void
    {
        $eventModel = new Event();
        $categoryModel = new Category();

        // ✅ Paramètres de filtre
        $type = $_GET['type'] ?? null; // 'atelier' ou 'evenement'
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $filter = $_GET['filter'] ?? null;

        // ✅ Sécurité sur type
        if (!in_array($type, [null, 'atelier', 'evenement'], true)) {
            $type = null;
        }

        // ✅ Events filtrés
        $events = $eventModel->getFilteredEvents($type, $categoryId, $filter);

        // ✅ Catégories (filtre)
        $categories = $categoryModel->getAllActive();

        // ✅ Titre page
        $pageTitle = 'Tous les événements';
        if ($type === 'atelier') {
            $pageTitle = 'Ateliers';
        } elseif ($type === 'evenement') {
            $pageTitle = 'Événements';
        }

        $this->render('event/list', [
            'title' => $pageTitle . ' - EventHub',
            'page' => 'events',
            'events' => $events,              // tableau de EventEntity
            'categories' => $categories,
            'currentType' => $type,
            'currentCategory' => $categoryId,
            'pageTitle' => $pageTitle
        ]);
    }

    /**
     * Détail d'un événement
     * URL: ?controller=event&action=detail&id=2
     *
     * Ton Router envoie automatiquement l'id en paramètre si présent,
     * donc on utilise detail(int $id)
     */
    public function detail(int $id): void
    {
        $eventModel = new Event();

        $event = $eventModel->findById((int)$id);

        if (!$event) {
            $this->setFlash('error', 'Événement introuvable.');
            $this->redirect('home', 'index');
        }

        // ✅ Incrémenter le compteur de vues
        $eventModel->incrementViews((int)$id);

        $this->render('event/detail', [
            'title' => htmlspecialchars($event->getTitle() ?? '') . ' - EventHub',
            'page' => 'event-detail',
            'event' => $event // EventEntity
        ]);
    }
}
