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
        <!--Da inserire conteggio valuta-->
        <section class="nav-buttons">
            <button class="home-button">
                <img src="upload/home.png" alt="home">
            </button>
            <button class="library-button">
                <img src="upload/book.png" alt="libreria">
            </button>
            <button class="logout-button">
                <img src="upload/logout.png" alt="disconnetti">
            </button>
        </section>
    </nav>

    <?php
    if (isset($templateParams["main"])) {
        require($templateParams["main"]);
    }
    ?>

    <footer>

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