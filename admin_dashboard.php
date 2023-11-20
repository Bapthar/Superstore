<?php session_start(); ?>
<?php include 'navbar_admin.php'; ?>

<?php
$dsn = 'mysql:host=localhost;dbname=SUPERSTORE;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit;
}

$query = "SELECT * FROM produit";
$result = $dbh->query($query);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$activePage = basename($_SERVER['SCRIPT_NAME']);

echo '<div style="display: flex; flex-wrap: wrap;">';

foreach ($result as $row) {
    echo '<div style="width: 30%; margin: 10px; border: 1px solid #ccc; padding: 10px; box-sizing: border-box;">';
    echo '<h3>' . htmlspecialchars($row['nom_album']) . '</h3>';
    echo '<h4>' . htmlspecialchars($row['nom_artiste']) . '</h4>';
    echo '<a href="produitdetail.php?id=' . $row['id_produit'] . '">';
    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Image du produit" style="max-width: 100%;">';
    echo '</a>';
    echo '<p><strong>Prix:</strong> ' . htmlspecialchars($row['prix']) . ' €</p>';
    echo '<form action="produitdetail.php" method="post">';
    echo '<input type="hidden" name="id_produit" value="' . $row['id_produit'] . '">';
    echo '<button type="submit">Voir détails</button>';
    echo '</form>';
    echo '</div>';
    
}

echo '</div>';
?>
