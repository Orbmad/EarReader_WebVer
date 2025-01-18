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

    </header>

    <nav>

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