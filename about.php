<?php

require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

$pdo = getDbConnection();
$stmt = $pdo->query('
    SELECT
        common_name,
        species_name
    FROM species
    ORDER BY common_name
');
$species_names = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<head>
    <link rel="stylesheet" href="css/style.css">
<style>

</style>
</head>
<body>

<?php if (empty($species_names)): ?>
    <p>No species names found in the database.</p>
<?php else: ?>
        <?php   foreach ($species_names as $names): ?>
        <div class="center" >
        <div class="card">
                <div class="container">
                    <img src="images/american_mink.jpg" alt="American Mink" style="width:50px;height:60px;">
                    <p><b> <?php echo e($names['common_name']); ?> </b>____</p>
                    <p><?php echo e($names['species_name']); ?></p>
                </div>
            </div>
        </div>
        <?php   endforeach;?>
<?php endif; ?>

</body>
</html>