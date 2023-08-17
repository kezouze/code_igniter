<!DOCTYPE html>
<html lang="fr">

<?php
$title = "Connexion Clients";
require_once(APPPATH . 'views/includes/head.php');
?>

<body>
    <div class="container">
        <h1>Espace Client</h1>
        <h2 style="text-align: center">Bienvenue !</h2>
        <form action="" method="post">
            <input type="text" name="identifiant" placeholder="Email ou pseudo">
            <input name="password" placeholder="Mot de passe" type="password">
            <input type="submit" value="Connexion">
        </form>
        <p class="error"><?= $error ?></p>
        <a href="http://[::1]/code_igniter_arthur/Users/forgot_password">Mot de passe oublié ?</a>
        <hr class="dashed">
        <button class="inscription"><a href="http://[::1]/code_igniter_arthur/Users/inscription">Inscrivez-vous</a></button class="inscription">
        <button><a href="http://[::1]/code_igniter_arthur/Welcome">Retour</a></button>
    </div>
</body>

</html>