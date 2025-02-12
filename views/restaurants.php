<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
    <script src="/assets/script.js"></script>
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
            <h2>Découvrez les meilleurs restaurants d'Orléans</h2>
            <p>Explorez, évaluez et partagez vos expériences culinaires grâce à notre site.</p>
        </section>
        <section class="top-restaurants">
            <form method="GET" action="/restaurants" class="filter-form">
                <div class="filter-container">
                    <h2 class="filter-title">Filtrer les Restaurants</h2>

                    <!-- Type de restaurant -->
                    <div class="dropdown">
                        <div class="dropdown-button">Type de restaurant</div>
                        <div class="checkbox-list">
                            <?php
                                foreach($types as $type){
                                    echo "<li class='checkbox-item'><label><input type='checkbox' name='type[]' value='{$type}' ".(isset($selected["type"]) ? (in_array($type, $selected["type"]) ? "checked" : "") : "").">".htmlspecialchars(str_replace("_"," ",ucfirst($type)))."</label></li>";
                                }
                            ?>
                        </div>
                    </div>

                    <!-- Type de cuisine -->
                    <div class="dropdown">
                        <div class="dropdown-button">Type de cuisine</div>
                        <div class="checkbox-list">
                            <?php
                                foreach($cuisines as $cuisine){
                                    echo "<li class='checkbox-item'><label><input type='checkbox' name='cuisine[]' value='{$cuisine}' ".(isset($selected["cuisine"]) ? (in_array($cuisine, $selected["cuisine"]) ? "checked" : "") : "").">".htmlspecialchars(str_replace("_"," ",ucfirst($cuisine)))."</label></li>";
                                }
                            ?>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="dropdown">
                        <div class="dropdown-button">Options</div>
                        <div class="checkbox-list">
                        <?php
                                foreach($options as $id => $nom){
                                    echo "<li class='checkbox-item'><label><input type='checkbox' name='option[]' value='{$id}' ".(isset($selected["option"]) ? (in_array($id, $selected["option"]) ? "checked" : "") : "").">".htmlspecialchars(str_replace("_"," ",ucfirst($nom)))."</label></li>";
                                }
                            ?>
                        </div>
                    </div>

                    <button class="filter-clear" onclick="clearFilters()">Enlever les filtres</button>
                    <button class="filter-submit">Rechercher</button>
                </div>

            </form>
            <div class="restaurant-list">
                <?php
                foreach ($restaurants as $restau) {
                    echo $restau->renderCard();
                }
                ?>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 IUTables'O. Tous droits réservés.</p>
    </footer>
</body>

</html>