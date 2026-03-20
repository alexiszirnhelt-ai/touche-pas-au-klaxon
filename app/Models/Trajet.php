<?php

namespace App\Models;

class Trajet
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('
            SELECT t.*,
                   a1.nom AS agence_depart,
                   a2.nom AS agence_arrivee
            FROM trajet t
            JOIN agence a1 ON t.agence_depart_id = a1.id
            JOIN agence a2 ON t.agence_arrivee_id = a2.id
            ORDER BY t.datetime_depart ASC
        ');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('
            SELECT t.*,
                   a1.nom AS agence_depart,
                   a2.nom AS agence_arrivee
            FROM trajet t
            JOIN agence a1 ON t.agence_depart_id = a1.id
            JOIN agence a2 ON t.agence_arrivee_id = a2.id
            WHERE t.id = ?
        ');
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO trajet (agence_depart_id, agence_arrivee_id, datetime_depart,
                                datetime_arrivee, places_total, places_dispo, utilisateur_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $stmt->execute([
            $data['agence_depart_id'],
            $data['agence_arrivee_id'],
            $data['datetime_depart'],
            $data['datetime_arrivee'],
            $data['places_total'],
            $data['places_total'],
            $data['utilisateur_id'],
        ]);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('
            UPDATE trajet
            SET agence_depart_id  = ?,
                agence_arrivee_id = ?,
                datetime_depart   = ?,
                datetime_arrivee  = ?,
                places_total      = ?,
                places_dispo      = ?
            WHERE id = ?
        ');
        $stmt->execute([
            $data['agence_depart_id'],
            $data['agence_arrivee_id'],
            $data['datetime_depart'],
            $data['datetime_arrivee'],
            $data['places_total'],
            $data['places_dispo'],
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM trajet WHERE id = ?');
        $stmt->execute([$id]);
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
