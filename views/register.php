<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IUTables'O</title>
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
        <section class="register">
            <h2>Merci de vous inscrire:</h2>
            <form action="/register" method="post">
                <table class="register-table">
                    <tr>
                        <td class="register-label">
                            <p>Email:</p>
                        </td>
                        <td><input type="email" name="email" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">
                            <p>Nom:</p>
                        </td>
                        <td><input type="text" name="nom" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">
                            <p>Prenom:</p>
                        </td>
                        <td><input type="text" name="prenom" class="register-field" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">
                            <p>Mot de passe:</p>
                        </td>
                        <td><input type="password" name="password" id="password" class="register-field" autocomplete="new-password" required></td>
                    </tr>
                    <tr>
                        <td class="register-label">
                            <p>Confirmer mot de passe:</p>
                            <span id='message'></span>
                        </td>
                        <td><input type="password" name="confirm_password" id="confirm_password" class="register-field" onkeyup='check();' required></td>
                    </tr>
                    <tr>
                        <td class="register-label"></td>
                        <td><input type="submit" value="Se connecter" class="register-button register-field"></td>
                    </tr>
                    <?php if (isset($err)):?>
                    <tr>
                        <td colspan="2">
                            <span><?=$err?></span>
                        </td>
                    </tr>
                    <?php endif;?>
                </table>
            </form>
        </section>
    </main>
    <footer class="footer">
        <p>&copy; 2025 IUTables'O. Tous droits réservés.</p>
    </footer>
    <script>
        var check = function() {
            if (document.getElementById('password').value ==
                document.getElementById('confirm_password').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'matching';
            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'not matching';
            }
        }
    </script>
</body>

</html>