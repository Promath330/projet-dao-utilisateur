<?php
session_start();
require_once 'user.php';
require_once 'ArticleRepository.php';
require_once 'UserRepository.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    echo "Veuillez vous connecter pour voir vos articles.";
    exit;
}

$idAuteur = $_SESSION['user']['id_nom'];  // récupère l'id utilisateur dans le tableau user

$repo = new ArticleRepository();
$pdo = (new User())->getConnection();

// Récupère les articles de l'utilisateur connecté
$idAuteur = $_SESSION['user']['id_nom'];
$stmt = $pdo->prepare("SELECT * FROM article WHERE id_auteur = ?");
$stmt->execute([$idAuteur]);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mes Articles</title>
</head>
<?php include 'includes/header.php'; ?>
<body>
    <h1>Mes articles</h1>

    <?php if (empty($articles)) : ?>
        <p>Vous n'avez pas encore publié d'article.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($articles as $article) : ?>
                <li>
                    <strong><?= htmlspecialchars($article['titre_article']) ?></strong><br>
                    <?= htmlspecialchars($article['resume_article']) ?><br>
                    <a href="modifier_article.php?id=<?= $article['id_article'] ?>">Modifier</a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>