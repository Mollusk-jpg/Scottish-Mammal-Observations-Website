<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

// Fetch the specific id and (try to) merge wiith category name
$pdo = getDbConnection();
$stmt = $pdo->query('
    SELECT
        common_name,
        species_name
    FROM species
    ORDER BY common_name
');
$species_names = $stmt->fetchAll();


?>
<p>Hello World!</p>