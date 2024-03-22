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
require __DIR__ . '/../config.php';



$conn = mysqli_connect($servername, $username, $password, $database);
if (mysqli_connect_errno()) {
    die("". mysqli_connect_error());
}

// $sql = "CREATE DATABASE pe";
// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }

// create_tables($conn);
// clear_tables($conn);
// add_data($conn, load_file_info());


$sql = "
SELECT users.name AS user_name, cities.name AS city_name, services.name AS service_name
FROM users
INNER JOIN user_addresses ON users.id = user_addresses.user_id
INNER JOIN cities ON user_addresses.city_id = cities.id
LEFT JOIN services ON users.service_id = services.id;
";
// $sql = "
// SELECT *
// FROM users_info
// ";
$data = mysqli_query($conn, $sql);
print_table($data);

// var_dump($data);	

?>


<form class="form_add_new_record" action="addRecord.php" method="post">
    <br>
    <br>
    <br>
    <input type="text" name="name" placeholder="Прізвище та Ім'я">
    <br>    <br>
    <input type="text" name="registration_date" placeholder="Дата реєстрації">
    <br>    <br>
    <input type="number" name="tax" placeholder="Розмір податку">
    <br>    <br>
    <input type="text" name="address" placeholder="Адреса">
    <br>    <br>
    <input type="text" name="service_type" placeholder="Сфера надання послуг">
    <br>    <br>



    <input type="submit" name="addButton" value="Додати запис">
</form>

<br>
<br>

<form method="post">
    <input type="text" name="symbols">
    <input type="submit" name="getPEButton" value="Отримати ПП">
</form>

<br>
<br>

<?php

if (array_key_exists('getPEButton', $_POST)) {
    $symbols = $_POST['symbols'];

    $sql = "
SELECT *
FROM users
JOIN users_info ON users.id = users_info.id
WHERE name LIKE '%$symbols%';
    ";
    $pe =  $conn->query($sql);

    print_table($pe);
}

?>
<br>
<br>

</body>
