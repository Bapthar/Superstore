<?php session_start(); ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>
<body>

<h2>Connexion</h2>

<form action="process_login.php" method="post">
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" required><br>

    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" required><br>

    <input type="submit" value="Se connecter">
</form>

</body>
</html>
