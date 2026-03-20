<?php

namespace App\Models;

class Trajet
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    public function getAvailableTrips(): array
    {
        $stmt = $this->pdo->query('
            SELECT t.*,
                   a1.nom AS agence_depart,
                   a2.nom AS agence_arrivee
            FROM trajet t
            JOIN agence a1 ON t.agence_depart_id = a1.id
            JOIN agence a2 ON t.agence_arrivee_id = a2.id
            WHERE t.places_dispo > 0
              AND t.datetime_depart > NOW()
            ORDER BY t.datetime_depart ASC
        ');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
