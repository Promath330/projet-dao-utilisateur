<?php
//session_start(); // Démarre une nouvelle session ou reprend une session existante
//session_destroy(); // Détruit toutes les données associées à la session actuelle
session_start();
// require_once 'Gens.php'; // Inclut le fichier contenant la classe Gens
// require_once 'Article.php'; // Inclut le fichier contenant la classe Article
require_once 'Gens.php';
require_once 'Article.php';
require_once 'UserRepository.php';
// $article = new Article(); // Crée une nouvelle instance de la classe Article
// $articles = $article->getAllArticlesWithAuthor(); // Récupère tous les articles avec leurs auteurs
$article = new Article();
$articles = $article->getAllArticlesWithAuthor();
// if sert à vérifier si la méthode de la requête HTTP est POST
// Cela signifie que le formulaire de connexion a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    // On crée une nouvelle instance de la classe Gens
    // qui est responsable de la gestion des utilisateurs dans la base de données
    $gens = new Gens();
    // On appelle la méthode authenticate de la classe Gens
    // pour vérifier les identifiants de l'utilisateur
    // La méthode authenticate prend l'email et le mot de passe en paramètres
    // Si l'utilisateur est authentifié avec succès, il est redirigé vers la page d'accueil
    $user = $gens->authenticate($_POST['email'], $_POST['password']);
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: index.php');
        exit;
        //esle sert à gérer le cas où l'authentification échoue
        // Dans ce cas, un message d'erreur est affiché
    } else {
        $error = "Identifiants incorrects.Recommence ducon";
    }
}
?>

<?php include 'includes/header.php'; ?>
<h1>Articles récents</h1>

<?php if (isset($_SESSION['user'])): ?>
    <p>Connecté en tant que <?= htmlspecialchars($_SESSION['user']['prenom_gens']) ?> <a href="logout.php">[Déconnexion]</a></p>
    <a href="creer_article.php">Créer un article</a>
<?php else: ?>
    <h2>Connexion</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <p><a href="inscription.php">Créer un compte</a></p>
<?php endif; ?>

<hr>
<?php foreach ($articles as $a): ?>
    <article>
        <h3><?= htmlspecialchars($a['titre_article']) ?></h3>
        <p><em>Par <?= htmlspecialchars($a['prenom_gens']) . ' ' . htmlspecialchars($a['nom_gens']) ?>, le <?= $a['date_article'] ?></em></p>
        <p><?= nl2br(htmlspecialchars($a['resume_article'])) ?></p>
    </article>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>