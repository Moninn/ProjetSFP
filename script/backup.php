#!/usr/bin/env php
<?php
date_default_timezone_set('Europe/Paris');

// ===========================
// CONFIGURATION
// ===========================
$baseDir = __DIR__ . "/../"; // racine du projet
$localBackupDir = $baseDir . "backup"; // dossier backup dans le projet
$remoteBackupDir = $baseDir . "BackupsGroupes/Groupe1"; // simulation du serveur distant
$appDir = $baseDir; // dossier racine de l'app
$photosDir = $baseDir . "photos";
$configFiles = [$appDir . "script/backup.php", $appDir . "script/scriptmoninn.php"];
$logFile = $appDir . "script/photos.log";
$nKeep = 5; // Nombre de sauvegardes à conserver

$pgDb = "myapp_db";
$pgUser = "postgres";
$pgPass = "mdp";

$mysqlDb = "myapp_mysql";
$mysqlUser = "root";
$mysqlPass = "";

$date = date("Y-m-d_H-i-s");
$backupFolder = $localBackupDir . "/" . $date;

// ===========================
// FONCTIONS
// ===========================
function logAction($message, $logFile) {
    $entry = "[" . date("Y-m-d H:i:s") . "] $message\n";
    echo $entry;
    file_put_contents($logFile, $entry, FILE_APPEND);
}

function createBackupFolder($folder, $logFile) {
    if (!is_dir($folder) && !mkdir($folder, 0777, true)) {
        logAction("Erreur création dossier $folder", $logFile);
        exit(1);
    }
    logAction("Dossier de sauvegarde créé : $folder", $logFile);
}

function backupConfigs($files, $dest, $logFile) {
    logAction("Sauvegarde des fichiers de configuration...", $logFile);
    foreach ($files as $file) {
        if (file_exists($file) && copy($file, $dest . "/" . basename($file))) {
            logAction("OK : $file", $logFile);
        } else {
            logAction("Échec : $file", $logFile);
        }
    }
}

function backupPhotos($photosDir, $backupFolder, $logFile) {
    logAction("Sauvegarde des photos modifiées (sans 'small')...", $logFile);
    $photoBackup = "$backupFolder/photos";
    mkdir($photoBackup, 0777, true);
    $files = glob("$photosDir/*");
    $count = 0;
    foreach ($files as $file) {
        if (strpos($file, "small") === false && filemtime($file) > (time() - 300)) {
            copy($file, "$photoBackup/" . basename($file));
            $count++;
        }
    }
    if ($count > 0) {
        $zipFile = "$backupFolder/photos.zip";
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            foreach (glob("$photoBackup/*") as $photo) {
                $zip->addFile($photo, basename($photo));
            }
            $zip->close();
            array_map('unlink', glob("$photoBackup/*"));
            rmdir($photoBackup);
            logAction("Photos sauvegardées et compressées.", $logFile);
        }
    } else {
        logAction("Aucune nouvelle photo à sauvegarder.", $logFile);
        rmdir($photoBackup);
    }
}

function compressBackup($backupFolder, $logFile) {
    $zipFile = "$backupFolder.zip";
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        foreach (glob("$backupFolder/*") as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        array_map('unlink', glob("$backupFolder/*"));
        rmdir($backupFolder);
        logAction("Sauvegarde compressée : $zipFile", $logFile);
    }
}

function sendToRemote($zipFile, $remoteDir, $logFile) {
    if (!is_dir($remoteDir)) mkdir($remoteDir, 0777, true);
    if (copy($zipFile, "$remoteDir/" . basename($zipFile))) {
        logAction("Copie vers $remoteDir réussie", $logFile);
    } else {
        logAction("Échec copie distante", $logFile);
    }
}

function purgeOldBackups($localBackupDir, $nKeep, $logFile) {
    logAction("Purge des anciennes sauvegardes...", $logFile);
    $files = glob("$localBackupDir/*.zip");
    usort($files, function($a, $b) { return filemtime($b) - filemtime($a); });
    $oldFiles = array_slice($files, $nKeep);
    foreach ($oldFiles as $file) {
        unlink($file);
    }
    logAction("Purge terminée (conservation des $nKeep dernières sauvegardes).", $logFile);
}

// ===========================
// EXECUTION
// ===========================
createBackupFolder($backupFolder, $logFile);
backupConfigs($configFiles, $backupFolder, $logFile);
backupPhotos($photosDir, $backupFolder, $logFile);
compressBackup($backupFolder, $logFile);
sendToRemote("$backupFolder.zip", $remoteBackupDir, $logFile);
purgeOldBackups($localBackupDir, $nKeep, $logFile);

logAction("Sauvegarde terminée avec succès.", $logFile);
?>
