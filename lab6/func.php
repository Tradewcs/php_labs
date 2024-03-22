<?php
function print_table($data) {
    $htmlTable = "<table border='1'>
                <tr>
                    <th>№</th>
                    <th>Прізвище та Ім'я</th>
                    <th>Дата реєстрації</th>
                    <th>Адреса</th>
                    <th>Розмір податку</th>
                    <th>Сфера надання послуг</th>
                </tr>";


    while ($row = $data->fetch_assoc()) {
        $htmlTable .= "<tr>
                    <td>{$row["id"]}</td>
                    <td>{$row["name"]}</td>
                    <td>{$row["registration_date"]}</td>
                    <td>{$row["address"]}</td>
                    <td>{$row["tax"]}</td>
                    <td>{$row["service_type"]}</td>
                </tr>";
    }

    $htmlTable .= "</table>";

    echo $htmlTable;
}

function load_file_info() {
    $filename = '../input/pp.txt';

    if (file_exists($filename)) {
        $fileContent = file($filename);

        $data = [];
        foreach ($fileContent as $line) {
            $values = explode(", ", $line);
            $data[] = $values;
        }
    } else {
        echo '<p> Файл не знайдено </p>';
    }

    return $data;
}

function create_tables($conn) {
    $sql_users = "
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    tax INT NOT NULL,
    service_id INT,
)
";

$sql_user_addresses = "
CREATE TABLE user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    city_id INT NOT NULL,
    address VARCHAR(30) NOT NULL,
)
    ";

    $sql_cities = "
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
)
    ";

    $sql_services = "
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
)
    ";

    mysqli_query($conn, $sql_users);
    mysqli_query($conn, $sql_user_addresses);
    mysqli_query($conn, $sql_cities);
    mysqli_query($conn, $sql_services);
}

function add_data($conn, $data) {
    foreach ($data as $row) {
        $date = DateTime::createFromFormat('d/m/Y', $row[1]);
        
        $sql1 = "INSERT INTO users (name, address) VALUES ('" . $row[0] . "', '" . $row[3] . "')";
        $conn->query($sql1);

        $last_id = $conn->insert_id;
        $sql2 = "INSERT INTO users_info (id, registration_date, tax, service_type) VALUES ('" . $last_id . "', '" . $date->format('Y-m-d') . "', '" . $row[2] .  "', '" . $row[4] . "')";
        $conn->query($sql2);

    }
}

?>