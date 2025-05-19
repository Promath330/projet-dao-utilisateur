<?php
session_start();
require_once 'user.php';

// On vérifie la connexion utilisateur
if (!isset($_SESSION['user'])) {
    die("Vous devez être connecté pour modifier un article.");
}

$pdo = (new User())->getConnection();

// Récupérer l'ID de l'article à modifier
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID d'article invalide.");
}

$id_article = (int)$_GET['id'];
$id_user = $_SESSION['user']['id_nom'];

// Charger l'article et vérifier qu'il appartient à l'utilisateur connecté
$stmt = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    die("Article introuvable.");
}

// Contrôle strict : l'article doit appartenir à l'utilisateur connecté
if ($article['id_auteur'] != $id_user) {
    die("Vous n'avez pas la permission de modifier cet article.");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $resume = trim($_POST['resume'] ?? '');
    $texte = trim($_POST['texte'] ?? '');

    // Validation basique
    if ($titre === '' || $resume === '' || $texte === '') {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Mise à jour en base
        $update = $pdo->prepare("UPDATE article SET titre_article = ?, resume_article = ?, texte_article = ? WHERE id_article = ?");
        $update->execute([$titre, $resume, $texte, $id_article]);
        header("Location: liste_mes_articles.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
</head>
<body>
    <h1>Modifier votre article</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="titre">Titre :</label><br>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($article['titre_article']) ?>" required><br><br>

        <label for="resume">Résumé :</label><br>
        <textarea id="resume" name="resume" rows="3" required><?= htmlspecialchars($article['resume_article']) ?></textarea><br><br>

        <label for="texte">Texte complet :</label><br>
        <textarea id="texte" name="texte" rows="8" required><?= htmlspecialchars($article['texte_article']) ?></textarea><br><br>

        <button type="submit">Enregistrer</button>
        <a href="liste_mes_articles.php">Annuler</a>
    </form>
</body>
</html>