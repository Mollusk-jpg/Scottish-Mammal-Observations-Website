<?php

require_once 'includes/config.php';
require_once 'includes/db.php';

$pageTitle = 'All Observations';

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

require_once 'includes/animal_list_header.php';
?>

<head>
    <link rel="stylesheet" href="css/style.css">
<style>
.searchbox {
    position: absolute;
    top: 25%;
    left: 50%;
    transform: translateX(-50%);
    
    
}
input[type=text] {
    float: right;
    padding: 6px;
    border: none;
    margin-top: 8px;
    margin-right: 16px;
    font-size: 17px;
}
</style>
</head>
<body>

<form class='searchbox'>
    <input class="searchbar" type="text" placeholder="Search.." name="search">
</form>

<section class="cards">
<?php if (empty($species_names)): ?>
    <p>No species names found in the database.</p>
<?php else: ?>

        <?php   foreach ($species_names as $names): ?>

        <section class="cards">
            <div class="card">
            <div class="card-box">700 x 300</div>
            <p style="color:white; font-size:1.5rem;"><?php echo e($names['common_name']); ?></p>
            <a href="view_animal.php?key=<?php echo e($names['gbif_species_key']); ?>">Details</a>
            </div>

        <?php   endforeach;?>
<?php endif; ?>

<!--
<?php if (empty($species_names)): ?>
    <p>No species names found in the database.</p>
<?php else: ?>

        <?php   foreach ($species_names as $names): ?>
        <div class="center" id="something">
        <div class="card">
                <div class="container">
                    <div>
                        <h1><?php echo e($names['common_name'][0]); ?></h1>
                    </div>
                    <a href="view_animal.php?key=<?php echo e($names['gbif_species_key']); ?>"><?php echo e($names['common_name']); ?></a>
                    <p><?php echo e($names['species_name']); ?></p>
                </div>
            </div>
        </div>
        <?php   endforeach;?>
<?php endif; ?>
        -->

<script>
const searchEl = document.querySelector('.searchbox');
const x = document.querySelectorAll('.card p:nth-child(2)');

function search(e){
    x.forEach((item,index) => {
        if(!item.innerHTML.toLowerCase().includes(e.target.value)){
        item.parentElement.style.display = 'none';
        }else {
        item.parentElement.style.display = 'block';
        }
    })
}

searchEl.addEventListener("keyup", search); 
</script>

</body>
</html>