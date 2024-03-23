<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/func.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $tax = $_POST["tax"];
    $city = $_POST["city"];
    $address = $_POST["address"];
    $service_type = $_POST["service"];

    $conn = mysqli_connect($servername, $username, $password, $database);

    // $sql = "SELECT id FROM cities WHERE name = ";
    // $res = $conn->query($sql);
    // var_dump($res->fetch_assoc());


    $sql_users = "INSERT INTO users (name, tax, service_id) VALUES ('" . $name . "', '" . $tax . "', '" . get_service_id($conn, $service_type) . "')";
    $conn->query($sql_users);

    $last_id = $conn->insert_id;
    $sql_address = "INSERT INTO user_addresses (user_id, city_id, address) VALUES ('" . $last_id . "', '" . get_city_id($conn, $city) . "', '" . $address . "')";
    $conn->query($sql_address);
}

?>

<script>
    window.location = 'index.php';
</script>