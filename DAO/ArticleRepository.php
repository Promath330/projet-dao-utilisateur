<?php
require_once 'user.php'; // pour accéder à getPDO()

class ArticleRepository {
    private $pdo;

    public function __construct() {
        $db = new User(); // Utilise la classe User pour obtenir la connexion
        $this->pdo = $db->getConnection();
    }

    // Récupérer un article par son ID
    public function getArticleById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM article WHERE id_article = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un article
    public function updateArticle($id, $titre, $resume, $texte) {
        $stmt = $this->pdo->prepare("UPDATE article SET titre_article = ?, resume_article = ?, texte_article = ? WHERE id_article = ?");
        $stmt->execute([$titre, $resume, $texte, $id]);
    }
}