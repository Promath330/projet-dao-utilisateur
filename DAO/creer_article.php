<?php
//session_start(); // Démarre une nouvelle session ou reprend une session existante
//session_destroy(); // Détruit toutes les données associées à la session actuelle
session_start();
// Redirection vers la page d'accueil après la déconnexion
//header('Location: index.php'); // Redirige l'utilisateur vers la page d'accueil
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
require_once 'Article.php';
//if sert à vérifier si la méthode de la requête HTTP est POST
// Cela signifie que le formulaire de création d'article a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On crée une nouvelle instance de la classe Article
    // qui est responsable de la gestion des articles dans la base de données
    $article = new Article();
    $article->createArticle($_POST['titre'], $_POST['resume'], $_POST['texte'], $_SESSION['user']['id_nom']);
    // On redirige l'utilisateur vers la page d'accueil après la création de l'article
    // Cela permet d'éviter que l'utilisateur ne soumette à nouveau le formulaire
    header('Location: index.php');
    // On termine le script PHP
    // Cela permet de s'assurer que le reste du code ne sera pas exécuté
    exit;
}
?>

<?php include 'includes/header.php'; ?>
<h2>Nouvel article</h2>
<form method="POST">
    <input type="text" name="titre" placeholder="Titre" required><br>
    <textarea name="resume" placeholder="Résumé" required></textarea><br>
    <textarea name="texte" placeholder="Contenu" required></textarea><br>
    <button type="submit">Publier</button>
</form>
<?php include 'includes/footer.php'; ?>