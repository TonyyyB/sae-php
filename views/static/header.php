<header class="header">
    <div class="title">
        <a href="/" class="title-link">
            <img src="/assets/logo.png" alt="IUTables'O" class="logo">
            <h1 class="header-title">IUTables'O</h1>
        </a>
    </div>
    <?php if (isset($_SESSION['user']) && !empty($_SESSION["user"])): ?>
        <div class="user">
            <h1 class="username"><?= $_SESSION["user"]->getPrenomNom() ?></h1>
            <a href="/logout" class="button">Déconnexion</a>
        </div>
    <?php else: ?>
        <div class="user">
            <a href="/login" class="button">Connexion</a>
            <a href="/register" class="button">Inscription</a>
        </div>
    <?php endif; ?>
</header>