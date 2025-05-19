<?php
//require_once sert à inclure le fichier 'Gens.php' qui contient la classe Gens
// Cette classe est responsable de la gestion des utilisateurs dans la base de données
require_once 'Gens.php';
//if ($_SERVER['REQUEST_METHOD'] === 'POST') vérifie si la méthode de la requête HTTP est POST
// Cela signifie que le formulaire d'inscription a été soumis
// Si la méthode de la requête est POST, cela signifie que le formulaire a été soumis
// et que nous devons traiter les données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On vérifie si le formulaire a été soumis
    // On crée une nouvelle instance de la classe Gens
    $gens = new Gens();
    // On appelle la méthode createGens de la classe Gens
    // pour créer un nouvel utilisateur avec les données du formulaire
    $gens->createGens($_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['password']);
    // On redirige l'utilisateur vers la page d'accueil après l'inscription
    // Cela permet d'éviter que l'utilisateur ne soumette à nouveau le formulaire
    header('Location: index.php');
    // On termine le script PHP
    // Cela permet de s'assurer que le reste du code ne sera pas exécuté
    exit;
}
?>

<?php include 'includes/header.php'; ?>
<h2>Inscription</h2>
<form method="POST">
    <input type="text" name="nom" placeholder="Nom" required><br>
    <input type="text" name="prenom" placeholder="Prénom" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mot de passe" required><br>
    <button type="submit">S’inscrire</button>
</form>
<?php include 'includes/footer.php'; ?>