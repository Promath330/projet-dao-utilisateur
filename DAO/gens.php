<?php
require_once 'user.php';
// Cette classe Gens est responsable de la gestion des utilisateurs dans la base de données
// Elle permet de créer de nouveaux utilisateurs et d'authentifier les utilisateurs existants
class Gens {
    private $conn;
    private $table = 'gens';
    //public function __construct() sert à initialiser la classe Gens
    // Le constructeur est vide car nous n'avons pas besoin d'initialiser des propriétés spécifiques
    public function __construct() {
        // On crée une nouvelle instance de la classe User
        // qui est responsable de la connexion à la base de données
        $db = new User();
        // On appelle la méthode getConnection de la classe User
        // pour obtenir une instance de la connexion PDO
        $this->conn = $db->getConnection();
    }
    // La méthode createGens est utilisée pour créer un nouvel utilisateur dans la base de données
    // Elle prend en paramètres le nom, le prénom, l'email et le mot de passe de l'utilisateur
    public function createGens($nom, $prenom, $email, $password) {
        // On prépare une requête SQL pour insérer un nouvel utilisateur dans la table gens
        // La requête utilise des paramètres nommés pour éviter les injections SQL
        $sql = "INSERT INTO $this->table (nom_gens, prenom_gens, email_gens, password_gens, dateinscr_gens)
                VALUES (:nom, :prenom, :email, :password, NOW())";
        // On prépare la requête SQL avec la connexion PDO
        // La méthode prepare() prépare la requête SQL pour une exécution ultérieure
        $stmt = $this->conn->prepare($sql);
        //return $stmt->execute() exécute la requête préparée
        // La méthode execute() exécute la requête avec les paramètres fournis
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
    // La méthode authenticate est utilisée pour authentifier un utilisateur existant
    // Elle prend en paramètres l'email et le mot de passe de l'utilisateur
    public function authenticate($email, $password) {
        $sql = "SELECT * FROM $this->table WHERE email_gens = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // On vérifie si l'utilisateur existe et si le mot de passe est correct
        // La méthode password_verify() vérifie si le mot de passe fourni correspond au mot de passe haché
        if ($user && password_verify($password, $user['password_gens'])) {
            return $user;
        }
        // Si l'utilisateur n'existe pas ou si le mot de passe est incorrect, on retourne null
        // Cela permet de signaler que l'authentification a échoué
        return null;
    }
}
?>