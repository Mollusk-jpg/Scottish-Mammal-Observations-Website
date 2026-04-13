<?php 
// This is for the contact form. 

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$message = $_POST['message'] ?? null;

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = "name is required";
}

if (empty($email)) {
    $errors[] = "email is required";
}

if (empty($phone)) {
    $errors[] = "phone is required";
}

if (empty($message)) {
    $errors[] = "message is required";
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

$sql = "INSERT INTO test_message (name, email, phone, message)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)){
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssis",
                        $name,
                        $email,
                        $phone,
                        $message);

mysqli_stmt_execute($stmt);

echo "message has been saved."

?>