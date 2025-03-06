<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants - IUTables'O</title>
    <link rel="stylesheet" href="/assets/restaurants.css">
    <link rel="stylesheet" href="/assets/global.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
    <script src="/assets/script.js"></script>
</head>

<body>
<?php require_once "static/header.php";?>
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
                        <!-- <span> ★ </span> -->
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
    <?php require_once "static/footer.php";?>
</body>

</html>