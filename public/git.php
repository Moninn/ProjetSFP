<?php
$repoDir = __DIR__;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $output = shell_exec("git -C $repoDir pull origin main 2>&1");

    if (strpos(strtolower($output), 'error') === false) {
        echo "<p>Mise à jour réussie :</p>";
        echo "<pre>$output</pre>";
        echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
    } else {
        echo "<p>Erreur lors de la mise à jour des sources :</p>";
        echo "<pre>$output</pre>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mettre à jour le site</title>
</head>
<body>
<form method="POST">
    <h2>Mettre à jour le site depuis Git</h2>
    <button type="submit" name="update">Mettre à jour</button>
</form>
</body>
</html>
