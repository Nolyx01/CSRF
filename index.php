<?php
session_start();

// Génère un jeton CSRF si non existant
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Traitement de l'achat si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si le jeton CSRF est valide
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $message = "<p style='color:red;'>Erreur CSRF : jeton invalide.</p>";
    } else {
        $produit = htmlspecialchars($_POST['produit'] ?? 'inconnu');
        $message = "<p style='color:green;'>Merci pour votre achat de <strong>$produit</strong> !</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne - Exemple CSRF</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .token { background: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .product { border: 1px solid #ddd; padding: 10px; margin: 10px 0; }
        input[type="submit"] { background: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Boutique en ligne</h1>

    <!-- Affichage du jeton CSRF en haut de page -->
    <div class="token">
        <strong>Jeton CSRF actuel :</strong> <?php echo htmlspecialchars($_SESSION['csrf_token']); ?>
    </div>

    <?php if (isset($message)) echo $message; ?>

    <h2>Nos produits</h2>

    <!-- Formulaire pour souris -->
    <div class="product">
        <h3>Souris gaming</h3>
        <p>Prix : 49,99 €</p>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="produit" value="souris">
            <input type="submit" value="Acheter">
        </form>
    </div>

    <!-- Formulaire pour clavier -->
    <div class="product">
        <h3>Clavier mécanique</h3>
        <p>Prix : 89,99 €</p>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="produit" value="clavier">
            <input type="submit" value="Acheter">
        </form>
    </div>

    <!-- Formulaire pour écran -->
    <div class="product">
        <h3>Écran 27 pouces</h3>
        <p>Prix : 249,99 €</p>
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="produit" value="ecran">
            <input type="submit" value="Acheter">
        </form>
    </div>
</body>
</html>
