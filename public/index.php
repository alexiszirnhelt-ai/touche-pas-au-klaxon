<?php

require_once '../config/database.php';

$db = new Database();
$pdo = $db->getConnection();

echo "Connexion réussie !";