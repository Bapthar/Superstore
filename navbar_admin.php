<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>homepage</title>
</head>
<body>
<?php
$activePage = basename($_SERVER['SCRIPT_NAME']);
?>
    <nav class="navbar">
        <ul class="navbar">
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="connection.php">Connexion</a></li>
            <li><a href="panierPage.php">Panier</a></li>
            <li><a href="gestion_admin.php">Gestion Admin</a></li>
        </ul>
    </nav>
</body>
</html>