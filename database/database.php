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
     * Creates a new user in the database. [OP01]
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

    /**
     * Returns all the texts acquired by the user.
     */
    public function getUserLibrary($email) {
        $query = "SELECT 
                T.Codice,
                T.Data_ora,
                T.Titolo,
                T.Singolo,
                T.Percorso,
                T.Costo,
                T.Voto,
                T.NomeGenere
                FROM Testi T
                JOIN AcquistiCap A ON A.CodiceTesto = T.Codice
                JOIN Utenti U ON U.Email = A.Email";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns chapter data.
     */
    public function getChapter($textCode, $chapterNumber) {
        $query = "SELECT Costo FROM Testi WHERE CodiceTesto=? AND Numero=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $textCode, $chapterNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Adds a chapter to the user library. [OP02]
     */
    public function buyChapter($email, $textCode, $chapterNumber) {
        $query = "INSERT INTO AcquistiCap (Numero, CodiceTesto, Email) VALUES (?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('iis', $chapterNumber, $textCode, $email);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Updates the text ranking
     */
    public function updateTextRate($textCode) {
        $query = "UPDATE Testi
                SET Voto = (
                    SELECT AVG(Voto)
                    FROM Recensioni
                    WHERE CodiceTesto = ?
                )
                WHERE Codice = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $textCode);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    public function getAuthors() {
        $query = "SELECT * FROM Autori";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Updates the author ranking
     */
    public function updateAuthorRate($authorCode) {
        $query = "UPDATE Autori
                SET Punteggio = (
                    SELECT AVG(Voto)
                    FROM Testi T
                    JOIN Scritture S ON T.Codice = S.CodiceTesto
                    JOIN Autori A ON A.CodiceAutore = S.CodiceAutore
                    WHERE A.CodiceAutore = ?
                )
                WHERE CodiceAutore = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $authorCode);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Adds a review. [OP03]
     */
    public function addReview($email, $textCode, $rate, $title, $text) {
        $query = "INSERT INTO Recensioni (Email, COdiceTesto, Voto, Titolo, Stringa)
                VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siiss', $email, $textCode, $rate, $title, $text);
            $stmt->execute();
            if ($this->updateTextRate($textCode)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException) {
            return false;
        }
    }

    private function countTextChapters($textCode) {
        $query = "SELECT COUNT(*) AS CapitoliTotali
                FROM Capitoli C
                WHERE C.CodiceTesto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['CapitoliTotali'];
    }

    private function countTextBoughtChapters($email, $textCode) {
        $query = "SELECT COUNT(*) AS CapitoliAcquistati
                FROM AcquistiCap AC
                WHERE AC.Email = ? AND AC.CodiceTesto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $email, $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc()['CapitoliAcquistati'];
    }

    /**
     * Returns true if the user has bought all the chapters of a text.
     */
    public function isReviewPossible($email, $textCode) {
        $totalChapters = $this->countTextChapters($textCode);
        $boughtChapters = $this->countTextBoughtChapters($email, $textCode);
        if ($totalChapters == 1) {
            return ($totalChapters === $boughtChapters);
        } else {
            return ($totalChapters === ($boughtChapters + 1));
        }
    }

    /**
     * Creates a new topic. [OP04]
     */
    public function newTopic($email, $title, $text, $topic) {
        $query = "INSERT INTO Discussioni (Email, Titolo, Stringa, Argomento)
                VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss', $email, $title, $text, $topic);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Returns all the topics.
     */
    public function getTopics() {
        $query = "SELECT * FROM Discussioni";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns a topic
     */
    private function getTopic($authorEmail, $title) {
        $query = "SELECT * FROM Discussioni
                WHERE Email = ?
                AND Titolo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $authorEmail, $title);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function incrementNumberOfComments($authorEmail, $title) {
        $query = "UPDATE Discussioni
                SET NumeroCommenti = NumeroCommenti + 1
                WHERE Email = ?
                AND Titolo = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $authorEmail, $title);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Adds a comment to a topic. [OP05]
     */
    public function addCommentToTopic($email, $text, $authorEmail, $title) {
        $query = "INSERT INTO Commenti (Email, Titolo, Stringa, EmailUtente)
                VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssss', $authorEmail, $title, $text, $email);
            $stmt->execute();
            return $this->incrementNumberOfComments($authorEmail, $title);
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Adds like or dislike to a comment
     */
    public function addLike($email, $authorEmail, $title, $code, $like) {
        $query = "INSERT INTO Valutazioni (EmailUtente, Email, Titolo, Codice, MiPiace)
                VALUES (?, ?, ?, ?, ?)";
        $like = $like ? 1 : 0;
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('sssii', $email, $authorEmail, $title, $code, $like);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Returns all payment methods.
     */
    public function getPaymentsMethods() {
        $query = "SELECT * FROM Metodi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns discounts.
     */
    public function getDiscounts() {
        $query = "SELECT * FROM Sconti";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Completes a payment. [OP06]
     */
    public function buyNewCurrency($email, $earCoins, $methodCode, $discountCode) {
        $query = "INSERT INTO Pagamenti (Email, EarCoins, CodiceMetodo, CodicePagamento)
                VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siii', $email, $earCoins, $methodCode, $discountCode);
            $stmt->execute();
            return true;
        } catch (PDOException) {
            return false;
        }
    }

    /**
     * Searches for a text by author. [OP07.1]
     */
    public function searchTextByAuthor($authorName) {
        $query = "SELECT *
                FROM Testi T
                JOIN Scritture S ON T.Codice = S.CodiceTesto
                JOIN Autori A ON S.CodiceAutore = A.CodiceAutore
                WHERE A.Nome = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $authorName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all the genres in the database.
     */
    public function getGenres() {
        $query = "SELECT *
                FROM Generi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Searches of a text by genre. [OP07.2]
     */
    public function searchTextByGenre($genre) {
        $query = "SELECT *
                FROM Testi
                WHERE NomeGenere = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $genre);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all groups.
     */
    public function getGroups() {
        $query = "SELECT *
                FROM Gruppi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Searches a text by its group. [OP07.3]
     */
    public function searchTextByGroup($group) {
        $query = "SELECT *
                FROM Testi T
                JOIN Appartenenze A ON T.Codice = A.CodiceTesto
                WHERE A.NomeGruppo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $group);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all texts ordered by rank. [OP08]
     */
    public function getTextRanking() {
        $query = "SELECT * FROM Testi
                ORDER BY Voto DESC, Titolo ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);   
    }

    /**
     * Returns authors ranking. [OP09]
     */
    public function getAuthorRanking() {
        $query = "SELECT 
            A.CodiceAutore, 
            A.Nome, 
            A.Alias, 
            COALESCE(AVG(T.Voto), 0) AS MediaVoti
            FROM Autori A
            JOIN Scritture S ON A.CodiceAutore = S.CodiceAutore
            JOIN Testi T ON S.CodiceTesto = T.Codice
            GROUP BY A.CodiceAutore, A.Nome, A.Alias
            ORDER BY MediaVoti DESC, A.Nome ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the topics ranking. [OP10]
     */
    public function getTopicRanking() {
        $query = "SELECT * FROM Discussioni
                ORDER BY NumeroCommenti DESC, Titolo ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }



    /**
     * Returns suggested texts. [OP11]
     */
    public function suggestedTexts($email) {
        $query = "SELECT DISTINCT *
                FROM Testi T
                JOIN Contiene C ON T.Codice = C.CodiceTesto
                JOIN Tag TA ON TA.Codice = C.CodiceTag
                WHERE TA.Codice IN (
                    SELECT DISTINCT TA1.Codice
                    FROM Tag TA1
                    JOIN Contiene C1 ON C1.CodiceTag = TA1.Codice
                    JOIN Testi T2 ON T2.Codice = C1.CodiceTesto
                    WHERE T2.Codice IN (
                        SELECT T3.Codice
                        FROM Testi T3
                        JOIN Recensioni R ON T3.Codice = R.CodiceTesto
                        WHERE R.Email = ?
                        ORDER BY R.Voto DESC
                        LIMIT 5
                    )
                )";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
