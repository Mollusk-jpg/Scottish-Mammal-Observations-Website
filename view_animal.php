<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

if (!isset($_GET['key']) || !is_numeric($_GET['key'])) {
    header('Location: about.php');
    exit;
}

$speciesKey = (int)$_GET['key'];

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

$page_name = '';

$coordinate_x = 0;
$coordinate_y = 0;

$list = array();
?>


<head>
</head>
<body>

<!-- This is to make the header as the same animal clicked on in about.php -->
<?php foreach ($species_names as $name):
if ($name['gbif_species_key'] == $speciesKey){
    $page_name = $name['common_name'];
}
endforeach
?>
    <h1><?= $page_name ?></h1>
    <ul>
        <?php foreach ($species as $specie): 
            if ($specie['gbif_species_key'] == $speciesKey){
                echo $specie['common_name'], "8888"; 
            } ?>
            
            <?php foreach ($observations as $observation): 
                if ($observation['gbif_species_key'] == $speciesKey){
                    $coordinate_x = $observation['latitude'];
                    $coordinate_y = $observation['longitude'];
                    if (! in_array($coordinate_x, $list) && ! in_array($coordinate_y, $list)){
                        $list[] = [$coordinate_x, $coordinate_y];
                        
                    }
                }
            ?>
            <?php endforeach; ?>
            
        <?php endforeach; ?>
        <p><?= var_dump($list) ?></p>
    </ul>
</body>