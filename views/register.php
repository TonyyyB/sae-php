<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IUTables'O</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <link rel="stylesheet" href="/assets/global.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
    <?php require_once "static/header.php"; ?>
    <main class="main-content">
        <section class="login">
            <h2 class="login-title">Merci de vous inscrire:</h2>
            <form action="/register" method="post">
                <table class="login-table">
                    <tr class="login-row">
                        <td class="login-label">
                            Email:
                        </td>
                        <td><input type="email" name="email" class="login-field login-input" required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label">
                            Nom:
                        </td>
                        <td><input type="text" name="nom" class="login-field login-input" required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label">
                            Prenom:
                        </td>
                        <td><input type="text" name="prenom" class="login-field login-input" required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label">
                            Mot de passe:
                        </td>
                        <td><input type="password" name="password" id="password" class="login-field login-input"
                                autocomplete="new-password" required></td>
                    </tr class="login-row">
                    <tr class="login-row">
                        <td class="login-label">
                            Confirmer mot de passe:
                            <span id='message'></span>
                        </td>
                        <td><input type="password" name="confirm_password" id="confirm_password"
                                class="login-field login-input" onkeyup='check();' required></td>
                    </tr>
                    <tr class="login-row">
                        <td class="login-label"></td>
                        <td><input type="submit" value="Se connecter" class="button login-button login-field"></td>
                    </tr>
                    <?php if (isset($err)): ?>
                        <tr>
                            <td colspan="2">
                                <span><?= $err ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </form>
        </section>
    </main>
    <?php require_once "static/footer.php"; ?>
    <script>
        var check = function () {
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