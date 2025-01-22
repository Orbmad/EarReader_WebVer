<main class="text-page">
    <section class="main-section">

        <section class="header">
            <h1><?php echo $params["text"]["Titolo"]; ?></h1>
            <p>Voto: <?php echo $params["text"]["Voto"]; ?>/5</p>
        </section>

        <ul class="authors-list">
            <li>Autore/i:</li>
            <?php foreach ($params["authors"] as $author): ?>
                <li>
                    <?php echo $author["Nome"]; ?>
                </li>
            <?php endforeach; ?>
        </ul>


        <p class="genre">Genere: <?php echo $params["text"]["NomeGenere"]; ?></p>

        <section class="chapters">
            <h1>Capitoli:</h1>
            <ul>
                <?php foreach ($params["chapters"] as $chapter): ?>
                    <li>
                        <p><?php echo $chapter["Numero"]; ?></p>
                        <p><?php echo $chapter["Titolo"]; ?></p>
                        <!--Acquista capitolo e leggi se acquistato-->
                        <a href="#">Ottieni</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="reviews">
            <h1>Recensioni</h1>
            <ul>
                <?php foreach ($params["reviews"] as $review): ?>
                    <li>
                        <h2><?php echo $db->getUserName($review["Email"])["Nickname"]; ?></h2>

                        <h3><?php echo $review["Titolo"]; ?></h3>
                        <h4>Voto: <?php echo $review["Voto"]; ?>/5</h4>

                        <p class="review-content">
                            <?php echo $review["Stringa"]; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <section class="new-review <?php if (!$db->isReviewPossible($_SESSION["user"]["Email"], $params["text"]["Codice"])) {
                                            echo "hidden";
                                        } ?>">
                <button type="button" onclick="addReview()">Aggiungi recensione</button>
                <form class="hidden" action="utils/api-addReview.php" method="GET">

                    <input type="hidden" name="Email" value="<?php echo $_SESSION["user"]["Email"]; ?>" />
                    <input type="hidden" name="Codice" value="<?php echo $params["text"]["Codice"]; ?>" />

                    <!--Redirect params-->
                    <input type="hidden" name="title" value="<?php echo $params["text"]["Titolo"]; ?>" />
                    <input type="hidden" name="code" value="<?php echo $params["text"]["Codice"]; ?>" />

                    <label for="voto">Voto (1-5):</label>
                    <input type="number" id="voto" name="Voto" min="1" max="5" required />

                    <label for="titolo">Titolo:</label>
                    <input type="text" id="titolo" name="Titolo" required />

                    <label for="stringa">Recensione:</label>
                    <textarea id="stringa" name="Stringa" maxlength="800"></textarea>

                    <input type="submit" value="Pubblica" />
                </form>
            </section>

        </section>

        <section class="tags">
            <h2>Tag:</h2>
            <p><?php foreach ($params["tags"] as $tag) {
                    echo $tag["Nome"] . ", ";
                } ?></p>
        </section>

    </section>
</main>