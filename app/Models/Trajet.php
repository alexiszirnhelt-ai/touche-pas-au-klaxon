<?php

namespace App\Models;

/**
 * Modèle Trajet — gestion des trajets de covoiturage.
 */
class Trajet
{
    /** @var \PDO Instance de connexion PDO */
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    /**
     * Retourne tous les trajets avec les noms des agences, triés par date de départ.
     *
     * @return array<int, array<string, mixed>>
     */
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

    /**
     * Retourne un trajet par son identifiant.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
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

    /**
     * Retourne un trajet avec les informations de contact de son auteur.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function getByIdWithUser(int $id): array|false
    {
        $stmt = $this->pdo->prepare('
            SELECT t.*,
                   a1.nom AS agence_depart,
                   a2.nom AS agence_arrivee,
                   u.nom AS user_nom,
                   u.prenom AS user_prenom,
                   u.telephone AS user_telephone,
                   u.email AS user_email
            FROM trajet t
            JOIN agence a1 ON t.agence_depart_id = a1.id
            JOIN agence a2 ON t.agence_arrivee_id = a2.id
            JOIN utilisateur u ON t.utilisateur_id = u.id
            WHERE t.id = ?
        ');
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau trajet. Les places disponibles sont initialisées
     * au nombre total de places.
     *
     * @param array<string, mixed> $data Données du trajet
     * @return void
     */
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

    /**
     * Met à jour un trajet existant.
     *
     * @param int                  $id   Identifiant du trajet
     * @param array<string, mixed> $data Nouvelles données
     * @return void
     */
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

    /**
     * Supprime un trajet.
     *
     * @param int $id Identifiant du trajet
     * @return void
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM trajet WHERE id = ?');
        $stmt->execute([$id]);
    }

    /**
     * Retourne les trajets disponibles (places > 0, date future)
     * avec les informations de contact de l'auteur.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAvailableTrips(): array
    {
        $stmt = $this->pdo->query('
            SELECT t.*,
                   a1.nom AS agence_depart,
                   a2.nom AS agence_arrivee,
                   u.nom AS user_nom,
                   u.prenom AS user_prenom,
                   u.telephone AS user_telephone,
                   u.email AS user_email
            FROM trajet t
            JOIN agence a1 ON t.agence_depart_id = a1.id
            JOIN agence a2 ON t.agence_arrivee_id = a2.id
            JOIN utilisateur u ON t.utilisateur_id = u.id
            WHERE t.places_dispo > 0
              AND t.datetime_depart > NOW()
            ORDER BY t.datetime_depart ASC
        ');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
