<main class="topic">
    <!-- ?php var_dump($params); ? -->
    <section>
        <h1><?php echo $params["topic"]["Titolo"]; ?></h1>
        <section class="subtitle">
            <h2>Autore: <?php echo $db->getUserName($params["topic"]["Email"])["Nickname"]; ?></h2>
            <h3>Argomento: <?php echo $params["topic"]["Argomento"]; ?></h3>
        </section>
        <p class="text"><?php echo $params["topic"]["Stringa"]; ?></p>
        <section>
            <ul>
                <?php foreach ($params["comments"] as $comment): ?>
                    <li>
                        <h4><?php echo $db->getUserName($comment["EmailUtente"])["Nickname"]; ?></h4>
                        <p><?php echo $comment["Stringa"]; ?></p>
                        <section class="likes">
                            <?php $get = "&author=" . $params["topic"]["Email"] . "&title=" . $params["topic"]["Titolo"] . "&code=" . $comment["Codice"]; ?>
                            <a href="utils/api-addLike.php?like=up<?php echo $get; ?>">
                                <img src="upload/like.png" alt="like">
                            </a>
                            <p><?php echo $comment["likes"]; ?></p>
                            <a href="utils/api-addLike.php?like=down<?php echo $get; ?>">
                                <img src="upload/dislike.png" alt="dislike">
                            </a>
                            <p><?php echo $comment["dislikes"]; ?></p>
                        </section>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section class="new-comment">
            <button onclick="editComment()">Aggiungi commento</button>
        </section>

        <section class="edit hidden">
            <form action="utils/api-addComment.php" method="GET">
                <label for="string">Inserisci commento:</label>
                <input type="text" id="string" name="string" />
                <input type="submit" id="submit" value="Conferma" />

                <input type="hidden" name="title" value="<?php echo $params["topic"]["Titolo"]; ?>">
                <input type="hidden" name="author" value="<?php echo $params["topic"]["Email"]; ?>">
            </form>
        </section>
    </section>
</main>