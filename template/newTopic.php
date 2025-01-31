<main class="newTopic">
    <section>
        <h1>Nuova discussione</h1>
        <form action="utils/api-newTopic.php" method="GET">
            <ul>
                <li>
                    <label for="topic-title">Titolo:</label>
                    <input type="text" id="topic-title" name="title" required/>
                </li>
                <li>
                    <label for="topic-arg">Argomento:</label>
                    <input type="text" id="topic-arg" name="arg" required/>
                </li>
                <li>
                    <label for="topic-text">Discussione:</label>
                    <input type="text" name="text" id="topic-text" />
                </li>
                <li>
                    <a href="./home.php">Indietro</a>
                    <input type="submit" value="Pubblica" />
                </li>
            </ul>
        </form>
    </section>
</main>