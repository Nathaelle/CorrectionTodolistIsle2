<h1>Bienvenue sur mon organiseur personnel !</h1>

<?php if(isset($_SESSION["errors"])): ?>
    <ul>
        <?php foreach($_SESSION["errors"] as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach ?>
    </ul>
<?php unset($_SESSION["errors"]) ?>
<?php endif ?>

<h2>Inscription</h2>
<form action="index.php?route=insertuser" method="POST">
    <input type="text" placeholder="Entrez votre pseudo" name="username">
    <input type="password" placeholder="Choisissez un mot de passe" name="password">
    <input type="password" placeholder="Confirmez votre mot de passe" name="password2">
    <input type="submit" value="S'enregistrer">
</form>

<hr>

<h2>Connexion</h2>
<form action="index.php?route=connectuser" method="POST">
    <input type="text" placeholder="Entrez votre pseudo" name="username">
    <input type="password" placeholder="Choisissez un mot de passe" name="password">
    <input type="submit" value="Se connecter">
</form>