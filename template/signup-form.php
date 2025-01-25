<main class="signup">
    <section>
        <h1>SignUp</h1>
        <?php if(isset($_SESSION["signupMsg"])): ?>
                <p><?php echo $_SESSION["signupMsg"]; ?></p>
        <?php unset($_SESSION["signupMsg"]); endif; ?>
        <form action="utils/api-signup.php" method="POST">
            <ul>
                <li>
                    <label for="nickname">Nickname:</label>
                    <input type="text" id="nickname" name="nickname" required/>
                </li>
                <li>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required/>
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required/>
                </li>
                <li>
                    <label for="checkpassword">Conferma password:</label>
                    <input type="password" id="checkpassword" name="checkpassword" required/>
                </li>
                <li>
                    <a href="index.php">Indietro</a>
                    <input type="submit" name="submit" value="Iscriviti" />
                </li>
            </ul>
        </form>
    </section>
</main>