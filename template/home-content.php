<main class="home">
    <section class="suggested">
        <h1>Testi consigliati</h1>
    </section>
    <section class="bests">
        <h1>Testi più votati</h1>
    </section>
    <section class="authors">
        <h1>Autori più votati</h1>
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
</main>