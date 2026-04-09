<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

// Fetch the specific id and (try to) merge wiith category name
$pdo = getDbConnection();
$stmt = $pdo->query('
    SELECT
        common_name,
        species_name,
        gbif_species_key
    FROM species
    ORDER BY common_name
');
$species_names = $stmt->fetchAll();

$observations = getAllObservations();
$species = getAllSpecies();
?>


<head>
</head>
<body>
    <h1>Species</h1>
    <ul>
        <?php foreach ($species as $specie): ?>
            <li><?= e($specie['species_name']) ?> and <?= e($specie['common_name']) ?></li>
        <?php endforeach; ?>
    </ul>
    <h1>Observations</h1>
    <ul>
        <?php foreach ($observations as $observation): ?>
            <li><?= e($observation['id']) ?> and <?= e($observation['locality']) ?></li>
        <?php endforeach; ?>
    </ul>

<?php   foreach ($species_names as $names): ?>
<p><?php echo e($names['gbif_species_key']); ?></p>
<?php endforeach ?>
</body>