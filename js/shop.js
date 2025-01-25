document.addEventListener("DOMContentLoaded", function () {
    //Payment Method selection
    const paymentSelect = document.getElementById("method-select");
    const paymentDataSection = document.querySelector(".payment-data");

    // Updates payment section when method is selected
    function updatePaymentFields() {
        const selectedMethod = paymentSelect.value.toLowerCase();
        console.log(selectedMethod + "--check");

        if (selectedMethod == "carta") {
            paymentDataSection.innerHTML = 
            `<label for="card-number">Numero Carta:</label>
            <input type="text" id="card-number" name="card-number" required placeholder="0000 0000 0000 0000" pattern="\\d{16}"/>
            
            <label for="card-expiry">Data di scadenza:</label>
            <input type="month" id="card-expiry" name="card-expiry" required/>
            
            <label for="card-cvc">CVC:</label>
            <input type="text" id="card-cvc" name="card-cvc" required placeholder="123" pattern="\\d{3}"/>`;

        } else if (selectedMethod == "paypal") {
            paymentDataSection.innerHTML =
            `
            <label for="paypal-email">Email PayPal:</label>
            <input type="email" id="paypal-email" name="paypal-email" required placeholder="Inserisci la tua email PayPal"/>
            `;

        }
    }

    paymentSelect.addEventListener("change", updatePaymentFields);
    updatePaymentFields();


    // Discount selection
    function findDiscount() {
        //Find discount
        const inputQuant = document.getElementById("qt").value;
        const rows = document.querySelectorAll("table tbody tr");
        const inputPerc = document.getElementById("perc");
        const inputPrize = document.getElementById("prize");

        let sconto = "0%";
        let perc = 0;
        let prize = 0;

        rows.forEach(row => {
            const quantitaTabella = parseInt(row.cells[0].innerText.replace(" EC", "").trim(), 10);
            const scontoTabella = row.cells[1].innerText.trim();

            if (inputQuant >= quantitaTabella) {
                sconto = scontoTabella;
            }
        });

        inputPerc.value = sconto;

        perc = parseInt(sconto.replace("%", ""));

        prize = (parseFloat(inputQuant) / 100) * (1 - parseFloat(perc) / 100);
        
        inputPrize.value = prize + " €";
    }

    document.getElementById("qt").addEventListener("input", findDiscount);

});
