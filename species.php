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

// Fetch species details and observation details, link by gbif_id
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

require_once 'includes/animal_list_header.php';
?>

<body style="color: white">
<a style="color: green;" href="view_animal.php?key=<?php echo e($speciesKey); ?>">Animal Page</a>

<h2>Advanced Details for <?php echo e($species['common_name']); ?></h2>



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

$locality_var = '';
$individual_count_var = 0;
$latitude_var = 0;
$longitude_var = 0;
$observation_date_var = '';
$common_name_var = '';
$date_to_string = 0;

$observationArray = array();

// Create an object array to be passed in the Obervations Table
foreach ($joined_gbif as $joined_g){
    if ($joined_g["common_name"] == $species['common_name']){
        $locality_var = (string) $joined_g['locality'];
        $individual_count_var = (int) $joined_g['individual_count'];
        $latitude_var = (float) $joined_g['latitude'];
        $longitude_var = (float) $joined_g['longitude'];
        $observation_date_var = (string) $joined_g['observation_date'];
        $common_name_var = $joined_g['common_name'];
        $date_to_string = (int) str_replace('-','', $observation_date_var);
        if (! in_array($locality_var, $observationArray) 
            || ! in_array($individual_count_var, $observationArray) 
            || ! in_array($latitude_var, $observationArray) 
            || ! in_array($longitude_var, $observationArray)
            || ! in_array($observation_date_var, $observationArray)
            || ! in_array($common_name_var, $observationArray)
            || ! in_array($date_to_string, $observationArray)){
            $observationArray[] = [$locality_var, $individual_count_var, $latitude_var, $longitude_var, $observation_date_var, $common_name_var, $date_to_string];
        }
        
    }
}

?>

<p> <?php // var_dump($observationArray) ?> </p>

<h1> Observations for <?php echo e($species['common_name']) ?> </h1>

<p>Search for Date Range:</p>

<label for="dateFilterStart">Select Start Date: </label>
<input type="date" id="dateFilterStart">

<label for="dateFilterEnd">Select End Date: </label>
<input type="date" id="dateFilterEnd">

<button onclick="filterTable()">Search</button>

<?php if (empty($species)): ?>
    <p>No observations found in the database.</p>
<?php else: ?>
    <table id="results">
        <thead>
            <tr>
                <th>locality</th>
                <th>individual_count</th>
                <th>latitude</th>
                <th>longitude</th>
                <th>observation_date</th>
                <th>Common Name</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php foreach ($observationArray as $item): ?>
                <?php if ($item[5] = $pageTitle): ?>
                    <tr>
                        <!-- Locality [0], String -->
                        <?php if(strlen($item[0]) > 0): ?>
                            <td><?php echo e($item[0]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Locality Not Registered"; ?></td>
                        <?php endif ?>
                        <!-- Count [1], Int -->
                        <?php if(!is_null($item[1])): ?>
                            <td><?php echo e($item[1]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Count not registered"; ?></td>
                        <?php endif ?>
                        <!-- Latitude [2], Float -->
                        <?php if(!is_null($item[2])): ?>
                            <td><?php echo e($item[2]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>
                        <!-- Longitude [3], Float -->
                        <?php if(!is_null($item[3])): ?>
                            <td><?php echo e($item[3]); ?></td>
                        <?php else: ?>
                            <td><?php echo "N/A"; ?></td>
                        <?php endif ?>
                        <!-- Observation Date [4] -->
                        <?php if(strlen($item[4]) > 0): ?>
                            <td><?php echo e($item[4]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Observation Date Not Registered"; ?></td>
                        <?php endif ?>
                        <!-- Common Name [5] -->
                        <?php if(!is_null($item[5])): ?>
                            <td><?php echo e($item[5]); ?></td>
                        <?php else: ?>
                            <td><?php echo "Common Name Not Registered"; ?></td>
                        <?php endif ?>
                    </tr>
                <?php endif ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="js/species.js" defer></script>

<?php require_once 'includes/footer.php'; ?>
</body>