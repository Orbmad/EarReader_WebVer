<main class="search">
    <section>

        <section class="filters">
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
        </section>

        <?php if (isset($params["texts"])): ?>
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
        <?php endif; ?>

        <?php if (isset($params["authors"])): ?>
            <section class="authors">
                <ul>
                    <?php foreach ($params["authors"] as $author): ?>
                        <li>
                            <a href="search.php?info=search-bar&type=author&search=<?php echo $author["Nome"]; ?>">Nome: <?php echo $author["Nome"]; ?> [<?php echo $author["Alias"] ?>]</a>
                            <p class="comments">Punteggio: <?php echo $author["Punteggio"]; ?>/5</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (isset($params["groups"])): ?>
            <section class="groups">
                <ul>
                    <?php foreach ($params["groups"] as $group): ?>
                        <li>
                            <a href="search.php?info=search-bar&type=group&search=<?php echo $group["NomeGruppo"]; ?>">Nome gruppo: <?php echo $group["NomeGruppo"]; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <?php if (isset($params["topics"])): ?>
            <section class="topics">
                <ul>
                    <?php foreach ($params["topics"] as $topic): ?>
                        <li>
                            <p class="author">Autore: <?php echo $db->getUserName($topic["Email"])["Nickname"]; ?></p>
                            <a href="topic.php?title=<?php echo $topic["Titolo"]; ?>&author=<?php echo $topic["Email"]; ?>"><?php echo $topic["Titolo"]; ?></a>
                            <p class="comments"><?php echo $topic["NumeroCommenti"]; ?> commenti</p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

    </section>
</main>