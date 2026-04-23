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

$observations = getAllObservations();

$pdo = getDbConnection();

// Fetch species details and observation details, link by gbif_id
$stmt = $pdo->prepare('
    SELECT
        observations.id,
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
<style>
        table {
            margin: auto;
        }

        #pagination {
            text-align: center;
        }
        
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
        }
</style>

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
$observation_id = 0;

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
        $observation_id = (int) $joined_g['id'];
        if (! in_array($locality_var, $observationArray) 
            || ! in_array($individual_count_var, $observationArray) 
            || ! in_array($latitude_var, $observationArray) 
            || ! in_array($longitude_var, $observationArray)
            || ! in_array($observation_date_var, $observationArray)
            || ! in_array($common_name_var, $observationArray)
            || ! in_array($observation_id, $observationArray)){
            $observationArray[] = [$locality_var, $individual_count_var, $latitude_var, $longitude_var, $observation_date_var, $common_name_var, $observation_id];
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

<table id="myTable">
    <tr>
        <th>locality</th>
        <th>individual_count</th>
        <th>latitude</th>
        <th>longitude</th>
        <th>observation_date</th>
        <th>CRUD</th>
    </tr>

</table>
<div id="pagination"></div>



<script>
// This is for sort by date:
function filterTable() {
    let inputStart = document.getElementById("dateFilterStart").value;
    let inputEnd = document.getElementById("dateFilterEnd").value;
    let table = document.getElementById("tableBody");
    let rows = table.getElementsByTagName("tr");
    
    for (let i = 0; i < rows.length; i++) {
        let dateCell = rows[i].getElementsByTagName("td")[4];

        if (dateCell) {
            let dateValue = dateCell.textContent || dateCell.innerText;
            if(dateValue < inputStart){
                rows[i].style.display = dateValue === inputStart ? "" : "none";
            }
            if (dateValue > inputEnd){
                rows[i].style.display = dateValue === inputEnd ? "" : "none";
            }
                
        }
    }
}
// This is for pagination:
var tempArray = <?php echo json_encode($observationArray); ?>;

console.log(tempArray);
    const rowsPerPage = 50;
    let currentPage = 1;

    function displayTable(page) {
        const table = document.getElementById("myTable");
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const slicedData = tempArray.slice(startIndex, endIndex);

            // Clear existing table rows
            table.innerHTML = `
        <tbody id="tableBody">
        <tr>
            <th>locality</th>
            <th>individual_count</th>
            <th>latitude</th>
            <th>longitude</th>
            <th>observation_date</th>
            <th>CRUD</th>
        </tr>
        </tbody>
    `;

            // Add new rows to the table
            slicedData.forEach(tempArray => {
                const row = table.insertRow();
                const localityCell = row.insertCell(0);
                const countCell = row.insertCell(1);
                const latitudeCell = row.insertCell(2);
                const longitudeCell = row.insertCell(3);
                const observation_dateCell = row.insertCell(4);
                const CRUD_Cell = row.insertCell(5);

                localityCell.innerHTML = tempArray[0];
                countCell.innerHTML = tempArray[1];
                latitudeCell.innerHTML = tempArray[2];
                longitudeCell.innerHTML = tempArray[3];
                observation_dateCell.innerHTML = tempArray[4];
                key = tempArray[6];
                CRUD_Cell.innerHTML = "<td><a href='add_observation.php?id=" + key + "'>Edit</a></td>";
            });

            // Update pagination
            updatePagination(page);
        }

        function updatePagination(currentPage) {
            const pageCount = Math.ceil(tempArray.length / rowsPerPage);
            const paginationContainer = document.getElementById("pagination");
            paginationContainer.innerHTML = "";

            for (let i = 1; i <= pageCount; i++) {
                const pageLink = document.createElement("a");
                pageLink.href = "#";
                pageLink.innerText = i;
                pageLink.onclick = function () {
                    displayTable(i);
                };
                if (i === currentPage) {
                    pageLink.style.fontWeight = "bold";
                }
                paginationContainer.appendChild(pageLink);
                paginationContainer.appendChild(document.createTextNode(" "));
            }
        }

        // Initial display
        displayTable(currentPage);

</script>

<?php require_once 'includes/footer.php'; ?>
</body>
</html>