<?php
//session_start();sert à démarrer une nouvelle session ou à reprendre une session existante
//session_destroy();sert à détruire toutes les données associées à la session actuelle
session_start();
session_destroy();
// Redirection vers la page d'accueil après la déconnexion
//header('Location: index.php');sert à rediriger l'utilisateur vers une autre page
header('Location: index.php');
//exit;sert à terminer le script PHP en cours d'exécution
exit;
?>