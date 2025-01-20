<?php
class Database
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    /**
     * Checks if a user exists and return its data.
     */
    public function checkLogin($email, $password) {
        $query = "SELECT Email, Nickname, EarCoins FROM Utenti WHERE Email = ? AND Password_hash = SHA2(?, 256)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Creates a new user in the database.
     */
    public function newUser($nickname, $email, $password) {
        $query = "INSERT INTO Utenti (Email, Nickname, Password_hash) VALUES (?, ?, SHA2(?, 256))";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sss', $email, $nickname, $password);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }
}
