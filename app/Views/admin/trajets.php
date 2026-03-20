<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trajets - Admin - Touche pas au klaxon</title>
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

<?php if (isset($_SESSION['flash'])): ?>
    <div class="container mt-3">
        <div class="alert alert-secondary"><?= htmlspecialchars($_SESSION['flash']) ?></div>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="mb-3">Trajets</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Départ</th>
                <th>Date départ</th>
                <th>Destination</th>
                <th>Date arrivée</th>
                <th>Places dispo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $trajet): ?>
            <tr>
                <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($trajet['datetime_depart'])) ?></td>
                <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($trajet['datetime_arrivee'])) ?></td>
                <td><?= (int) $trajet['places_dispo'] ?> / <?= (int) $trajet['places_total'] ?></td>
                <td>
                    <form action="/touche-pas-au-klaxon/public/admin/trajets/delete/<?= (int) $trajet['id'] ?>"
                          method="POST" class="d-inline">
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Supprimer ce trajet ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    &copy; 2024 - CENEF - MVC PHP
</footer>

</body>
</html>
