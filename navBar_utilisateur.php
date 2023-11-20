<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>homepage</title>
</head>

<body>
    <nav class="navbar">
        <ul class="navbar">
            <li><a href="homepage.php">Home</a></li>
            <li><a href='deconnexion.php'>Déconnexion</a></li>
            <li><a href="panierPage.php">Panier</a></li>
            <li id="navname-bonjour" style="color: white;">
            <?php
            if (isset($_SESSION["pseudo"])) {
                echo "<li>Bonjour " . $_SESSION["pseudo"] . "</li>";
            }
            ?>
            </div>
            </li>
        </ul>
    </nav>
</body>
</html>
