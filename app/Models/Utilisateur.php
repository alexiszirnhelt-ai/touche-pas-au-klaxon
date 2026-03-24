<?php

namespace App\Models;

/**
 * Modèle Utilisateur — accès aux données des employés.
 */
class Utilisateur
{
    /** @var \PDO Instance de connexion PDO */
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = \Database::getConnection();
    }

    /**
     * Retourne tous les utilisateurs triés par nom.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, nom, prenom, telephone, email, role FROM utilisateur ORDER BY nom ASC');

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @param string $email Adresse email
     * @return array<string, mixed>|false
     */
    public function findByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = ?');
        $stmt->execute([$email]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
