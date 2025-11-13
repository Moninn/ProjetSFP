<?php
$repoDir = realpath(__DIR__ . '/../'); // racine du projet

if (!function_exists('exec')) {
    die('exec() est désactivé dans php.ini');
}

// Détection Git
$gitPath = '';
if (stripos(PHP_OS, 'WIN') === 0) {
    echo "windows";
    exec('where git', $gitOutput);
    $gitPath = $gitOutput[0] ?? '';
} else {
    echo "linux";
    exec('which git', $gitOutput);
    $gitPath = $gitOutput[0] ?? '';
}
echo $gitPath . "<br>";
$gitPath = "git" ;

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

// Récupérer la branche
if ($gitPath) {
//    $cmd = "\"$gitPath\" -C \"$repoDir\" rev-parse --abbrev-ref HEAD";
    $cmd = "echo '' | sudo -S $gitPath -C \"$repoDir\" rev-parse --abbrev-ref HEAD";
    echo $cmd;
    $exec = exec($cmd, $branchOutput, $branchReturn);
    $branch = $branchOutput[0] ?? '';
    var_dump($exec) ;
    var_dump($branchOutput) ;
    var_dump($branchReturn) ;
} else {
    $branch = 'Git non trouvé';
}

if (empty($branch)) {
    $branch = 'Pas de dépôt Git ou commande échouée';
}

echo "<p>Branche Git courante : <strong>" . htmlspecialchars($branch) . "</strong></p>";
phpinfo();