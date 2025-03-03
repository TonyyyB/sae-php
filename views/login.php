<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IUTables'O</title>
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
        <section class="login">
            <h2>Merci de vous connecter:</h2>
            <form action="/login" method="post">
                <table class="login-table">
                    <tr>
                        <td class="login-label">Email:</td>
                        <td><input type="email" name="email" class="login-field" required></td>
                    </tr>
                    <tr>
                        <td class="login-label">Mot de passe:</td>
                        <td><input type="password" name="password" class="login-field" required></td>
                    </tr>
                    <tr>
                        <td class="login-label"></td>
                        <td><input type="submit" value="Se connecter" class="login-button login-field"></td>
                    </tr>
                </table>
                </table>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 IUTables'O. Tous droits réservés.</p>
    </footer>
</body>

</html>