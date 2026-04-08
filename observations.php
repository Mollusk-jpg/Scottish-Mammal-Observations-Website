<?php
require_once 'includes/db.php';

$pageTitle = 'All Observations';

// Fetch all species from the database
$pdo = getDbConnection();
$stmt = $pdo->query('
    SELECT
        id,
        locality,
        individual_count,
        latitude,
        longitude,
        gbif_species_key,
        observation_date
    FROM observations
    ORDER BY id
');
$observations = $stmt->fetchAll();

require_once 'includes/header.php';
?>


<?php if (empty($observations)): ?>
    <p>No observations found in the database.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Individual Count</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Observation Date</th>
                <th>Species Key</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($observations as $ob): ?>
                <tr>
                    <td><?php echo e($ob['id']); ?></td>
                    <td><?php echo e($ob['individual_count']); ?></td>
                    <td><?php echo e($ob['latitude']); ?></td>
                    <td><?php echo e($ob['longitude']); ?></td>
                    <td><?php echo e($ob['observation_date']); ?></td>
                    <td><?php echo e($ob['gbif_species_key']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

