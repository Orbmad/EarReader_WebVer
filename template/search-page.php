<main class="search">
    <section>

        <!-- <section class="filters">
            <form action="utils/api-search.php" method="GET">

                <input type="hidden" name="info" value="filters" />

                <select name="type" id="search-select" title="Rierca">
                    <option value="title">Titolo</option>
                    <option value="author">Autore</option>
                    <option value="genre">Genere</option>
                    <option value="group">Gruppo</option>
                </select>

                <input type="text" name="search" placeholder="Cerca..." value="" />

                <button type="submit">Cerca</button>

            </form>
        </section> -->

        <section class="texts">
            <ul>
                <!--Start foreach-->
                <?php foreach ($params["texts"] as $text): ?>
                    <li>
                        <a href="text.php?title=<?php echo $text["Titolo"]; ?>&code=<?php echo $text["Codice"]; ?>"><?php echo $text["Titolo"]; ?></a>
                        <p>Autore: <?php echo $db->getAuthorsOfText($text["Codice"])[0]["Nome"]; ?></p>
                        <p>Genere: <?php echo $text["NomeGenere"]; ?></p>
                        <p><?php if ($text["Singolo"]) {
                                echo "Costo: " . $text["Costo"];
                            } else {
                                echo "Costo capitoli: " . $text["Costo"];
                            } ?></p>
                        <p>Voto: <?php echo sprintf("%1.1f", $text["Voto"]); ?>/5</p>
                    </li>
                    <!--End foreach-->
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- <section class="authors">
            <ul>
                <?php /*foreach ($params["authors"] as $author): ?>
                    <li>
                        <a href="#">Nome: <?php echo $author["Nome"]; ?> [<?php echo $author["Alias"] ?>]</a>
                        <p class="comments">Punteggio: <?php echo $author["Punteggio"]; ?>/5</p>
                    </li>
                <?php endforeach; */?>
            </ul>
        </section> -->

        <!-- <section class="groups">
            <ul>
                <?php /*foreach ($params["groups"] as $group): ?>
                    <li>
                        <a href="#">Nome gruppo: <?php echo $group["NomeGruppo"]; ?></a>
                    </li>
                <?php endforeach; */ ?>
            </ul>
        </section> -->

    </section>
</main>