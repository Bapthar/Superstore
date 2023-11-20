<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $mdp = $_POST["mdp"];
var_dump($pseudo);
var_dump($mdp);

    // connexion BDD

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "SUPERSTORE";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE pseudo = ? AND mdp = ?");
    $stmt->bind_param("ss", $pseudo, $mdp);
    $stmt->execute();

    // Récupérez le résultat de la requête
    $result = $stmt->get_result();

    // Vérifiez si l'utilisateur existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user['is_admin']) {
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION["pseudo"] = $pseudo;
            header("Location: homepage.php");
            exit();
        }
    } else {
        echo "Identifiants invalides. Veuillez réessayer.";
    }

    // Fermez la connexion et la requête préparée
    $stmt->close();
    $conn->close();
}
?>
