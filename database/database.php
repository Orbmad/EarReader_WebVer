<?php
class Database
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port) {
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

        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    public function getUserName($email) {
        $stmt = $this->db->prepare("SELECT Nickname FROM Utenti WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC)[0];
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
                JOIN Utenti U ON U.Email = A.Email
                WHERE U.Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns chapter data.
     */
    public function getChapter($textCode, $chapterNumber) {
        $query = "SELECT * FROM Capitoli WHERE CodiceTesto=? AND Numero=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $textCode, $chapterNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the user currency
     */
    public function getUserCurrency($email) {
        $query = "SELECT EarCoins
                FROM Utenti
                WHERE Email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return (int)$result->fetch_assoc()["EarCoins"];
    }

    /**
     * Adds a chapter to the user library. [OP02]
     */
    public function buyChapter($email, $textCode, $chapterNumber, $chapterCost) {
        if (!$this->removeCurrencyIfPossible($email, $chapterCost, $this->getUserCurrency($email))) {
            return false;
        }
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

    public function isChapterPossesed($email, $textCode, $chapterNumber) {
        $query = "SELECT U.Email
                FROM Utenti U
                JOIN AcquistiCap A ON A.Email = U.Email
                JOIN Capitoli C ON C.codiceTesto = A.CodiceTesto AND C.Numero = A.Numero
                WHERE U.Email = ?
                AND C.CodiceTesto = ?
                AND C.Numero = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sii', $email, $textCode, $chapterNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        return count($result->fetch_all()) > 0;
    }

    private function removeCurrencyIfPossible($email, $currency, $userCurrency) {
        if ($userCurrency == null) {
            return false;
        } else if ($currency > $userCurrency) {
            return false;
        }
        $query = "UPDATE Utenti
                SET EarCoins = EarCoins - ?
                WHERE Email = ?";
        try {
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('is', $currency, $email);
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
            $stmt->bind_param('ss', $textCode, $textCode);
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
            $stmt->bind_param('ii', $authorCode, $authorCode);
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

    /**
     * Returns a text.
     */
    public function getText($textCode) {
        $query = "SELECT * FROM Testi WHERE Codice = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC)[0];
    }

    /**
     * Returns all the chapters of a text.
     */
    public function getChaptersOfText($textCode) {
        $query = "SELECT C.CodiceTesto, C.Numero, C.PercorsoCapitolo, C.Titolo
                FROM Capitoli C
                JOIN Testi T ON T.Codice = C.CodiceTesto
                WHERE T.Codice = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all the reviews of a text
     */
    public function getReviewsOfText($textCode) {
        $query = "SELECT * FROM Recensioni WHERE COdiceTesto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all the tags of a text.
     */
    public function getTagsOfText($textCode) {
        $query = "SELECT Nome
                FROM Tag A
                JOIN Contiene C ON A.Codice = C.CodiceTag
                JOIN Testi T ON C.CodiceTesto = T.Codice
                WHERE T.Codice = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the authors of a text.
     */
    public function getAuthorsOfText($textCode) {
        $query = "SELECT A.*
                FROM Autori A
                JOIN Scritture S ON A.CodiceAutore = S.CodiceAutore
                JOIN Testi T ON T.Codice = S.CodiceTesto
                WHERE T.Codice = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $textCode);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
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
    public function getTopic($authorEmail, $title) {
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

    private function getLikesOfComment($commentEmail, $title, $code) {
        $query = "SELECT MiPiace FROM Valutazioni
                WHERE Email = ?
                AND Titolo = ?
                AND Codice = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $commentEmail, $title, $code);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all();
    }

    /**
     * Returns all the comments of a topic.
     */
    public function getCommentsOfTopic($authorEmail, $title) {
        $query = "SELECT * FROM Commenti
                WHERE Email = ?
                AND Titolo = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $authorEmail, $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($comments as &$comment) {
            $res = $this->getLikesOfComment($comment["Email"], $comment["Titolo"], $comment["Codice"]);
            $likes = 0;
            $dislikes = 0;
            foreach ($res as $r) {
                if ($r == true) {
                    $likes++;
                } else {
                    $dislikes++;
                }
            }
            $comment["likes"] = $likes;
            $comment["dislikes"] = $dislikes;
        }

        return $comments;
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
        $query = "SELECT *
                FROM Autori
                ORDER BY Punteggio DESC";
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
        $query = "SELECT DISTINCT T.Codice, T.Titolo, T.Singolo, T.Percorso, T.Costo, T.Voto, T.NomeGenere
                FROM Testi T
                JOIN Contiene C ON T.Codice = C.CodiceTesto
                JOIN Tag TA ON TA.Codice = C.CodiceTag
                WHERE TA.Codice IN (
                    SELECT TA1.Codice
                    FROM Tag TA1
                    JOIN Contiene C1 ON C1.CodiceTag = TA1.Codice
                    JOIN Testi T2 ON T2.Codice = C1.CodiceTesto
                    WHERE T2.Codice IN (
                        SELECT T3.Codice
                        FROM Testi T3
                        JOIN Recensioni R ON T3.Codice = R.CodiceTesto
                        WHERE R.Email = ?
                        ORDER BY R.Voto DESC
                    )
                )
                LIMIT 10";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //SEARCH QUERIES

    public function searchTextsByTitleLike($search) {
        $search = $search . "%";
        $query = "SELECT *
                FROM Testi
                WHERE LOWER(Titolo) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchTextsByAuthorLike($search) {
        $search = $search . "%";
        $query = "SELECT T.Codice, T.Titolo, T.Singolo, T.Percorso, T.Costo, T.Voto, T.NomeGenere
                FROM Testi T
                JOIN Scritture S ON T.Codice = S.CodiceTesto
                JOIN Autori A ON A.CodiceAutore = S.CodiceAutore
                WHERE LOWER(A.Nome) LIKE LOWER(?)
                OR LOWER(A.Alias) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchTextsByGenreLike($search) {
        $search = $search . "%";
        $query = "SELECT *
                FROM Testi T
                WHERE LOWER(T.NomeGenere) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchTextByGroupLike($search) {
        $search = $search . "%";
        $query = "SELECT T.Codice, T.Titolo, T.Singolo, T.Percorso, T.Costo, T.Voto, T.NomeGenere
                FROM Testi T
                JOIN Appartenenze A ON T.Codice = A.CodiceTesto
                JOIN Gruppi G ON G.NomeGruppo = A.NomeGruppo
                WHERE LOWER(G.NomeGruppo) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllTexts() {
        $query = "SELECT T.Codice, T.Titolo, T.Singolo, T.Percorso, T.Costo, T.Voto, T.NomeGenere
                FROM Testi T
                JOIN Appartenenze A ON T.Codice = A.CodiceTesto
                JOIN Gruppi G ON G.NomeGruppo = A.NomeGruppo
                WHERE LOWER(G.NomeGruppo) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchAuthorLike($search) {
        $search = $search . "%";
        $query = "SELECT *
                FROM Autori
                WHERE LOWER(Nome) LIKE LOWER(?)
                OR LOWER(Alias) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchTopicLike($search) {
        $search = $search . "%";
        $query = "SELECT *
                FROM Discussioni
                WHERE LOWER(Titolo) LIKE LOWER(?)
                OR LOWER(Argomento) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function searchGroupsLike($search) {
        $search = $search . "%";
        $query = "SELECT *
                FROM Gruppi
                WHERE LOWER(NomeGruppo) LIKE LOWER(?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $search);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //SHOP QUERIES

    public function getDiscountTable() {
        $query = "SELECT * FROM Sconti";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPaymentMethods() {
        $query = "SELECT * FROM Metodi";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
