<?php

$repoDir = __DIR__;

$output = shell_exec("git -C $repoDir pull origin main 2>&1");

if (strpos($output, 'error') === false) {
    echo "<pre>$output</pre>";
    exit();
    #header("Location: index.php");
} else {
    echo "<pre>Erreur lors de la mise à jour des sources :\n$output</pre>";
    exit();
}

