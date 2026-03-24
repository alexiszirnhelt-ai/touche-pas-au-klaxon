<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un trajet - Touche pas au klaxon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-light bg-white border-bottom px-4 d-flex justify-content-between">
    <a class="navbar-brand fw-bold" href="/touche-pas-au-klaxon/public/">Touche pas au klaxon</a>
    <div class="d-flex align-items-center gap-3">
        <span>Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?></span>
        <a href="/touche-pas-au-klaxon/public/logout" class="btn btn-dark">Déconnexion</a>
    </div>
</nav>

<div class="container mt-5" style="max-width: 540px;">
    <h2 class="mb-4">Créer un trajet</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h6 class="card-subtitle mb-3 text-muted">Personne à contacter</h6>
            <div class="row g-2">
                <div class="col-6">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($utilisateur['nom'] ?? '') ?>" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Prénom</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($utilisateur['prenom'] ?? '') ?>" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Téléphone</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($utilisateur['telephone'] ?? '') ?>" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($utilisateur['email'] ?? '') ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <form action="/touche-pas-au-klaxon/public/trajet/create" method="POST">
        <div class="mb-3">
            <label for="agence_depart_id" class="form-label">Agence de départ</label>
            <select id="agence_depart_id" name="agence_depart_id" class="form-select" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= (int) $agence['id'] ?>">
                        <?= htmlspecialchars($agence['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="agence_arrivee_id" class="form-label">Agence d'arrivée</label>
            <select id="agence_arrivee_id" name="agence_arrivee_id" class="form-select" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($agences as $agence): ?>
                    <option value="<?= (int) $agence['id'] ?>">
                        <?= htmlspecialchars($agence['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="datetime_depart" class="form-label">Date et heure de départ</label>
            <input type="datetime-local" id="datetime_depart" name="datetime_depart"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="datetime_arrivee" class="form-label">Date et heure d'arrivée</label>
            <input type="datetime-local" id="datetime_arrivee" name="datetime_arrivee"
                   class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="places_total" class="form-label">Nombre de places</label>
            <input type="number" id="places_total" name="places_total"
                   class="form-control" min="1" max="9" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-dark">Créer le trajet</button>
            <a href="/touche-pas-au-klaxon/public/" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>

<footer class="text-center text-muted mt-5 mb-3">
    &copy; 2024 - CENEF - MVC PHP
</footer>

</body>
</html>
