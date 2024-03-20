<?php
require __DIR__ . '/../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $registration_date = $_POST["registration_date"];
    $tax = $_POST["tax"];
    $address = $_POST["address"];
    $service_type = $_POST["service_type"];

    $conn = mysqli_connect($servername, $username, $password, $database);

    $sql1 = "INSERT INTO users (name, address) VALUES ('" . $name . "', '" . $address . "')";
    $conn->query($sql1);

    $last_id = $conn->insert_id;
    $sql2 = "INSERT INTO users_info (id, registration_date, tax, service_type) VALUES ('" . $last_id . "', '" . $registration_date . "', '" . $tax .  "', '" . $service_type . "')";
    $conn->query($sql2);


//     $sql = "
// SELECT *
// FROM users
// JOIN users_info
// ON users.id = users_info.id
// ";
//     var_dump($conn->query($sql));
}

?>

<script>
    window.location = 'index.php';
</script>