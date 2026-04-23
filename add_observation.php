<?php
require_once 'includes/db.php';

$observation_id = null;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM observations WHERE id=$id");
    $observation_id = $stmt->fetchAll();
}


require_once 'includes/animal_list_header.php';
?>

<html>

<head>
<style>
body{
    color: white;
}
    form {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }
</style>
</head>
<link rel="stylesheet" href="css/contact_style.css">
<body>
<main>

<!-- <a style="color: royalblue;" href="species.php?key=<?= e($observation_id['gbif_species_key']); ?>"> -->
<?php if(!is_null($observation_id)): ?>
    <h1 style="color: SpringGreen;"> Update Observation </h1>
    <!-- <h2><a style="color: royalblue;" href="species.php?key=<?= e($observation_id['gbif_species_key']); ?>">Back</a></h2> -->
<?php else: ?>
    <h1>Add Observation</h1>
<?php endif ?>
    

    <form action="includes/process_observation.php" method="post">
        <div>
        <label for="id">id</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="number" id="id" name="id" value="<?= $observation_id[0]['id'] ?>" >
        <?php else: ?>
            <input type="number" id="id" name="id" >
        <?php endif ?>
        </div>

        <div>
        <label for="locality">locality</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="text" id="locality" name="locality" value="<?= $observation_id[0]['locality'] ?>">
        <?php else: ?>
            <input type="text" id="locality" name="locality">
        <?php endif ?>
        </div>

        <div>
        <label for="individual_count">individual_count</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="number" id="individual_count" name="individual_count" value="<?= $observation_id[0]['individual_count'] ?>">
        <?php else: ?>
            <input type="number" id="individual_count" name="individual_count">
        <?php endif ?>
        </div>

        <div>
        <label for="latitude">latitude</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="number" id="latitude" name="latitude" value="<?= $observation_id[0]['latitude'] ?>">
        <?php else: ?>
            <input type="number" id="latitude" name="latitude">
        <?php endif ?>
        </div>

        <div>
        <label for="longitude">longitude</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="number" id="longitude" name="longitude" value="<?= $observation_id[0]['longitude'] ?>">
        <?php else: ?>
            <input type="number" id="longitude" name="longitude">
        <?php endif ?>
        </div>

        <div>
        <label for="gbif_species_key">gbif_species_key</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="number" id="gbif_species_key" name="gbif_species_key" value="<?= $observation_id[0]['gbif_species_key'] ?>">
        <?php else: ?>
            <input type="number" id="gbif_species_key" name="gbif_species_key">
        <?php endif ?>
        </div>

        <div>
        <label for="observation_date">observation_date</label>
        <?php if(!is_null($observation_id)): ?>
            <input type="date" id="observation_date" name="observation_date" value="<?= $observation_id[0]['observation_date'] ?>">
        <?php else: ?>
            <input type="date" id="observation_date" name="observation_date">
        <?php endif ?>
        </div>
    
        <br>
        <?php if(!is_null($observation_id)): ?>
            <button>Update</button>
        <?php else: ?>
            <button>Send</button>
        <?php endif ?>
    </form>

</main>
</body>
</html>