<main class="text-page">
    <section class="main-section">
        <section class="header">
            <h1><?php echo $params["text"]["Titolo"]; ?></h1>
            <p>Voto: <?php echo $params["text"]["Voto"]; ?>/5</p>
        </section>

        <ul class="authors-list"><li>Autore/i:</li>
            <?php foreach($params["authors"] as $author): ?>
                <li>
                    <?php echo $author["Nome"]; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        

        <p class="genre">Genere: <?php echo $params["text"]["NomeGenere"]; ?></p>

        <section class="chapters">
            <h1>Capitoli:</h1>
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
                        <h2><?php echo $db->getUserName($review["Email"])["Nickname"]; ?></h2>
                        
                        <h3><?php echo $review["Titolo"]; ?></h3>
                        <h4>Voto: <?php echo $review["Voto"]; ?>/5</h4>
                        
                        <p class="review-content">
                            <?php echo $review["Stringa"]; ?>
                        </p>
                    </li>
                <?php endforeach; ?>
            </ul>
            <section class="new-review">
                <!--Inserisci button recensione se l'utente può scriverla-->
            </section>
        </section>

        <section class="tags">
            <h2>Tag:</h2>
            <p><?php foreach($params["tags"] as $tag) {echo $tag["Nome"].", "; } ?></p>
        </section>

    </section>
</main>