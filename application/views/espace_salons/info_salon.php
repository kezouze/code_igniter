<!DOCTYPE html>
<html lang="fr">

<?php
$title = "Nos Salons";
$color = "#2f4f4f";
$linkTo = "Welcome";
require_once(APPPATH . 'views/includes/head.php');
?>

<body>
    <div class="salons_container">
        <?php require_once(APPPATH . 'views/includes/header.php'); ?>
        <span class="topGap"></span>
        <?php foreach ($all_data as $key) { ?>
            <div class="card">
                <h2><?= $key->name; ?></h2>
                <a href="http://[::1]/coiffhair/Welcome/details?id=<?= $key->id_pro ?>"><img src="https://source.unsplash.com/random/300x200?hair" alt="exemple"></a>
                <p><?= $key->email; ?></p>
                <p><?= $key->boss; ?></p>
            </div>
        <?php } ?>
        <span class="bottomGap"></span>
        <?php require_once(APPPATH . 'views/includes/footer.php'); ?>
    </div>
</body>

</html>