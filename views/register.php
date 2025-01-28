<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register - IUTables'O</title>
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
                <li><a href="/register">register</a></li>
            </ul>
        </nav>
    </header>
    <main class="main-content">
        <section class="register">
            <h2>Merci de vous inscrire:</h2>
            <form action="/register" method="post">
                <table class="register-table">
                    <tr>
                        <td class="register-label">Email:</td>
                        <td><input type="email" name="email" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">nom:</td>
                        <td><input type="text" name="Nom" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">prenom:</td>
                        <td><input type="text" name="Prénom" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">telephone:</td>
                        <td><input type="text" name="phone" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">adresse:</td>
                        <td><input type="text" name="adresse" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">codepostal:</td>
                        <td><input type="text" name="codepostal" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">Mot de passe:</td>
                        <td><input type="password" name="password" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label"></td>
                        <td><input type="submit" value="Se connecter" class="register-button register-field"></td>
                    </tr>
                </table>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 IUTables'O. Tous droits réservés.</p>
    </footer>
</body>

</html>