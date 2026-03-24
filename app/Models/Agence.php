<?php

namespace App\Models;

/**
 * Modèle Agence — gestion des agences (villes) en base de données.
 */
class Agence
{
    /** @var \PDO Instance de connexion PDO */
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    /**
     * Retourne toutes les agences triées par nom.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM agence ORDER BY nom ASC');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retourne une agence par son identifiant.
     *
     * @param int $id
     * @return array<string, mixed>|false
     */
    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM agence WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle agence.
     *
     * @param string $nom Nom de l'agence
     * @return void
     */
    public function create(string $nom): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO agence (nom) VALUES (?)');
        $stmt->execute([$nom]);
    }

    /**
     * Met à jour le nom d'une agence existante.
     *
     * @param int    $id  Identifiant de l'agence
     * @param string $nom Nouveau nom
     * @return void
     */
    public function update(int $id, string $nom): void
    {
        $stmt = $this->pdo->prepare('UPDATE agence SET nom = ? WHERE id = ?');
        $stmt->execute([$nom, $id]);
    }

    /**
     * Supprime une agence.
     *
     * @param int $id Identifiant de l'agence
     * @return void
     */
    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM agence WHERE id = ?');
        $stmt->execute([$id]);
    }
}
