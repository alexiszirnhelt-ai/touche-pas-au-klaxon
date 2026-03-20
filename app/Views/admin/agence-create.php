<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une agence - Admin - Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom px-4 d-flex justify-content-between">
    <a class="navbar-brand fw-bold" href="/touche-pas-au-klaxon/public/">Touche pas au klaxon</a>
    <div class="d-flex align-items-center gap-2">
        <a href="/touche-pas-au-klaxon/public/admin/users"   class="btn btn-secondary btn-sm">Utilisateurs</a>
        <a href="/touche-pas-au-klaxon/public/admin/agences" class="btn btn-secondary btn-sm">Agences</a>
        <a href="/touche-pas-au-klaxon/public/admin/trajets" class="btn btn-secondary btn-sm">Trajets</a>
        <span class="ms-2">Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></span>
        <a href="/touche-pas-au-klaxon/public/logout" class="btn btn-dark btn-sm">Déconnexion</a>
    </div>
</nav>

<div class="container mt-5" style="max-width: 420px;">
    <h2 class="mb-4">Créer une agence</h2>

    <form action="/touche-pas-au-klaxon/public/admin/agences/create" method="POST">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required autofocus>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark">Créer</button>
            <a href="/touche-pas-au-klaxon/public/admin/agences" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    &copy; 2024 - CENEF - MVC PHP
</footer>

</body>
</html>
