<?php
require_once 'UserRepository.php';

$results = [];
$term = '';

if (isset($_GET['q'])) {
    $term = $_GET['q'];
    $repo = new UserRepository();
    $results = $repo->search($term);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'includes/header.php'; ?>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Recherche d'utilisateur</h1>
        <form method="get" class="mb-4">
            <input type="text" name="q" class="form-control" placeholder="Nom ou prénom..." value="<?= htmlspecialchars($term) ?>">
        </form>

        <?php if ($term): ?>
            <h2>Résultats pour : <em><?= htmlspecialchars($term) ?></em></h2>
            <?php if ($results): ?>
                <ul class="list-group">
                    <?php foreach ($results as $user): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($user->prenom_gens) ?> <?= htmlspecialchars($user->nom_gens) ?> - <?= htmlspecialchars($user->email_gens) ?>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php else: ?>
                <p>Aucun utilisateur trouvé.</p>
            <?php endif ?>
        <?php endif ?>
    </div>
</body>
</html>