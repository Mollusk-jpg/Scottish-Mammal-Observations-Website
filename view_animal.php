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


?>
<head>
</head>
<body>
<?php   foreach ($species_names as $names): ?>
<p><?php echo e($names['gbif_species_key']); ?></p>
<?php endforeach ?>
</body>