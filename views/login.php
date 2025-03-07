<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IUTables'O</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
    <?php require_once "static/header.php"; ?>
    <main class="main-content">
        <section class="login">
            <h2 class="login-title">Merci de vous connecter:</h2>
            <form action="/login" method="post">
                <table class="login-table">
                    <tr class="login-row">
                        <td class="login-label">Email:</td>
                        <td><input type="email" name="email" class="login-field login-input" required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label">Mot de passe:</td>
                        <td><input type="password" name="password" class="login-field login-input" required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label"></td>
                        <td><input type="submit" value="Se connecter" class="button login-button login-field"></td>
                    </tr>
                    <?php if (isset($err)): ?>
                        <tr class="login-row">
                            <td colspan="2">
                                <span><?= $err ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
                </table>
            </form>
        </section>
    </main>
    <?php require_once "static/footer.php"; ?>
</body>

</html>