<?php

require_once 'includes/db.php';

$pageTitle = 'All Species';

// Fetch all species from the database
$pdo = getDbConnection();
$stmt = $pdo->query('
    SELECT
        gbif_species_key,
        species_name,
        common_name,
        iucn_red_list_category,
        dietary_category,
        body_mass_kg,
        habitat,
        image_url
    FROM species
    ORDER BY common_name
');
$species = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<h2>Scottish Mammal Species</h2>

<p>Explore our database of 34 mammal species found in Scotland.</p>

<?php if (empty($species)): ?>
    <p>No species found in the database.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Common Name</th>
                <th>Scientific Name</th>
                <th>Conservation Status</th>
                <th>Dietary Category</th>
                <th>Body Mass (kg)</th>
                <th>Habitat</th>
                <th>Action</th>
                <th>photo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($species as $sp): ?>
                <tr>
                    <td><?php echo e($sp['common_name']); ?></td>
                    <td><em><?php echo e($sp['species_name']); ?></em></td>
                    <td><?php echo $sp['iucn_red_list_category'] ? e($sp['iucn_red_list_category']) : '—'; ?></td>
                    <td><?php echo e($sp['dietary_category']); ?></td>
                    <td><?php echo e($sp['body_mass_kg']); ?></td>
                    <td><?php echo e($sp['habitat']); ?></td>
                    <td><a href="species.php?key=<?php echo e($sp['gbif_species_key']); ?>">View Details</a></td>
                    <td><img src="<?php echo e($sp['image_url']) ?>" style="width:50px;height:50px;" ></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
