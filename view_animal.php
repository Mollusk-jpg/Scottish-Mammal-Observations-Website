<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

if (!isset($_GET['key']) || !is_numeric($_GET['key'])) {
    header('Location: about.php');
    exit;
}

$speciesKey = (int)$_GET['key'];

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

// Create list of latitude and longitude points. (currently returns string, will fix later)
foreach ($species as $specie): 
    if ($specie['gbif_species_key'] == $speciesKey){
        echo $specie['common_name'], " Latitude and Longitude: "; 
    } 
    
    foreach ($observations as $observation): 
        if ($observation['gbif_species_key'] == $speciesKey){
            $coordinate_x = $observation['latitude'];
            $coordinate_y = $observation['longitude'];
            if (! in_array($coordinate_x, $list) && ! in_array($coordinate_y, $list)){
                $list[] = [$coordinate_x, $coordinate_y];
            }
        }
    endforeach;
endforeach;
?>


<head>
</head>
<body>
<p><a href="about.php">&larr; Back to species list</a></p>

<!-- This is to make the header the same animal clicked on in about.php -->
<?php foreach ($species_names as $name):
if ($name['gbif_species_key'] == $speciesKey){
    $page_name = $name['common_name'];
}
endforeach
?>
    <h1><?= $page_name ?></h1>
    
        <?php 
        var_dump($list)
        ?>
    
</body>