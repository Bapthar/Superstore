<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $mdp = $_POST["mdp"];

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "SUPERSTORE";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Vérifier si le pseudo existe déjà
    $checkStmt = $conn->prepare("SELECT id_utilisateur FROM utilisateur WHERE pseudo = ?");
    $checkStmt->bind_param("s", $pseudo);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "Le pseudo existe déjà. Veuillez choisir un autre.";
    } else {
        // Insérer le nouvel utilisateur
        $insertStmt = $conn->prepare("INSERT INTO utilisateur (pseudo, mdp, is_admin) VALUES (?, ?, 0)");
        $insertStmt->bind_param("ss", $pseudo, $mdp);

        if ($insertStmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            echo "Une erreur s'est produite lors de l'inscription. Veuillez réessayer.";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<h2>Inscription</h2>

<form action="connection.php" method="post">
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" required><br>

    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" required><br>
    <br>
    <input type="submit" value="S'inscrire" class="login-button">
</form>

</body>
</html>
