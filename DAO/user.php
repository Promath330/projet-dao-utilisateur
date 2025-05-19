<?php
//class User pour la connexion à la base de données
// Cette classe gère la connexion à la base de données MySQL
// et fournit une méthode pour obtenir une instance de la connexion PDO.
class User {
    // Propriétés de la classe
    // Ces propriétés contiennent les informations de connexion à la base de données
    // et la connexion PDO elle-même.
    // Ces propriétés sont privées pour encapsuler les détails de la connexion
    // et éviter les accès directs depuis l'extérieur de la classe.
    // Ces propriétés sont initialisées avec des valeurs par défaut.
    private $host = 'localhost';
    private $db_name = 'utilisateur';
    private $username = 'root';
    private $password = '';
    private $conn;
    // Constructeur de la classe
    // Le constructeur est vide car nous n'avons pas besoin d'initialiser
    public function getConnection() {
        // La méthode getConnection() est utilisée pour obtenir une instance de la connexion PDO.
        // Si la connexion n'existe pas encore, elle est créée.
        if ($this->conn === null) {
            try {
                // Création d'une nouvelle instance de PDO pour se connecter à la base de données
                // Le DSN (Data Source Name) spécifie le type de base de données, l'hôte et le nom de la base de données.
                // Le jeu de caractères est défini sur UTF-8 pour gérer les caractères spéciaux.
                // La méthode setAttribute() est utilisée pour définir le mode de gestion des erreurs de PDO.
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            // Si une exception PDO est levée, elle est capturée ici.
            // La méthode getMessage() de l'exception est utilisée pour obtenir le message d'erreur.
            // La méthode die() est utilisée pour afficher le message d'erreur et arrêter l'exécution du script.
            catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        // La connexion PDO est retournée.
        // Cela permet d'utiliser la même connexion dans toute l'application
        // sans avoir à créer une nouvelle instance à chaque fois.
        // Cela améliore les performances et réduit la charge sur le serveur de base de données.
        return $this->conn;
    }
}
?>