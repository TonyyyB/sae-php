<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$user->getNom()?> - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
    <main class="main-content">
        <section class="user-detail">
                <?php
                    echo $user->render(isset($_SESSION["user"]) && !empty($_SESSION["user"]));
                ?>
        </section>
    </main>
    <?php require_once "static/footer.php";?>
</body>

</html>