<?php

namespace App\Controllers;

use App\Models\Utilisateur;

class AuthController
{
    public function showLogin(): void
    {
        require_once __DIR__ . '/../Views/login.php';
    }

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

    public function logout(): void
    {
        session_destroy();
        header('Location: /touche-pas-au-klaxon/public/');
        exit;
    }
}
