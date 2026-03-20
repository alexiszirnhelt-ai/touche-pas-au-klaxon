<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom px-4 d-flex justify-content-between">
    <span class="navbar-brand fw-bold">Touche pas au klaxon</span>
    <div class="d-flex align-items-center gap-3">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/touche-pas-au-klaxon/public/trajet/create" class="btn btn-dark">Créer un trajet</a>
            <span>Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></span>
            <a href="/touche-pas-au-klaxon/public/logout" class="btn btn-dark">Déconnexion</a>
        <?php else: ?>
            <a href="/touche-pas-au-klaxon/public/login" class="btn btn-dark">Connexion</a>
        <?php endif; ?>
    </div>
</nav>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="container mt-3">
        <div class="alert alert-secondary">
            <?= htmlspecialchars($_SESSION['flash']) ?>
        </div>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="container mt-4">
    <h2 class="mb-3">Trajets proposés</h2>

    <?php if (!isset($_SESSION['user'])): ?>
        <p class="lead">Pour obtenir plus d'informations sur un trajet, veuillez vous connecter</p>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Départ</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Destination</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places</th>
                <?php if (isset($_SESSION['user'])): ?><th></th><?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $trajet): ?>
            <tr>
                <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                <td><?= date('d/m/Y', strtotime($trajet['datetime_depart'])) ?></td>
                <td><?= date('H:i', strtotime($trajet['datetime_depart'])) ?></td>
                <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                <td><?= date('d/m/Y', strtotime($trajet['datetime_arrivee'])) ?></td>
                <td><?= date('H:i', strtotime($trajet['datetime_arrivee'])) ?></td>
                <td><?= (int) $trajet['places_dispo'] ?></td>
                <?php if (isset($_SESSION['user'])): ?>
                <td class="text-nowrap">
                    <button type="button" class="btn btn-link p-0" title="Voir"
                            data-bs-toggle="modal" data-bs-target="#modal-<?= (int) $trajet['id'] ?>">
                        <i class="bi bi-eye"></i>
                    </button>
                    <?php if ($_SESSION['user']['id'] === $trajet['utilisateur_id']): ?>
                        <a href="/touche-pas-au-klaxon/public/trajet/edit/<?= (int) $trajet['id'] ?>" class="ms-1" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                        <form action="/touche-pas-au-klaxon/public/trajet/delete/<?= (int) $trajet['id'] ?>" method="POST" class="d-inline ms-1">
                            <button type="submit" class="btn btn-link p-0" title="Supprimer"><i class="bi bi-trash text-danger"></i></button>
                        </form>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>

            <!-- Modale trajet #<?= (int) $trajet['id'] ?> -->
            <div class="modal fade" id="modal-<?= (int) $trajet['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close float-end" data-bs-dismiss="modal"></button>
                            <h5 class="mb-3"><?= htmlspecialchars($trajet['agence_depart']) ?> → <?= htmlspecialchars($trajet['agence_arrivee']) ?></h5>
                            <p><strong>Auteur :</strong> <?= htmlspecialchars($trajet['user_prenom'] . ' ' . $trajet['user_nom']) ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['user_telephone']) ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($trajet['user_email']) ?></p>
                            <p><strong>Nombre total de places :</strong> <?= (int) $trajet['places_total'] ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    &copy; 2024 - CENEF - MVC PHP
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
