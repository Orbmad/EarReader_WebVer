<main class="text-page">
    <section>
        <section>
            <h1><?php echo $params["text"]["Titolo"]; ?></h1>
            <p>Voto: <?php echo $params["text"]["Voto"]; ?></p>
        </section>

        <p>Autore/i: 
            <ul>
                <?php foreach($params["authors"] as $author): ?>
                    <li>
                        <?php echo $author["Nome"]." [".$author["Alias"]."]"; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </p>

        <p>Genere: <?php echo $params["text"]["NomeGenere"]; ?></p>

        <section class="chapters">
            <ul>
                <?php foreach($params["chapters"] as $chapter): ?>
                    <li>
                        <p><?php echo $chapter["Numero"]; ?></p>
                        <p><?php echo $chapter["Titolo"]; ?></p>
                        <!--Acquista capitolo-->
                        <a href="#">Ottieni</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="reviews">
            <h1>Recensioni</h1>
            <ul>
                <?php foreach($params["reviews"] as $review): ?>
                    <li>
                        <h2><?php echo $db->getUserName($review["Email"]); ?></h2>
                        <p>
                            <h3><?php echo $review["Titolo"]; ?></h3>
                            <h4>Voto: <?php echo $review["Voto"]; ?>/5</h4>
                        </p>
                        <p class="review-content">
                            <?php echo $review["Stringa"]; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section class="tags">
            <h2>Tag:</h2>
            <p><?php foreach($params["tags"] as $tag) {echo $tag["Nome"].", "; } ?></p>
        </section>

    </section>
</main>