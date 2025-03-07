<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$restau->getName()?> - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="stylesheet" href="/assets/global.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
<main class="main-content">
    <section class="restaurant-detail">
            <?php
                echo $restau->renderDetail(isset($_SESSION["user"]) && !empty($_SESSION["user"]));
            ?>
    </section>
</main>
<?php require_once "static/footer.php";?>
</body>

</html>