<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Accueil — Équipe dév</title>
  <link rel="stylesheet" href="../css/styleaccueil.css">
</head>
<body>
  <div class="container">    
    <div class="php-info">
        <?php
            echo 'Version de PHP : ' . phpversion();
        ?>
    </div>
    <header>
      <h1>Page accueil — Équipe développement</h1>
      <p>Choisir une page ci-dessous :</p>
    </header>
        <div class="links">
       <!-- Lien vers une page développeurs -->
       <a href="../pages/angel.php">Angel</a>
       <a href="../pages/moninn.php">Moninn</a>

       <!-- Lien vers la page infos php -->
       <a href="../pages/phpinfo.php">PHPinfo</a>
    </div>
  </div>
</body>
</html>
