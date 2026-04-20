<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

if (!isset($_GET['key']) || !is_numeric($_GET['key'])) {
    header('Location: animal_list.php');
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
$coordinate_loc = '';
$coordinate_date = '';

$coordinateList = array();

// Create list of latitude and longitude points. (currently returns string, FIXED)
foreach ($species as $specie): 
    
    foreach ($observations as $observation): 
        if ($observation['gbif_species_key'] == $speciesKey){
            // (float) converts string into float.
            $coordinate_loc = $observation['locality'];
            $coordinate_x = (float) $observation['latitude'];
            $coordinate_y = (float) $observation['longitude'];
            $coordinate_date = $observation['observation_date'];
            if (! in_array($coordinate_loc, $coordinateList) && ! in_array($coordinate_x, $coordinateList) && ! in_array($coordinate_y, $coordinateList) && ! in_array($coordinate_date, $coordinateList)){
                $coordinateList[] = [$coordinate_loc, $coordinate_x, $coordinate_y, $coordinate_date];
            }
        }
    endforeach;
endforeach;




// ---- Above code takes a long time to run, trying to make it speedier. 

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
        species.common_name,
        species.species_name,
        species.iucn_red_list_category,
        species.body_mass_kg,
        species.image_url,
        species.dietary_category
    FROM observations, species
    WHERE observations.gbif_species_key = species.gbif_species_key 
    ORDER BY `observations`.`observation_date` DESC
');
$stmt->execute();
$joined_gbif = $stmt->fetchAll();


$species_name = '';
$species_common_name ='';
$species_body_mass = '';
$species_iucn_cat = '';
$species_image_url = '';
$diet_cat = '';

foreach ($joined_gbif as $joined_g){
    if ($joined_g['gbif_species_key'] == $speciesKey){
        $species_name = $joined_g["species_name"];
        $species_common_name = $joined_g["common_name"];
        $species_body_mass = $joined_g["body_mass_kg"];
        $species_iucn_cat = $joined_g["iucn_red_list_category"];
        $species_image_url = $joined_g["image_url"];
        $diet_cat = $joined_g["dietary_category"];
    }
}
    

require_once 'includes/animal_list_header.php';
?>


<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
    <style>
        #map { 
            height: 500px; 
            width: 500px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;}

        p {
            color: white;
        }

        .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
        }
    </style>
</head>
<body>

<h1><?= $page_name ?></h1>
<a class="center" style="color: green;" href="species.php?key=<?php echo e($speciesKey); ?>">Technical Details</a>


<h1 class="center" style="color: white;"><?php echo e($species_common_name); ?> | <em><?php echo e($species_name); ?></em></h1>

<img class="center" src="<?php echo e($species_image_url) ?>" style="width:150px;height:150px;" >


<p class="center"><?php echo e($species_common_name); ?>'s have a body mass of <?php echo e($species_body_mass); ?>KG</p>
<p class="center"><?php echo e($species_common_name); ?>'s are <?php echo e($diet_cat); ?>s</p>

<?php if(!is_null($species_iucn_cat)): ?>
    <p class="center">Their endangerment status is <?php echo e($species_iucn_cat); ?></p>
<?php endif ?>

<div id="map"></div>
<!-- 
<?php if (empty($joined_gbif)): ?>
    <p>No observations found in the database.</p>
<?php else: ?>
    <table class="center" style="color: white;" id="results">
        <thead>
            <tr>
                <th>Locality</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>observation_date</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($joined_gbif as $joined_g): ?>
                <?php if ($joined_g['gbif_species_key'] == $speciesKey): ?>
                    <tr>
                        <?php if(!is_null($joined_g["locality"])): ?>
                            <td><?php echo e($joined_g["locality"]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Locality Not Registered"; ?></td>
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

                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
                        -->

<p class="center"> Lorem Ipsum </p>


<!-- This is to make the header the same animal clicked on in about.php -->
<?php foreach ($species_names as $name):
if ($name['gbif_species_key'] == $speciesKey){
    $page_name = $name['common_name'];
}
endforeach
?>
    
</body>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([56.56, -3.89], 6);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Convert php array into js array
    var jsCoordinateArray = <?php echo json_encode($coordinateList); ?>;

    for (var i = 0; i < jsCoordinateArray.length; i++) {
        marker = new L.marker([jsCoordinateArray[i][1], jsCoordinateArray[i][2]])
        .bindPopup(jsCoordinateArray[i][0])
        .addTo(map);
    }
    
</script>