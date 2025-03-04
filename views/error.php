<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
    <main class="main-content">
        <section class="error">
            <?php
            if (isset($erreur)) {
                echo "<h1>Une erreur s'est produite : " . $erreur . "</h1>";
            } else {
                echo "<h1>Désolé, la page que vous avez demandé n'a pas été trouvée :(</h1>";
            }
            ?>
        </section>
    </main>
    <?php require_once "static/footer.php";?>
</body>

</html>