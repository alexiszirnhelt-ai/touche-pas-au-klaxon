<?php

namespace App\Controllers;

use App\Models\Agence;
use App\Models\Trajet;
use App\Models\Utilisateur;

/**
 * Contrôleur Admin — tableau de bord réservé aux administrateurs.
 * Gestion des utilisateurs, agences et trajets.
 */
class AdminController
{
    /**
     * Redirige vers l'accueil si l'utilisateur n'est pas administrateur.
     *
     * @return void
     */
    private function requireAdmin(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }
    }

    /**
     * Affiche la liste de tous les utilisateurs.
     *
     * @return void
     */
    public function users(): void
    {
        $this->requireAdmin();

        $utilisateurs = (new Utilisateur())->getAll();

        require_once __DIR__ . '/../Views/admin/users.php';
    }

    /**
     * Affiche la liste de toutes les agences.
     *
     * @return void
     */
    public function agences(): void
    {
        $this->requireAdmin();

        $agences = (new Agence())->getAll();

        require_once __DIR__ . '/../Views/admin/agences.php';
    }

    /**
     * Affiche le formulaire de création d'une agence.
     *
     * @return void
     */
    public function createAgence(): void
    {
        $this->requireAdmin();

        require_once __DIR__ . '/../Views/admin/agence-create.php';
    }

    /**
     * Traite le formulaire et insère la nouvelle agence en base.
     *
     * @return void
     */
    public function storeAgence(): void
    {
        $this->requireAdmin();

        (new Agence())->create(trim($_POST['nom']));

        $_SESSION['flash'] = 'Agence créée avec succès.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    /**
     * Affiche le formulaire de modification d'une agence.
     *
     * @param int $id Identifiant de l'agence
     * @return void
     */
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

    /**
     * Traite le formulaire et met à jour l'agence en base.
     *
     * @param int $id Identifiant de l'agence
     * @return void
     */
    public function updateAgence(int $id): void
    {
        $this->requireAdmin();

        (new Agence())->update($id, trim($_POST['nom']));

        $_SESSION['flash'] = 'Agence modifiée avec succès.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    /**
     * Supprime une agence.
     *
     * @param int $id Identifiant de l'agence
     * @return void
     */
    public function deleteAgence(int $id): void
    {
        $this->requireAdmin();

        (new Agence())->delete($id);

        $_SESSION['flash'] = 'Agence supprimée.';
        header('Location: /touche-pas-au-klaxon/public/admin/agences');
        exit;
    }

    /**
     * Affiche la liste de tous les trajets (vue admin).
     *
     * @return void
     */
    public function trajets(): void
    {
        $this->requireAdmin();

        $trajets = (new Trajet())->getAll();

        require_once __DIR__ . '/../Views/admin/trajets.php';
    }

    /**
     * Supprime un trajet (action admin).
     *
     * @param int $id Identifiant du trajet
     * @return void
     */
    public function deleteTrajet(int $id): void
    {
        $this->requireAdmin();

        (new Trajet())->delete($id);

        $_SESSION['flash'] = 'Trajet supprimé.';
        header('Location: /touche-pas-au-klaxon/public/admin/trajets');
        exit;
    }
}
