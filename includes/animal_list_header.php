<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Scottish Mammal Observations Database</title>
    <link rel="stylesheet" href="css/animal_list_styling.css">
    <!-- Students: Add your CSS stylesheet link here -->
<style>
.header {
    background-image: url('images/background.jpg'); 
}
</style>

</head>
<body bgcolor=10160B>

<div class="header">
    <div>
        <a href="home.php" class="logo">
            <img src="images/logo_SMO.png" style="height: 190px; width: 190px;"/>
        </a>
</div>


    <div class="header-right">
        <a style="color: white;" href="home.php">Home</a>
        <a style="color: white;" href="about_us.php">About</a>
        <a style="color: white;" href="contact.php">Contact</a>
        <!-- <a href="observations.php">Observations</a> -->
        <a style="color: white;" href="add_observation.php">Add Observations</a>
        <a style="color: white;" href="animal_list.php">A-Z List</a>
        <a style="color: white;" href="index.php">Advanced Search</a>
    </div>
</div>
    </header>
    <main>
