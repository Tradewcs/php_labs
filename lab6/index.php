<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require __DIR__ . '/func.php';


$servername = "localhost";
$username = "root";
$password = "";
$database = "pe";

$conn = mysqli_connect($servername, $username, $password, $database);
if (mysqli_connect_errno()) {
    die("". mysqli_connect_error());
}

// $sql = "
// CREATE TABLE users (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     name VARCHAR(50) NOT NULL,
//     address VARCHAR(50) NOT NULL
// )
// ";

// $sql = "
// CREATE TABLE users_info (
//     id INT PRIMARY KEY,
//     registration_date DATE NOT NULL,
//     tax INT,
//     service_type VARCHAR(50) NOT NULL
// )
// ";


$sql = "
SELECT *
FROM users
JOIN users_info ON 
";
$data = mysqli_query($conn, $sql);


?>
</body>
</html>