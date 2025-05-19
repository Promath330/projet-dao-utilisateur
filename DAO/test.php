<?php
require_once 'DAO/UserRepository.php';

$repo = new UserRepository();
$users = $repo->findAll();

foreach ($users as $user) {
    echo $user->nom_gens . " " . $user->prenom_gens . "<br>";
}