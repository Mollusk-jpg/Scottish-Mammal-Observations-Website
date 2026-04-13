
<html>
<body>
<main>
    <h1> Add Observation </h1>

    <form action="includes/process_observation.php" method="post">
        <label for="id">id</label>
        <input type="number" id="id" name="id">

        <label for="locality">locality</label>
        <input type="text" id="locality" name="locality">

        <label for="individual_count">individual_count</label>
        <input type="number" id="individual_count" name="individual_count">

        <label for="latitude">latitude</label>
        <input type="number" id="latitude" name="latitude">

        <label for="longitude">longitude</label>
        <input type="number" id="longitude" name="longitude">

        <label for="gbif_species_key">gbif_species_key</label>
        <input type="number" id="gbif_species_key" name="gbif_species_key">

        <label for="observation_date">observation_date</label>
        <input type="number" id="observation_date" name="observation_date">
    
        <br>
        <button>Send</button>
    </form>
</main>
</body>
</html>