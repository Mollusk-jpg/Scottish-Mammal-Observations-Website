<?php
/**
 * Scottish Mammal Observations Database - Species Detail Page
 * Displays detailed information about a single species
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

// Validate the species key parameter
if (!isset($_GET['key']) || !is_numeric($_GET['key'])) {
    header('Location: index.php');
    exit;
}

$speciesKey = (int)$_GET['key'];
$pdo = getDbConnection();

// Fetch the species details
$stmt = $pdo->prepare('
    SELECT
        gbif_species_key,
        species_name,
        common_name,
        iucn_red_list_category,
        body_mass_kg,
        dietary_category,
        uk_protection_status,
        habitat,
        image_url
    FROM species
    WHERE gbif_species_key = ?
');
$stmt->execute([$speciesKey]);
$species = $stmt->fetch();

// If species not found, redirect to home
if (!$species) {
    header('Location: index.php');
    exit;
}

$pageTitle = $species['common_name'];

require_once 'includes/header.php';
?>

<p><a href="index.php">&larr; Back to all species</a></p>

<h2><?php echo e($species['common_name']); ?></h2>

<dl>
    <dt>Scientific Name</dt>
    <dd><em><?php echo e($species['species_name']); ?></em></dd>

    <dt>Conservation Status</dt>
    <dd><?php echo $species['iucn_red_list_category'] ? e($species['iucn_red_list_category']) : 'Not listed'; ?></dd>

    <dt>Body Mass</dt>
    <dd><?php echo e($species['body_mass_kg']); ?> kg</dd>

    <dt>Dietary Category</dt>
    <dd><?php echo e($species['dietary_category']); ?></dd>

    <dt>Habitat</dt>
    <dd><?php echo e($species['habitat']); ?></dd>

    <dt>UK Protection Status</dt>
    <dd><?php echo e($species['uk_protection_status']); ?></dd>
</dl>

<!-- Students: Add observations display here as an intermediate enhancement -->

<?php require_once 'includes/footer.php'; ?>
