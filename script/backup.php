#!/usr/bin/env php
<?php

// Vérifier si l'option -f est passée
if ($argc < 2 || $argv[1] !== '-f') {
    echo "Usage: php developer_sim.php -f\n";
    exit(1);
}

// --- Configuration ---
$photosDir = "../photos";      // dossier des photos
$logFile   = "photos.log";     // fichier de log

$dbHost = 'localhost';
$dbPort = '5432';
$dbName = 'myapp_db';
$dbUser = 'postgres';  // à adapter
$dbPass = 'mdp';       // à adapter

// --- Connexion à PostgreSQL ---
try {
    $pdo = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base OK\n";
} catch (PDOException $e) {
    echo "Erreur DB : " . $e->getMessage() . "\n";
    exit(1);
}

// --- Créer le dossier photos si nécessaire ---
if (!is_dir($photosDir)) {
    mkdir($photosDir, 0777, true);
    echo "Dossier $photosDir créé\n";
}

// --- Générer de nouvelles photos ---
$date = date("Y-m-d_H-i-s");

for ($i = 1; $i <= 3; $i++) {
    $filename = ($i == 3) ? "photo_small_{$date}_{$i}.jpg" : "photo_{$date}_{$i}.jpg";
    $filePath = $photosDir . DIRECTORY_SEPARATOR . $filename;

    // Crée un fichier vide simulant une photo
    file_put_contents($filePath, "");

    // Log
    $logEntry = "[" . date("Y-m-d H:i:s") . "] Nouvelle photo ajoutée : $filename\n";
    echo $logEntry;
    file_put_contents($logFile, $logEntry, FILE_APPEND);

    // --- Insérer la photo dans la table PostgreSQL ---
    try {
        $stmt = $pdo->prepare("
            INSERT INTO photos (nom_fichier, date_ajout, description)
            VALUES (:nom, NOW(), :desc)
        ");
        $stmt->execute([
            ':nom'  => $filename,
            ':desc' => "Photo générée par le script développeur"
        ]);
        echo "[" . date("Y-m-d H:i:s") . "] Ligne insérée en base : $filename\n";
        file_put_contents($logFile, "[" . date("Y-m-d H:i:s") . "] Ligne insérée en base : $filename\n", FILE_APPEND);
    } catch (PDOException $e) {
        $errLog = "[" . date("Y-m-d H:i:s") . "] ERREUR insertion DB : " . $e->getMessage() . "\n";
        echo $errLog;
        file_put_contents($logFile, $errLog, FILE_APPEND);
    }
}

?>
