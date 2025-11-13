
<?php
/**
 * Trouve la racine du dépôt Git en remontant depuis le répertoire courant
 */
function findGitRoot($startDir) {
    $dir = $startDir;
    while ($dir !== dirname($dir)) { // Tant qu'on n'est pas à la racine du système
        if (is_dir($dir . DIRECTORY_SEPARATOR . '.git')) {
            return $dir;
        }
        $dir = dirname($dir); // Remonte d'un niveau
    }
    return null; // Pas trouvé
}

$repoDir = findGitRoot(__DIR__);

if (!$repoDir) {
    die('<p>Aucun dépôt Git trouvé en remontant depuis : ' . htmlspecialchars(__DIR__) . '</p>');
}

// Vérifier si exec est dispo
if (!function_exists('exec')) {
    die('exec() est désactivé dans php.ini');
}

// Détection Git (Windows/Linux/Mac)
$gitPath = '';
if (stripos(PHP_OS, 'WIN') === 0) {
    exec('where git', $gitOutput);
    $gitPath = $gitOutput[0] ?? '';
} else {
    exec('which git', $gitOutput);
    $gitPath = $gitOutput[0] ?? '';
}

// Fallback si non trouvé
if (empty($gitPath)) {
    $possiblePaths = [
        'C:\\Program Files\\Git\\bin\\git.exe',
        'C:\\Program Files (x86)\\Git\\bin\\git.exe',
        '/usr/bin/git',
        '/usr/local/bin/git'
    ];
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            $gitPath = $path;
            break;
        }
    }
}

if (!$gitPath) {
    die('<p>Git non trouvé sur ce serveur.</p>');
}

// Récupérer la branche et le commit
exec("\"$gitPath\" -C \"$repoDir\" rev-parse --abbrev-ref HEAD", $branchOutput);
exec("\"$gitPath\" -C \"$repoDir\" rev-parse --short HEAD", $commitOutput);

$branch = $branchOutput[0] ?? 'Inconnu';
$commit = $commitOutput[0] ?? 'Inconnu';

echo "<p>Dépôt : <strong>" . htmlspecialchars($repoDir) . "</strong></p>";
echo "<p>Branche Git courante : <strong>" . htmlspecialchars($branch) . "</strong></p>";
echo "<p>Commit : <strong>" . htmlspecialchars($commit) . "</strong></p>";

phpinfo();
