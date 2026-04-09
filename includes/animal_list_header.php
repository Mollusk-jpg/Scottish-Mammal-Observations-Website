<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Scottish Mammal Observations Database</title>
    <link rel="stylesheet" href="css/reset.css">
    <!-- Students: Add your CSS stylesheet link here -->

<style>
* {box-sizing: border-box;}

body { 
margin: 0;
font-family: Arial, Helvetica, sans-serif;
}

.logo {
    height: 10%; 
    width: 10%;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 180px;
    margin: 0 auto;
}

.header {
overflow: hidden;
background-color: #f1f1f1;
padding: 20px 10px;
background-image: url('images/background.jpg'); 
background-size: cover;
width: 100%;
background-position: 0px -250px;
background-repeat: no-repeat;
}



.header a {
float: left;
color: black;
text-align: center;
padding: 12px;
text-decoration: none;
font-size: 18px; 

border-radius: 4px;
}

.header a.logo {
    font-size: 20px;
    font-weight: bold;
}

.header a:hover {
    background-color: #5e5b5b;
    color: black;
}

.header a.active {
    background-color: black;
    color: white;
}

.header-right {
    float: right;
}

@media screen and (max-width: 500px) {
    .header a {
    float: none;
    display: block;
    text-align: left;
    }
.header-right {
    float: none;
}
}

</style>
</head>
<body bgcolor=10160B>

<div class="header">
    <div>
        <a href="#PLACEHOLDER" class="logo">
            <img src="images/logo_SMO.png" style="height: 100%;"/>
        </a>
    </div>
    <div class="header-right">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <a class="active" href="about.php">A-Z List</a>
    </div>
</div>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">Animal List</a>
            <a href="observations.php">Observations</a>
            <a href="add_observation.php">Add Observations</a>

            <!-- Students: Add more navigation links here -->
        </nav>
    </header>
    <main>
