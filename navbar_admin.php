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
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href='deconnexion.php'>Déconnexion</a></li>
            <li><a href="gestion_admin.php">Gestion Admin</a></li>
            <?php
            if (isset($_SESSION["pseudo"])) {
                echo "<li id='navname'>Bonjour " . $_SESSION["pseudo"] . "</li>";
            }
            ?>
        </ul>
    </nav>
</body>
</html>