<?php

namespace App\Controllers;

use App\Models\Event;

class SearchController extends Controller
{
    public function index(): void
    {
        $query = trim($_GET['q'] ?? '');

        if ($query === '') {
            $this->setFlash('warning', 'Veuillez entrer un terme de recherche.');
            $this->redirect('home', 'index');
        }

        $model = new Event();
        $results = $model->search($query);

        $this->render('search/index', [
            'title' => 'Résultats de recherche',
            'query' => $query,
            'results' => $results,
            'count' => count($results)
        ]);
    }
}