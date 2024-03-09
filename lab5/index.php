<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        input {
            width: 250px;
            height: 20px;
        }

        input[type="submit"] {
            width: 100px;
        }
    </style>
</head>
<body>

<?php
require __DIR__ . '/fucntions.php';

$servername = "localhost";
$username = "root";
$password = "";
$database = "pe";

$conn = mysqli_connect($servername, $username, $password, $database);

$pe = load_data($conn);
// print_r($pe);


print_table($pe);

mysqli_close($conn);

?>

<br>
<br>
<form class="form_add_new_record" action="addRecord.php" method="post">
    <input type="text" name="name" placeholder="Прізвище та Ім'я">
    <br>
    <br>
    <input type="text" name="date" placeholder="Дата реєстрації">
    <br>
    <br>
    <input type="number" name="postal_code" placeholder="Розмір податку">
    <br>
    <br>
    <input type="text" name="city" placeholder="Адреса">
    <br>
    <br>
    <input type="text" name="position" placeholder="Сфера надання послуг">
    <br>
    <br>

    <input type="submit" name="addButton" value="Додати запис">
</form>

<br>
<br>

<?php
echo "Середній податок: ";
echo calculate_average_tax($pe);
?>

<br>
<br>

<?php

usort($pe, function($a, $b) {
    return $a["postal_code"] - $b["postal_code"];
});

echo "Посортовані дані: \n";
print_table($pe);
?>


<br>
<form method="post">
    <input type="text" name="symbols" placeholder="підрядок у імені ПП">
    <input type="submit" name="getPEButton" value="Отримати ПП">
</form>

<?php
    if (array_key_exists('getPEButton', $_POST)) {
        $symbols = $_POST['symbols'];
        echo "ПП, що містять \"$symbols\": \n";
        $res = getPrivateEntrepreneursThatInclude($pe, $symbols);
        print_table($res);
    }
?>

</body>
</html>