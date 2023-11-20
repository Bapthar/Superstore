<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_produit'])) {
    $id_produit = $_POST['id_produit'];

    // Ajouter le produit au panier
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // Vous devez récupérer les détails du produit depuis votre base de données
    // et l'ajouter au tableau $_SESSION['panier']

    // Exemple:
    $produit = array(
        'id_produit' => $id_produit,
        'quantite' => 1,  // Vous pouvez ajuster la quantité
        // Ajoutez d'autres détails du produit si nécessaire
    );

    $_SESSION['panier'][] = $produit;

    // Debug : Affichez le contenu du panier
    var_dump($_SESSION['panier']);

    // Rediriger vers la page du produit ou une autre page si nécessaire
    header("Location: panierPage.php");
    exit();
} else {
    // Rediriger vers la page d'accueil ou une autre page si nécessaire
    header("Location: homePage.php");
    exit();
}
?>
