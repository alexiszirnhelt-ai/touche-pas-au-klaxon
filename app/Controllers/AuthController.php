<?php

namespace App\Controllers;

use App\Models\Utilisateur;

/**
 * Contrôleur d'authentification — connexion et déconnexion des utilisateurs.
 */
class AuthController
{
    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function showLogin(): void
    {
        require_once __DIR__ . '/../Views/login.php';
    }

    /**
     * Traite le formulaire de connexion.
     * Vérifie l'email et le mot de passe, puis crée la session utilisateur.
     *
     * @return void
     */
    public function login(): void
    {
        $email    = $_POST['email']    ?? '';
        $password = $_POST['password'] ?? '';

        $model       = new Utilisateur();
        $utilisateur = $model->findByEmail($email);

        if ($utilisateur && password_verify($password, $utilisateur['password'])) {
            $_SESSION['user'] = [
                'id'     => $utilisateur['id'],
                'nom'    => $utilisateur['nom'],
                'prenom' => $utilisateur['prenom'],
                'role'   => $utilisateur['role'],
            ];
            header('Location: /touche-pas-au-klaxon/public/');
            exit;
        }

        $error = 'Email ou mot de passe incorrect.';
        require_once __DIR__ . '/../Views/login.php';
    }

    /**
     * Déconnecte l'utilisateur en détruisant la session.
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /touche-pas-au-klaxon/public/');
        exit;
    }
}
