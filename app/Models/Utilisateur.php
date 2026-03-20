<?php

namespace App\Models;

class Utilisateur
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, nom, prenom, telephone, email, role FROM utilisateur ORDER BY nom ASC');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = ?');
        $stmt->execute([$email]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
