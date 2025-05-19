<?php
require_once 'user.php';
// Cette classe article est responsable de la gestion des articles dans la base de données
// Elle permet de créer de nouveaux articles et de récupérer tous les articles avec leurs auteurs
class Article {
    private $conn;
    private $table = 'article';
    //public function __construct() sert à initialiser la classe Article
    // Le constructeur est vide car nous n'avons pas besoin d'initialiser des propriétés spécifiques
    public function __construct() {
        $db = new User();
        $this->conn = $db->getConnection();
    }
    // La méthode createArticle est utilisée pour créer un nouvel article dans la base de données
    // Elle prend en paramètres le titre, le résumé, le texte et l'ID de l'auteur de l'article
    public function createArticle($titre, $resume, $texte, $id_auteur) {
        $sql = "INSERT INTO $this->table (titre_article, resume_article, texte_article, date_article, id_auteur)
                VALUES (:titre, :resume, :texte, NOW(), :id_auteur)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':titre' => $titre,
            ':resume' => $resume,
            ':texte' => $texte,
            ':id_auteur' => $id_auteur
        ]);
    }
    // La méthode getAllArticlesWithAuthor est utilisée pour récupérer tous les articles
    // avec leurs auteurs dans la base de données
    public function getAllArticlesWithAuthor() {

        // On prépare une requête SQL pour récupérer tous les articles
        // avec leurs auteurs dans la table article
        $sql = "SELECT a.*, g.nom_gens, g.prenom_gens
                FROM article a
                JOIN gens g ON a.id_auteur = g.id_nom
                ORDER BY date_article DESC";
        // On prépare la requête SQL avec la connexion PDO
        // La méthode prepare() prépare la requête SQL pour une exécution ultérieure
        $stmt = $this->conn->prepare($sql);
        // On exécute la requête préparée
        // La méthode execute() exécute la requête sans paramètres
        $stmt->execute();
        // On récupère tous les résultats de la requête
        // La méthode fetchAll() récupère tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>