<?php
date_default_timezone_set('UTC');

$competences = [
    "HTML", "CSS", "JavaScript", "PHP", "C#", ".NET", "Git",
    "Webflow", "WordPress", "MySQL", "PostgreSQL", "Python"
];
$formation = [
    "2025 - 2026 Bachelor CDWFS – 3ᵉ année - École ORT, Lyon",
    "2022 - 2024 BTS SIO (SLAM) - IS2D, Annonay",
    "2019 - 2022 BAC PRO (MELEC) - Lycée Boissy d'Anglas, Annonay"
];

date_default_timezone_set('UTC');

$competences = [
        "HTML", "CSS", "JavaScript", "PHP", "C#", ".NET", "Git",
        "Webflow", "WordPress", "MySQL", "PostgreSQL", "Python"
];
$formation = [
        "2025 - 2026 Bachelor CDWFS – 3ᵉ année - École ORT, Lyon",
        "2022 - 2024 BTS SIO (SLAM) - IS2D, Annonay",
        "2019 - 2022 BAC PRO (MELEC) - Lycée Boissy d'Anglas, Annonay"
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Moninn Ly</title>
    <link rel="stylesheet" href="../css/moninn.css">
</head>
<body>
<div id="system-date">
    <?php echo date('l jS \of F Y h:i:s A'); ?>
</div>
<div id="cv">
    <div id="title-block">
        <h1 id="title">Moninn Ly</h1>
        <h2 id="subtitle">Développeur Informatique</h2>
    </div>

    <div id="infos">
        <p><strong>Nom :</strong> Moninn Ly</p>
        <p><strong>Email :</strong> 1moninnly@gmail.com</p>
        <p><strong>Téléphone :</strong> 06 16 71 65 73</p>
    </div>

    <div id="summary">
        À la recherche d’une alternance en développement informatique – 3ᵉ année Bachelor CDWFS (École ORT)
    </div>

    <div id="skills-block">
        <h3>Compétences</h3>
        <ul id="skills">
            <?php foreach($competences as $comp): ?>
                <li><?php echo $comp; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div id="formation-block">
        <h3>Formation</h3>
        <ul id="formation">
            <?php foreach($formation as $f): ?>
                <li><?php echo $f; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
</body>
</html>


