<?php
require_once 'user.php';
require_once 'Gens.php';

// Cette classe UserRepository est responsable de la gestion des utilisateurs dans la base de données
// Elle permet de récupérer tous les utilisateurs, de trouver un utilisateur par son ID ou son email
class UserRepository {

    private $pdo;
    // Le constructeur est utilisé pour initialiser la connexion à la base de données
    // Il crée une instance de la classe User et appelle la méthode getConnection() pour obtenir la connexion PDO
    public function __construct() {
        $this->pdo = (new User())->getConnection(); 
    }
    // findAll() : array
    // Cette méthode récupère tous les utilisateurs de la base de données
    // Elle exécute une requête SQL pour sélectionner tous les enregistrements de la table gens
    // Elle utilise la méthode fetchAll() pour récupérer tous les résultats sous forme de tableau d'objets Gens
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM gens");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Gens');
    }
    // findById(int $id) : ?Gens
    // Cette méthode récupère un utilisateur par son ID
    // Elle prépare une requête SQL pour sélectionner un enregistrement de la table gens
    // Elle utilise la méthode execute() pour exécuter la requête avec l'ID passé en paramètre
    public function findById(int $id): ?Gens {
        $stmt = $this->pdo->prepare("SELECT * FROM gens WHERE id_nom = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Gens');
        return $stmt->fetch() ?: null;
    }
    
    public function findByEmail(string $email): ?Gens {
        $stmt = $this->pdo->prepare("SELECT * FROM gens WHERE email_gens = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Gens');
        return $stmt->fetch() ?: null;
    }

    public function search(string $term): array {
        $stmt = $this->pdo->prepare("SELECT * FROM gens WHERE nom_gens LIKE ? OR prenom_gens LIKE ?");
        $like = "%$term%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Gens');
    }
}