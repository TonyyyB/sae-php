<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$user->getPrenomNom()?> - IUTables'O</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/avis.css">
    <link rel="shortcut icon" href="/assets/favicon.ico" type="image/x-icon" />
</head>

<body>
<?php require_once "static/header.php";?>
    <main class="main-content">
        <section class="user-detail">
                <?php
                    echo $user->renderDetail();
                ?>
        </section>
    </main>
    <?php require_once "static/footer.php";?>
</body>

<script>
    function editAvis(id){
        const avis = document.querySelector('.avis-'+id);
        const edit = avis.querySelector('.edit');
        const content = avis.querySelector('.avis-content');

        if(edit.style.display === 'none'){
            edit.style.display = 'block';
            content.style.display = 'none';
        } else {
            edit.style.display = 'none';
            content.style.display = 'block';
        }
    }
</script>

</html>