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
}
