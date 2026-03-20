<?php

namespace App\Controllers;

use App\Models\Agence;
use App\Models\Trajet;
use App\Models\Utilisateur;

class AdminController
{
    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }
    }

    public function users(): void
    {
        $this->requireAdmin();

        $utilisateurs = (new Utilisateur())->getAll();

        require_once __DIR__ . '/../Views/admin/users.php';
    }

    public function agences(): void
    {
        $this->requireAdmin();

        $agences = (new Agence())->getAll();

        require_once __DIR__ . '/../Views/admin/agences.php';
    }

    public function createAgence(): void
    {
        $this->requireAdmin();

        require_once __DIR__ . '/../Views/admin/agence-create.php';
    }

    public function storeAgence(): void
    {
        $this->requireAdmin();

        (new Agence())->create(trim($_POST['nom']));

        $_SESSION['flash'] = 'Agence créée avec succès.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    public function editAgence(int $id): void
    {
        $this->requireAdmin();

        $agence = (new Agence())->getById($id);

        if (!$agence) {
            header('Location: /touche-pas-au-klaxon/public/admin/agences');
            exit;
        }

        require_once __DIR__ . '/../Views/admin/agence-edit.php';
    }

    public function updateAgence(int $id): void
    {
        $this->requireAdmin();

        (new Agence())->update($id, trim($_POST['nom']));

        $_SESSION['flash'] = 'Agence modifiée avec succès.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    public function deleteAgence(int $id): void
    {
        $this->requireAdmin();

        (new Agence())->delete($id);

        $_SESSION['flash'] = 'Agence supprimée.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    public function trajets(): void
    {
        $this->requireAdmin();

        $trajets = (new Trajet())->getAll();

        require_once __DIR__ . '/../Views/admin/trajets.php';
    }

    public function deleteTrajet(int $id): void
    {
        $this->requireAdmin();

        (new Trajet())->delete($id);

        $_SESSION['flash'] = 'Trajet supprimé.';
        header('Location: /touche-pas-au-klaxon/public/admin/trajets');
        exit;
    }
}
