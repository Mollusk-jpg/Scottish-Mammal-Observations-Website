<?php
// THIS IS FOR add_observation.php
// Is run when an observation is being submitted to SQL


// store data values
$id = $_POST['id'] ?? null;
$locality = $_POST['locality'] ?? null;
$individual_count = $_POST['individual_count'] ?? null;
$latitude = $_POST['latitude'] ?? null;
$longitude = $_POST['longitude'] ?? null;
$gbif_species_key = $_POST['gbif_species_key'] ?? null;
$observation_date = $_POST['observation_date'] ?? null;

    // Validation
    $errors = [];

    if (empty($id)) {
        $errors[] = "id is required";
    }

    if (empty($locality)) {
        $errors[] = "locality is required";
    }

    if (empty($individual_count)) {
        $errors[] = "individual_count is required";
    }

    if (empty($latitude)) {
        $errors[] = "latitude is required";
    }

    if (empty($longitude)) {
        $errors[] = "longitude is required";
    }

    if (empty($gbif_species_key)) {
        $errors[] = "gbif_species_key is required";
    }

    if (empty($observation_date)) {
        $errors[] = "observation_date is required";
    }

$host = "localhost";
$dbname = "scottish_mammals";
$username = "root";
$password = "";

$conn = mysqli_connect(hostname: $host,
                username: $username,
                password: $password,
                database: $dbname);

if (mysqli_connect_errno()) {
    die("Connection Error: " . mysqli_connect_error());
}

$sql = "INSERT INTO test_observations (id, locality, individual_count, latitude, longitude, gbif_species_key, observation_date)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "isiiiii",
                        $id,
                        $locality,
                        $individual_count,
                        $latitude,
                        $longitude,
                        $gbif_species_key,
                        $observation_date);

mysqli_stmt_execute($stmt);

$home_link = 'home.php';

echo "observation has been saved.";
echo "<a href='../{$home_link}'>Back to Home Page</a>";
?> 