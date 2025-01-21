<!DOCTYPE html>
<html lang="it">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $params["title"]; ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="./css/style.css" />
</head>

<body>

    <header>
        <h1>Ear-Reader</h1>
    </header>

    <nav>
        <section class="search">
            <label for="fastSearch">Ricerca rapida</label>
            <section class="search-text">
                <input type="text" id="fastSearch" name="fastSearch" placeholder="Cerca testi..."
                    value="<?php if(isset($params["search"])){echo($params["search"]);}?>"
                />
            </section>
            <input class="searchbar-icon search-button" type="image" src="upload/search-icon.png" alt="Submit search" />
        </section>
        
        <section class="user-currency">
            <a href="#">
                <img src="upload/elf-ear.png" alt="">
                <p><?php echo getUserCurrency() ?></p>
            </a>
        </section>
        
        <section class="nav-buttons">
            <a class="home-button" href="home.php">
                <img src="upload/home.png" alt="home">
            </a>
            <a class="library-button">
                <img src="upload/book.png" alt="libreria">
            </a>
            <a class="logout-button" href="utils/api-logout.php">
                <img src="upload/logout.png" alt="disconnetti">
            </a>
        </section>
    </nav>

    <?php
    if (isset($params["main"])) {
        require($params["main"]);
    }
    ?>

    <footer>
        <h1>Autore</h1>
        <a href="https://github.com/Orbmad">
            <img src="upload/github.png" alt="github icon" />
            <p>Profilo Github</p>
        </a>
        <a href="#">manuele.dambrosio@studio.unibo.it</a>
    </footer>

    <!--Inserimento javascript-->
    <?php
    if (isset($params["js"])):
        foreach ($params["js"] as $script): ?>
            <script src="<?php echo $script; ?>"></script>
    <?php endforeach;
    endif; ?>
</body>

</html>