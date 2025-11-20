<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Page Développeur</title>
    <link rel="stylesheet" href="../css/styleAlex.css" />
</head>
<body>
<header>
    <h1>Page Développeur</h1>
    <p class="lead">Alexandre IGLESIAS</p>
</header>

<main class="container">
    <article id="unique-dev" class="card">
        <h2>Alexandre IGLESIAS</h2>
        <div class="meta">Heure CEST : <span class="generated-at"> </span></div>
        <div class="meta">Heure de génération de la page : <span class="generated-at"> <?php echo date('Y-m-d H:i:s'); ?></span></div>
        <section class="cv">
            <h3>CV résumé</h3>

            <h4>Formation</h4>
            <ul>
                <li>En cours : Bachelor Concepteur Développeur Web FullStack (2025 - 2026)</li>
                <li>BTS SIO Option SLAM (2023 - 2025)</li>
            </ul>

            <h4>Compétences</h4>
            <ul>
                <li>Langages : PHP, JavaScript, React Native, Java</li>
                <li>Bases de données : MySQL, PostgreSQL</li>
                <li>Outils : Git, Docker, Linux</li>
            </ul>
        </section>

        <?php

        //shell_exec('git config --global --add safe.directory "C:/wamp64/www/PHP/sfp1-2025" 2>&1');
        $output = shell_exec('git rev-parse --abbrev-ref HEAD 2>&1');
        echo "<h4>Branche git actuelle :</h4> <p>" . htmlspecialchars($output) . "</p>";

        ?>
    </article>
</main>

<script src="../css/scriptAlex.js"></script>
</body>
</html>