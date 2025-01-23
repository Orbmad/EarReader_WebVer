<main class="library">
    <section>
        <h1>Libreria di '<?php echo $_SESSION["user"]["Nickname"] ?>'</h1>
        <section>
            <ul>
                <?php foreach ($params["texts"] as $text): ?>
                    <li>
                        <a href="text.php?title=<?php echo $text["Titolo"]; ?>&code=<?php echo $text["Codice"]; ?>"><?php echo $text["Titolo"]; ?></a>
                        <p><?php if ($text["Singolo"]) {
                                echo "Testo completo";
                            } else {
                                echo "Capitoli: " . $text["NumeroCapitoli"];
                            } ?></p>
                        <p>Voto: <?php echo sprintf("%1.1f", $text["Voto"]); ?>/5</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </section>
</main>