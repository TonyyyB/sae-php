<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
    <style>
        .container {
        width: 400px;
        padding: 20px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: none; /* Caché par défaut */
        }

        .container.active {
        display: block;
        }
        .dropdown {
        position: relative;
        width: 300px;
        }

        .dropdown-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-button:hover {
        background-color: #f9f9f9;
        }

        .dropdown-button:after {
        content: "▼";
        font-size: 12px;
        color: #333;
        }

        .checkbox-list {
        list-style: none;
        padding: 0;
        margin: 8px 0 0;
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 10;
        }

        .checkbox-list.active {
        display: block;
        }

        .checkbox-list li {
        padding: 10px 16px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #e0e0e0;
        }

        .checkbox-list li:last-child {
        border-bottom: none;
        }

        .checkbox-list input[type="checkbox"] {
        margin-right: 10px;
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #4caf50;
        }

        .checkbox-list label {
        font-size: 14px;
        color: #333;
        cursor: pointer;
        flex-grow: 1;
        }
    </style>
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