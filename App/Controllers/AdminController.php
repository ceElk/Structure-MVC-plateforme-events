<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;

class AdminController extends Controller
{
    // ============================================================
    // DASHBOARD ADMIN
    // ============================================================
    public function dashboard(): void
    {
        // 🔒 Protection admin
        $this->requireAdmin();

        // Statistiques
        $userModel = new User();
        $eventModel = new Event();
        $categoryModel = new Category();

        $totalUsers = $userModel->countAll();
        $totalAdmins = $userModel->countByRole(1); // role_id = 1
        $totalEvents = $eventModel->countAll();
        $totalCategories = $categoryModel->countAll();

        // Derniers utilisateurs
        $allUsers = $userModel->getAll();
        $recentUsers = array_slice($allUsers, 0, 5);

        $this->render('admin/dashboard', [
            'title' => 'Dashboard Admin',
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalEvents' => $totalEvents,
            'totalCategories' => $totalCategories,
            'recentUsers' => $recentUsers
        ]);
    }

    // ============================================================
    // LISTE DES UTILISATEURS
    // ============================================================
    public function users(): void
    {
        // 🔒 Protection admin
        $this->requireAdmin();

        $model = new User();
        $users = $model->getAll();

        $this->render('admin/users', [
            'title' => 'Gestion des utilisateurs',
            'users' => $users
        ]);
    }

    // ============================================================
    // MODIFIER UN UTILISATEUR
    // ============================================================
    public function editUser(int $id): void
    {
        // 🔒 Protection admin
        $this->requireAdmin();

        $model = new User();
        $user = $model->getById($id);

        if (!$user) {
            $this->setFlash('error', 'Utilisateur introuvable.');
            $this->redirect('admin', 'users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $roleId = (int)($_POST['role_id'] ?? 2);

            if ($username === '' || $email === '') {
                $this->setFlash('error', 'Le nom et l\'email sont obligatoires.');
                $this->redirect('admin', 'editUser', ['id' => $id]);
            }

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setRoleId($roleId);

            $ok = $model->update($user);

            if ($ok) {
                $this->setFlash('success', 'Utilisateur modifié ✅');
                $this->redirect('admin', 'users');
            }

            $this->setFlash('error', 'Erreur lors de la modification.');
            $this->redirect('admin', 'editUser', ['id' => $id]);
        }

        $this->render('admin/edit-user', [
            'title' => 'Modifier un utilisateur',
            'user' => $user
        ]);
    }

    // ============================================================
    // SUPPRIMER UN UTILISATEUR
    // ============================================================
    public function deleteUser(int $id): void
    {
        // 🔒 Protection admin
        $this->requireAdmin();

        // Empêcher la suppression de son propre compte
        if ($id === $_SESSION['user_id']) {
            $this->setFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            $this->redirect('admin', 'users');
        }

        $model = new User();
        $ok = $model->delete($id);

        if ($ok) {
            $this->setFlash('success', 'Utilisateur supprimé ✅');
        } else {
            $this->setFlash('error', 'Erreur lors de la suppression.');
        }

        $this->redirect('admin', 'users');
    }

    /**
 * Voir toutes les réservations
 */
public function reservations(): void
{
    $this->requireAdmin();

    $reservationModel = new \App\Models\Reservation();
    $reservations = $reservationModel->getAll();

    $this->render('admin/reservations', [
        'title' => 'Toutes les réservations',
        'reservations' => $reservations
    ]);
}
}