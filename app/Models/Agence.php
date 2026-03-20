<?php

namespace App\Models;

class Agence
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM agence ORDER BY nom ASC');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM agence WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(string $nom): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO agence (nom) VALUES (?)');
        $stmt->execute([$nom]);
    }

    public function update(int $id, string $nom): void
    {
        $stmt = $this->pdo->prepare('UPDATE agence SET nom = ? WHERE id = ?');
        $stmt->execute([$nom, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM agence WHERE id = ?');
        $stmt->execute([$id]);
    }
}
