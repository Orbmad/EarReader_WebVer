<main class="home">

    <section class="suggested">
        <h1>Testi consigliati</h1>
        <!--In case there are no texts-->
        <?php if(count($params["suggested"]) <= 0) {echo "<p>Dopo aver scritto qualche recensione i testi consigliati appariranno qui...</p>";}?>

        <?php
            $count = 0;
            $limit = 7;
        ?>
        <ul>
            <!--Start foreach-->
            <?php foreach ($params["suggested"] as $text): ?>
                <?php if ($count++ > $limit) break; ?>
                <li>
                    <a href="text.php?title=<?php echo $text["Titolo"]; ?>&code=<?php echo $text["Codice"]; ?>"><?php echo $text["Titolo"]; ?></a>
                    <p><?php if ($text["Singolo"]) {echo "Costo: ".$text["Costo"];} else {echo "Costo capitoli: ".$text["Costo"];} ?></p>
                    <p>Voto: <?php echo sprintf("%1.1f", $text["Voto"]); ?>/5</p>
                </li>
            <!--End foreach-->
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="bests">
        <h1>Testi più votati</h1>
        <?php
            $count = 0;
            $limit = 7;
        ?>
        <ul>
            <!--Start foreach-->
            <?php foreach ($params["bests"] as $text): ?>
                <?php if ($count++ > $limit) break; ?>
                <li>
                    <a href="text.php?title=<?php echo $text["Titolo"]; ?>&code=<?php echo $text["Codice"]; ?>"><?php echo $text["Titolo"]; ?></a>
                    <p><?php if ($text["Singolo"]) {echo "Costo: ". $text["Costo"];} else {echo "Costo capitoli: ".$text["Costo"];} ?></p>
                    <p>Voto: <?php echo sprintf("%1.1f", $text["Voto"]); ?>/5</p>
                </li>
            <!--End foreach-->
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="authors">
        <h1>Autori più votati</h1>
        <?php
            $count = 0;
            $limit = 7;
        ?>
        <ul>
            <!--Start foreach-->
            <?php foreach ($params["authors"] as $author): ?>
                <?php if ($count++ > $limit) break; ?>
                <li>
                    <a href="#">Nome: <?php echo $author["Nome"]; ?> [<?php echo $author["Alias"] ?>]</a>
                    <p class="comments">Punteggio: <?php echo sprintf("%1.2f", $author["Punteggio"]); ?>/5</p>
                </li>
            <!--End foreach-->
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="topics">
        <h1>Discussioni più partecipate</h1>
        <?php
            $count = 0;
            $limit = 7;
        ?>
        <ul>
            <!--Start foreach-->
            <?php foreach ($params["topics"] as $topic): ?>
                <?php if ($count++ > $limit) break; ?>
                <li>
                    <p class="author">Autore: <?php echo $db->getUserName($topic["Email"])["Nickname"]; ?></p>
                    <a href="topic.php?title=<?php echo $topic["Titolo"]; ?>&author=<?php echo $topic["Email"]; ?>"><?php echo $topic["Titolo"]; ?></a>
                    <p class="comments"><?php echo $topic["NumeroCommenti"]; ?> commenti</p>
                </li>
            <!--End foreach-->
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="groups">
        <h1>Collezioni</h1>
        <ul>
            <?php foreach ($params["groups"] as $group): ?>
                <li>
                    <a>
                        <h2><?php echo $group["NomeGruppo"]; ?></h2>
                        <p><?php echo $group["Descrizione"]; ?></p>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>