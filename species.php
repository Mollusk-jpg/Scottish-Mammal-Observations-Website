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


$pdo = getDbConnection();

// Fetch the species details
$stmt = $pdo->prepare('
    SELECT
        observations.locality,
        observations.individual_count,
        observations.latitude,
        observations.longitude,
        observations.observation_date,
        observations.gbif_species_key,
        species.common_name
    FROM observations, species
    WHERE observations.gbif_species_key = species.gbif_species_key 
    ORDER BY `observations`.`observation_date` DESC
');
$stmt->execute();
$joined_gbif = $stmt->fetchAll();

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

<?php
/*
foreach ($joined_gbif as $joined_g):
    if ($joined_g["common_name"] = $species['common_name']) {
        echo e($joined_g["locality"]);
        echo e($joined_g["individual_count"]);
        echo e($joined_g["latitude"]);
        echo e($joined_g["longitude"]);
        echo e($joined_g["observation_date"]);
        echo e($joined_g["common_name"]);
    }
endforeach
*/
?>

<h1> Observations for <?php echo e($species['common_name']) ?> </h1>
<?php if (empty($species)): ?>
    <p>No observations found in the database.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>locality</th>
                <th>individual_count</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>observation_date</th>
                <th>common_name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($joined_gbif as $joined_g): ?>
                <?php if ($joined_g["common_name"] = $species['common_name']): ?>
                    <tr>
                        <?php if(!is_null($joined_g["locality"])): ?>
                            <td><?php echo e($joined_g["locality"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Locality Not Registered"; ?></td>
                        <?php endif ?>

                        <?php if(!is_null($joined_g["individual_count"])): ?>
                            <td><?php echo e($joined_g["individual_count"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Count not registered"; ?></td>
                        <?php endif ?>
                        
                        <?php if(!is_null($joined_g["latitude"])): ?>
                            <td><?php echo e($joined_g["latitude"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>

                        <?php if(!is_null($joined_g["longitude"])): ?>
                            <td><?php echo e($joined_g["longitude"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>

                        <?php if(!is_null($joined_g["observation_date"])): ?>
                            <td><?php echo e($joined_g["observation_date"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>

                        <?php if(!is_null($joined_g["common_name"])): ?>
                            <td><?php echo e($joined_g["common_name"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>
                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
