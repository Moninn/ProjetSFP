<?php
$repoDir = __DIR__;
$branch = 'moninn'; // Change la branche ici

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $cmd = "git -C \"$repoDir\" pull origin $branch 2>&1";
    $output = shell_exec($cmd);

    if (strpos(strtolower($output), 'fatal') === false && strpos(strtolower($output), 'error') === false) {
        echo "<p>Mise à jour réussie :</p>";
    } else {
        echo "<p>Erreur lors de la mise à jour :</p>";
    }
    echo "<pre>$output</pre>";
    echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
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
