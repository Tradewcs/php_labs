<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/func.php';
require __DIR__ . '/privateEnterpreneur.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $tax = $_POST["tax"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $service_type = $_POST["service"];
    $reg_date = $_POST["registration_date"];

    $pe = new PrivateEntrepreneur($name, $tax, $address, $city, $service_type, $reg_date);

    $conn = mysqli_connect($servername, $username, $password, $database);

    // var_dump($reg_date);

    writePEToDatabase($conn, $pe);
}

?>

<script>
    window.location = 'index.php';
</script>