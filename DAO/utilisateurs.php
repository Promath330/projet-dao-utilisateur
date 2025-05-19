<?php
require_once 'UserRepository.php';

$repo = new UserRepository();
$users = $repo->findAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
   
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<?php include 'includes/header.php'; ?>
<body class="p-4">
    <div class="container">
        <h1 class="mb-4">Liste des utilisateurs</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->nom_gens) ?></td>
                        <td><?= htmlspecialchars($user->prenom_gens) ?></td>
                        <td><?= htmlspecialchars($user->email_gens) ?></td>
                        <td><?= htmlspecialchars($user->dateinscr_gens) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>