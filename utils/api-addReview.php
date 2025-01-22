<?php
require_once '../bootstrap.php';

if (isset($_GET["Titolo"])) {
    $db->addReview($_GET["Email"], $_GET["Codice"], $_GET["Voto"], $_GET["Titolo"], $_GET["Stringa"]);
    $authors = $db->getAuthorsOfText($_GET["Codice"]);
    foreach($authors as $author) {
        $db->updateAuthorRate($author["CodiceAutore"]);
    }
}

$string = "Location: ../text.php?title=" . $_GET["title"] . "&code=" . $_GET["code"];
header($string);
exit;
?>
