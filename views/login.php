<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="stylesheet" href="/assets/header.css">
    <link rel="stylesheet" href="/assets/footer.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
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
                    <?php if (isset($err)):?>
                    <tr>
                        <td colspan="2">
                            <span><?=$err?></span>
                        </td>
                    </tr>
                    <?php endif;?>
                </table>
                </table>
            </form>
        </section>
    </main>
    <?php require_once "static/footer.php";?>
</body>

</html>