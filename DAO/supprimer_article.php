<?php
session_start();
require_once 'user.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    die("Vous devez être connecté pour supprimer un article.");
}

$pdo = (new User())->getConnection();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID d'article invalide.");
}

$id_article = (int)$_GET['id'];
$id_user = $_SESSION['user']['id_nom'];

// Vérifie que l'article existe et appartient à l'utilisateur
$stmt = $pdo->prepare("SELECT id_auteur FROM article WHERE id_article = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article introuvable.");
}

if ($article['id_auteur'] != $id_user) {
    die("Vous n'avez pas la permission de supprimer cet article.");
}

// Suppression de l'article
$delete = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
$delete->execute([$id_article]);

// Redirection vers la liste des articles personnels après suppression
header("Location: liste_mes_articles.php");
exit;
?>
<?php include 'includes/header.php'; ?>
<a href="supprimer_article.php=<?= $article['id_article'] ?>" onclick="return confirm('Tu veux vraiment supprimer cet article ? Cette action est irréversible !');">Supprimer</a>