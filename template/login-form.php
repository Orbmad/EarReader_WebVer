<main class="login">
    <section>
        <h1>Login</h1>
        <?php if(isset($_SESSION["loginMsg"])): ?>
                <p><?php echo $_SESSION["loginMsg"]; ?></p>
        <?php unset($_SESSION["loginMsg"]); endif; ?>
        <form action="utils/api-login.php" method="POST">
            <ul>
                <li>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email"/>
                </li>
                <li>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"/>
                </li>
                <li>
                    <input type="submit" name="signup" value="signup" />
                    <input type="submit" name="submit" value="Accedi" />
                </li>
            </ul>
        </form>
    </section>
</main>