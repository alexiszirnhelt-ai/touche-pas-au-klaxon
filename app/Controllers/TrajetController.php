<?php

namespace App\Controllers;

use App\Models\Agence;
use App\Models\Trajet;

class TrajetController
{
    private function requireAuth(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: /touche-pas-au-klaxon/public/login');
            exit;
        }
    }

    public function index(): void
    {
        $model   = new Trajet();
        $trajets = $model->getAvailableTrips();

        require_once __DIR__ . '/../Views/home.php';
    }

    public function create(): void
    {
        $this->requireAuth();

        $agences = (new Agence())->getAll();

        require_once __DIR__ . '/../Views/trajet/create.php';
    }

    public function store(): void
    {
        $this->requireAuth();

        $model = new Trajet();
        $model->create([
            'agence_depart_id'  => (int) $_POST['agence_depart_id'],
            'agence_arrivee_id' => (int) $_POST['agence_arrivee_id'],
            'datetime_depart'   => $_POST['datetime_depart'],
            'datetime_arrivee'  => $_POST['datetime_arrivee'],
            'places_total'      => (int) $_POST['places_total'],
            'utilisateur_id'    => $_SESSION['user']['id'],
        ]);

        $_SESSION['flash'] = 'Trajet créé avec succès.';
        header('Location: /touche-pas-au-klaxon/public/');
        exit;
    }

    public function edit(int $id): void
    {
        $this->requireAuth();

        $model  = new Trajet();
        $trajet = $model->getById($id);

        if (!$trajet || $trajet['utilisateur_id'] !== $_SESSION['user']['id']) {
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }

        $agences = (new Agence())->getAll();

        require_once __DIR__ . '/../Views/trajet/edit.php';
    }

    public function update(int $id): void
    {
        $this->requireAuth();

        $model  = new Trajet();
        $trajet = $model->getById($id);

        if (!$trajet || $trajet['utilisateur_id'] !== $_SESSION['user']['id']) {
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }

        $model->update($id, [
            'agence_depart_id'  => (int) $_POST['agence_depart_id'],
            'agence_arrivee_id' => (int) $_POST['agence_arrivee_id'],
            'datetime_depart'   => $_POST['datetime_depart'],
            'datetime_arrivee'  => $_POST['datetime_arrivee'],
            'places_total'      => (int) $_POST['places_total'],
            'places_dispo'      => (int) $_POST['places_dispo'],
        ]);

        $_SESSION['flash'] = 'Trajet modifié avec succès.';
        header('Location: /touche-pas-au-klaxon/public/');
        exit;
    }

    public function delete(int $id): void
    {
        $this->requireAuth();

        $model  = new Trajet();
        $trajet = $model->getById($id);

        if (!$trajet || $trajet['utilisateur_id'] !== $_SESSION['user']['id']) {
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }

        $model->delete($id);

        $_SESSION['flash'] = 'Trajet supprimé.';
        header('Location: /touche-pas-au-klaxon/public/');
        exit;
    }
}
