<?php

namespace App\Controllers;

use App\Models\Trajet;

class TrajetController
{
    public function index(): void
    {
        $model = new Trajet();
        $trajets = $model->getAvailableTrips();

        require_once __DIR__ . '/../Views/home.php';
    }
}
