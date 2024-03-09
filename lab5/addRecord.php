<?php
function addRecord($connection, $record) {
    $name = $_POST["name"];
    $date = $_POST["date"];
    $postal_code = $_POST["postal_code"];
    $city = $_POST["city"];
    $position = $_POST["position"];

    $sql = "INSERT INTO privateenterprenuers (name, date, postal_code, city, position) VALUES (\"$name\", \"$date\", \"$postal_code\", \"$city\", \"$position\")";
    $result = $connection->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "pe";

    $conn = mysqli_connect($servername, $username, $password, $database);

    addRecord($conn, $_POST);
}
?>

<script>
    window.location = 'index.php';
</script>