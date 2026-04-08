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

</head>
<body>

<?php if (empty($species_names)): ?>
    <p>No species names found in the database.</p>
<?php else: ?>
<table>
    <thead>
        <tr>
            <th>Common Name</th>
        </tr>
    </thead>
    <div>
        <p>Hello, World!</p>
        <!-- $names = '' -->
        <?php   foreach ($species_names as $names): ?>
                    <p><?php echo e($names['common_name']); ?></p>
        <?php   endforeach;?>
        <a href="index.php">Home</a>
    </div>
<table>
<?php endif; ?>

</body>
</html>