<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Page d'accueil - Action par défaut
     */
    public function index(): void
    {
        $eventModel = new Event();
        $categoryModel = new Category();
        
        $categoryStats = $categoryModel->getCategoriesWithCount();
        $totalEvents = $eventModel->countPublishedEvents();
        $featuredEvents = $eventModel->getFeaturedEvents(3); // Retourne des EventEntity[]
        
        
        $this->render('home/index', [
            'title' => 'EventHub - Découvrez nos ateliers et événements',
            'page' => 'accueil',
            'categoryStats' => $categoryStats,
            'totalEvents' => $totalEvents,
            'featuredEvents' => $featuredEvents
        ]);
    }

    /**
     * Page de connexion
     * Redirige vers AuthController::login()
     */
    public function connexion(): void
    {
        $this->redirect('auth', 'login');
    }

    /**
     * Page d'inscription
     * Redirige vers AuthController::register()
     */
    public function inscription(): void
    {
        $this->redirect('auth', 'register');
    }

    /**
     * Page "À propos"
     */
    public function about(): void
    {
        $this->render('home/about', [
            'title' => 'À propos - EventHub',
            'page' => 'about'
        ]);
    }

    /**
     * Page "Contact"
     */
    public function contact(): void
    {
        $this->render('home/contact', [
            'title' => 'Contact - EventHub',
            'page' => 'contact'
        ]);
    }
}