<main class="shop">
    <section>
        <h1>Acquista Ear-Coins</h1>
        <h2>1,00 € = 100 EC</h2>
        <table>
            <caption>Tabella sconti</caption>
            <thead>
                <tr>
                    <th scope="col">Quantità</th>
                    <th scope="col">Sconto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($params["table"] as $trow): ?>
                    <tr>
                        <td><?php echo $trow["QuantitaMinima"]; ?> EC</td>
                        <td><?php echo $trow["Percentuale"]; ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <section class="payment">
            <h1>Pagamento</h1>
            <form action="../utils/buyCurrency.php" method="POST">

                <label for="qt">Seleziona quantità:</label>
                <input type="number" id="qt" required/>

                <label for="perc">Sconto:</label>
                <input type="text" id="perc" name="perc" value="0%" disabled/>

                <label for="prize">Costo:</label>
                <input type="text" id="prize" name="prize" value="0.00 €" disabled/>
                                        
                <label for="method-select">Metodo:</label>
                <select name="method" id="method-select" required>
                    <option value="" disabled selected>Metodo</option>
                    <?php foreach ($params["payments"] as $method): ?>
                        <option value="<?php echo $method["NomeMetodo"]?>"><?php echo $method["NomeMetodo"]?></option>
                    <?php endforeach; ?>
                </select>

                <section class="payment-data"></section>

                <button type="submit">Conferma</button>
            </form>
        </section>
    </section>
</main>