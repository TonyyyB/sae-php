<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$restau->getName()?> - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
    <header class="header">
        <h1 class="header-title">Bienvenue sur IUTables'O</h1>
        <nav class="nav">
            <ul class="nav-list">
                <li><a href="/">Accueil</a></li>
                <li><a href="/restaurants">Restaurants</a></li>
                <li><a href="/login">Connexion</a></li>
                <li><a href="/register">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main class="main-content">
        <section class="intro">
            <h1>Voici le détail du restaurant <?=$restau->getName()?></h1>
        </section>
        <section class="restaurant-detail">
                <?php
                    echo $restau->renderDetail(isset($_SESSION["user"]) && !empty($_SESSION["user"]));
                ?>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 IUTables'O. Tous droits réservés.</p>
    </footer>
</body>

</html>