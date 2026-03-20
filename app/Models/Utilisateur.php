<?php

namespace App\Models;

class Utilisateur
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = ?');
        $stmt->execute([$email]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
