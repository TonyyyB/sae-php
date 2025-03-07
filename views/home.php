<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - IUTables'O</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/card.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
    <main class="main-content">
        <section class="intro">
            <h2>Découvrez les meilleurs restaurants d'Orléans</h2>
            <p>Explorez, évaluez et partagez vos expériences culinaires grâce à notre site.</p>
            <a href="/restaurants" class="button">Consulter tous les restaurants</a>
        </section>
        <section class="top-restaurants">
            <h2>Restaurants les mieux notés</h2>
            <div class="restaurant-list">
                <?php
                foreach ($restaurants as $restau) {
                    echo $restau->renderCard();
                }
                ?>
            </div>
        </section>
    </main>
    <?php require_once "static/footer.php";?>
</body>

</html>