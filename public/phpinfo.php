
<?php
$repoDir = realpath(__DIR__ . '/..'); // racine du projet

if (!is_dir($repoDir . '/.git')) {
    die("<p style='color:red'>Erreur : le dossier $repoDir n'est pas un dépôt Git.</p>");
}

$gitPath = "C:\\Program Files\\Git\\cmd\\git.exe"; // chemin complet

// Autoriser le répertoire (sans --global)
shell_exec("\"$gitPath\" config --add safe.directory \"$repoDir\"");

// Récupérer la branche
$cmd = "\"$gitPath\" -C \"$repoDir\" rev-parse --abbrev-ref HEAD";
exec($cmd, $branchOutput, $branchReturn);

$branch = $branchOutput[0] ?? 'Pas de dépôt Git ou commande échouée';
echo "<p>Branche Git courante : <strong>" . htmlspecialchars($branch) . "</strong></p>";
phpinfo();
?>
