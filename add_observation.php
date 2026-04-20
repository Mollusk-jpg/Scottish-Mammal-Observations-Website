<?php
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
    <h1> Add Observation </h1>

    <form action="includes/process_observation.php" method="post">
        <div>
        <label for="id">id</label>
        <input type="number" id="id" name="id">
        </div>

        <div>
        <label for="locality">locality</label>
        <input type="text" id="locality" name="locality">
        </div>

        <div>
        <label for="individual_count">individual_count</label>
        <input type="number" id="individual_count" name="individual_count">
        </div>

        <div>
        <label for="latitude">latitude</label>
        <input type="number" id="latitude" name="latitude">
        </div>

        <div>
        <label for="longitude">longitude</label>
        <input type="number" id="longitude" name="longitude">
        </div>

        <div>
        <label for="gbif_species_key">gbif_species_key</label>
        <input type="number" id="gbif_species_key" name="gbif_species_key">
        </div>

        <div>
        <label for="observation_date">observation_date</label>
        <input type="number" id="observation_date" name="observation_date">
        </div>
    
        <br>
        <button>Send</button>
    </form>
</main>
</body>
</html>