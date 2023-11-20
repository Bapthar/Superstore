<?php session_start(); ?>
<?php include 'navbar_admin.php'; ?>

<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "SUPERSTORE";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Traitement de la création ou de la modification d'un utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Création d'un nouvel utilisateur
        $pseudo = $_POST["pseudo"];
        $mdp = $_POST["mdp"];
        $is_admin = isset($_POST["is_admin"]) ? 1 : 0; // Si coché, is_admin = 1, sinon is_admin = 0

        $stmt = $conn->prepare("INSERT INTO utilisateur (pseudo, mdp, is_admin) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $pseudo, $mdp, $is_admin);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Modification d'un utilisateur existant
        $id_utilisateur = $_POST["id_utilisateur"];
        $pseudo = $_POST["pseudo"];
        $mdp = $_POST["mdp"];
        $is_admin = isset($_POST["is_admin"]) ? 1 : 0;

        $stmt = $conn->prepare("UPDATE utilisateur SET pseudo = ?, mdp = ?, is_admin = ? WHERE id_utilisateur = ?");
        $stmt->bind_param("ssii", $pseudo, $mdp, $is_admin, $id_utilisateur);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Suppression d'un utilisateur
        $id_utilisateur = $_POST["id_utilisateur"];

        $stmt = $conn->prepare("DELETE FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->bind_param("i", $id_utilisateur);
        $stmt->execute();
        $stmt->close();
    }
}

// Récupération des utilisateurs depuis la base de données
$result = $conn->query("SELECT * FROM utilisateur");

?>

<!-- Affichage des utilisateurs -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <script>
        function showUserDetails(id, pseudo, mdp, is_admin) {
            document.getElementById("id_utilisateur").value = id;
            document.getElementById("pseudo").value = pseudo;
            document.getElementById("mdp").value = mdp;
            document.getElementById("is_admin").checked = is_admin == 1;
        }
    </script>
</head>
<body>

<h2>Gestion des Utilisateurs</h2>

<!-- Formulaire de création ou de modification d'utilisateur -->
<form action="" method="post">
    <label for="id_utilisateur">ID :</label>
    <input type="text" name="id_utilisateur" id="id_utilisateur" readonly>

    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" id="pseudo">

    <label for="mdp">Mot de passe :</label>
    <input type="text" name="mdp" id="mdp">

    <label for="is_admin">Admin :</label>
    <input type="checkbox" name="is_admin" id="is_admin">

    <input type="submit" name="create" value="Créer">
    <input type="submit" name="update" value="Modifier">
    <input type="submit" name="delete" value="Supprimer">
</form>

<!-- Affichage des utilisateurs -->
<select onchange="showUserDetails(this.value, this.options[this.selectedIndex].dataset.pseudo, this.options[this.selectedIndex].dataset.mdp, this.options[this.selectedIndex].dataset.is_admin)">
    <option value="">Sélectionner un utilisateur</option>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['id_utilisateur']}' data-pseudo='{$row['pseudo']}' data-mdp='{$row['mdp']}' data-is_admin='{$row['is_admin']}'>{$row['pseudo']}</option>";
    }
    ?>
</select>

</body>
</html>
<?php
// Fermer la connexion à la base de données
$conn->close();
?>

</body>
</html>
