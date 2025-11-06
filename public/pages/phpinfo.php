<?php
$repoDir = __DIR__;
$branch = trim(shell_exec("git -C $repoDir rev-parse --abbrev-ref HEAD"));
echo "<p>Branche Git courante : <strong>$branch</strong></p>";
phpinfo();
?>
