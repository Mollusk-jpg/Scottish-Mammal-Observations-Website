<?php

require_once 'includes/db.php';

$pageTitle = 'All Species';
$image_number = 0;

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

require_once 'includes/animal_list_header.php';
?>

<head>
    <link rel="stylesheet" href="css/image_popup.css">
    <style>
        body {
            background-color: lightblue;
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

<h2 class="center">Advanced Search for Scottish Mammal Species</h2>



<p >Explore our database of 34 mammal species found in Scotland.</p>

<!-- Search Bar --> 
<input type="text" id="myInputName" onkeyup="mySearchFunctionNames()" placeholder="Search for Names">

<input type="text" id="myInputCStatus" onkeyup="mySearchFunctionCStatus()" placeholder="Search for Con. Status">

<input type="text" id="myInputDiet" onkeyup="mySearchFunctionDiet()" placeholder="Search for Diet Category">

<input type="text" id="myInputHabitat" onkeyup="mySearchFunctionHabitat()" placeholder="Search for Habitat">

<?php if (empty($species)): ?>
    <p>No species found in the database.</p>
<?php else: ?>
    <table id="myTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)" style="cursor:pointer">Common Name</th>
                <th onclick="sortTable(1)" style="cursor:pointer">Scientific Name</th>
                <th onclick="sortTable(2)" style="cursor:pointer">Conservation Status</th>
                <th onclick="sortTable(3)" style="cursor:pointer">Dietary Category</th>
                <th onclick="sortTableNumber(4)" style="cursor:pointer">Body Mass (kg)</th>
                <th onclick="sortTable(5)" style="cursor:pointer">Habitat</th>
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
                    <td>
                        <img class="myImages" src="<?php echo e($sp['image_url']) ?>" style="width:50px;height:50px;" >
                        <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
<script src="js/indexJS.js" defer></script>

<?php require_once 'includes/footer.php'; ?>
