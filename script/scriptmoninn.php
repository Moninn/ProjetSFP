#!/usr/bin/env php
<?php

// Paramètres BDD
$dsn = "pgsql:host=localhost;port=5432;dbname=myapp_db";
$user = "postgres";
$password = "mdp";

// Vérifier argument
if ($argc < 2 || $argv[1] !== '-f') {
    echo "Usage: php imagesmoninn.php -f\n";
    exit(1);
}

// Connexion à PostgreSQL
try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connexion réussie à PostgreSQL.\n";
} catch (PDOException $e) {
    die("Erreur connexion BDD : " . $e->getMessage());
}

// Dossier photos et fichier log
$photosDir = __DIR__ . "/../photos";
$logFile = __DIR__ . "/photos.log";

// Créer le dossier s'il n'existe pas
if (!is_dir($photosDir)) {
    mkdir($photosDir, 0777, true);
}

// Date pour nommage
$date = date("Y-m-d_H-i-s");

// Génération des photos
for ($i = 1; $i <= 3; $i++) {
    $filename = ($i == 3) ? "photo_small_{$date}_{$i}.jpg" : "photo_{$date}_{$i}.jpg";
    $filePath = $photosDir . DIRECTORY_SEPARATOR . $filename;

    // Crée un fichier vide pour simuler la photo
    if (file_put_contents($filePath, "") === false) {
        echo "Erreur création fichier : $filename\n";
        continue;
    }

    // Écrire dans le log
    $logEntry = "[" . date("Y-m-d H:i:s") . "] Nouvelle photo ajoutée : $filename\n";
    echo $logEntry;
    file_put_contents($logFile, $logEntry, FILE_APPEND);

    // Description dynamique
    $description = ($i == 3) ? "Image réduite (small)" : "Image originale";

    // Insérer dans la BDD
    try {
        $stmt = $pdo->prepare("INSERT INTO photos (nom_fichier, description, date_ajout) VALUES (:nom_fichier, :description, NOW())");
        $stmt->execute([
                'nom_fichier' => $filename,
                'description' => $description
        ]);
    } catch (PDOException $e) {
        echo "Erreur insertion BDD : " . $e->getMessage() . "\n";
    }
}

echo "Photos générées et insérées dans la BDD avec description.\n";
?>