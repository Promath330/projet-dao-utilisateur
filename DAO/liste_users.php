<?php
require_once 'UserRepository.php';

$repo = new UserRepository();
$users = $repo->findAll();

if (empty($users)) {
    echo "Aucun utilisateur trouvé.\n";
    exit;
}

echo "📋 Liste des utilisateurs :\n";
echo str_repeat("=", 40) . "\n";

foreach ($users as $user) {
    echo "ID           : " . $user->id_nom . "\n";
    echo "Nom          : " . $user->nom_gens . "\n";
    echo "Prénom       : " . $user->prenom_gens . "\n";
    echo "Email        : " . $user->email_gens . "\n";
    echo "Inscription  : " . $user->dateinscr_gens . "\n";
    echo str_repeat("-", 40) . "\n";
}