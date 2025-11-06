#!/usr/bin/env php
<?php

// Vérifier si l'option -f est passée
if ($argc < 2 || $argv[1] !== '-f') {
    echo "Usage: php imagesmoninn.php -f\n";
    exit(1);
}

$photosDir = "../photos";      // dossier des photos
$logFile = "photos.log";

// Créer le dossier s'il n'existe pas
if (!is_dir($photosDir)) {
    mkdir($photosDir, 0777, true);
}

// --- Générer de nouvelles photos ---
$date = date("Y-m-d_H-i-s");

for ($i = 1; $i <= 3; $i++) {
    if ($i == 3) {
        $filename = "photo_small_{$date}_{$i}.jpg";  // photo small
    } else {
        $filename = "photo_{$date}_{$i}.jpg";
    }

    $filePath = $photosDir . DIRECTORY_SEPARATOR . $filename;

    // Crée un fichier vide pour simuler la photo
    file_put_contents($filePath, "");

    // Écrire dans le log
    $logEntry = "[" . date("Y-m-d H:i:s") . "] Nouvelle photo ajoutée : $filename\n";
    echo $logEntry;
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}
?>
