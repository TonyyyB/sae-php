<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - IUTables'O</title>
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
            <h2>Découvrez les meilleurs restaurants d'Orléans</h2>
            <p>Explorez, évaluez et partagez vos expériences culinaires grâce à notre site.</p>
        </section>
        <section class="top-restaurants">
            <h2>Liste des restaurants</h2>
            <form>
                <div class="toggle-container" onclick="toggleContainer()">Afficher les listes</div>
                <div class="container" id="container">
                    <!-- Première liste -->
                    <div class="dropdown">
                        <div class="dropdown-button" onclick="toggleDropdown(this)">Liste 1</div>
                        <ul class="checkbox-list">
                            <li><label><input type="checkbox"> Option 1.1</label></li>
                            <li><label><input type="checkbox"> Option 1.2</label></li>
                            <li><label><input type="checkbox"> Option 1.3</label></li>
                        </ul>
                    </div>

                    <!-- Deuxième liste -->
                    <div class="dropdown">
                        <div class="dropdown-button" onclick="toggleDropdown(this)">Liste 2</div>
                        <ul class="checkbox-list">
                            <li><label><input type="checkbox"> Option 2.1</label></li>
                            <li><label><input type="checkbox"> Option 2.2</label></li>
                            <li><label><input type="checkbox"> Option 2.3</label></li>
                        </ul>
                    </div>

                    <!-- Troisième liste -->
                    <div class="dropdown">
                        <div class="dropdown-button" onclick="toggleDropdown(this)">Liste 3</div>
                        <ul class="checkbox-list">
                            <li><label><input type="checkbox"> Option 3.1</label></li>
                            <li><label><input type="checkbox"> Option 3.2</label></li>
                            <li><label><input type="checkbox"> Option 3.3</label></li>
                        </ul>
                    </div>
                </div>
                <button type="submit"> Chercher </button>
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

<script>
    // Fonction pour afficher/masquer le conteneur
    function toggleContainer() {
        const container = document.getElementById('container');
        container.classList.toggle('active');
    }

    // Fonction pour afficher/masquer une liste déroulante spécifique
    function toggleDropdown(button) {
        const list = button.nextElementSibling;
        list.classList.toggle('active');
    }

    // Fermer toutes les listes déroulantes si on clique en dehors
    document.addEventListener('click', function (event) {
        const dropdowns = document.querySelectorAll('.checkbox-list');
        const buttons = document.querySelectorAll('.dropdown-button');
        if (![...buttons].some(button => button.contains(event.target))) {
            dropdowns.forEach(dropdown => dropdown.classList.remove('active'));
        }
    });
</script>

</html>