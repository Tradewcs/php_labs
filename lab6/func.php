<?php
function print_table($data) {
    $htmlTable = "<table border='1'>
                <tr>
                    <th>Прізвище та Ім'я</th>
                    <th>Адреса</th>
                    <th>Розмір податку</th>
                    <th>Сфера надання послуг</th>
                </tr>";


    while ($row = $data->fetch_assoc()) {
        $htmlTable .= "<tr>
                    <td>{$row["user_name"]}</td>
                    <td>{$row["city_name"]}</td>
                    <td>{$row["user_tax"]}</td>
                    <td>{$row["service_name"]}</td>
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

function fill_cities($conn) {
    $regional_centers = [
        "Вінниця", "Дніпро", "Донецьк", "Житомир", "Запоріжжя", "Івано-Франківськ", "Київ", 
        "Кропивницький", "Луганськ", "Луцьк", "Львів", "Миколаїв", "Одеса", "Полтава", 
        "Рівне", "Суми", "Тернопіль", "Ужгород", "Харків", "Херсон", "Хмельницький", "Черкаси", 
        "Чернівці", "Чернігів", "Сімферополь"
    ];
    
    foreach ($regional_centers as $city) {
        $sql = "INSERT INTO cities (name) VALUES ('$city')";
        $conn->query($sql);
    }
}

function fill_services($conn) {
    $sectors = [
        "IT", "Медицина", "Фінанси", "Маркетинг", "Продажі", "Архітектура", 
        "Юриспруденція", "Мистецтво", "Наука", "Спорт", "Харчова промисловість", "Туризм", 
        "Транспорт", "Енергетика", "Будівництво", "Готельно-ресторанний бізнес", "Дизайн", 
        "Логістика", "Медіа", "Сільське господарство", "Технічні послуги", "Охорона здоров'я", 
        "Освіта", "Право", "Фітнес та спортивні заходи"
    ];

    foreach ($sectors as $sector) {
        $sql = "INSERT INTO services (name) VALUES ('$sector')";
        $conn->query($sql);
    }
}

function create_tables($conn) {
    $sql_users = "
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        tax INT NOT NULL,
        service_id INT
    )";
    
    $sql_user_addresses = "
    CREATE TABLE user_addresses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        city_id INT NOT NULL,
        address VARCHAR(30) NOT NULL
    )";
    
    $sql_cities = "
    CREATE TABLE cities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL
    )";
    
    $sql_services = "
    CREATE TABLE services (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL
    )";

    mysqli_query($conn, $sql_users);
    mysqli_query($conn, $sql_user_addresses);
    mysqli_query($conn, $sql_cities);
    mysqli_query($conn, $sql_services);
}

function get_service_id($conn, $service_name) {
    $sql = "SELECT id FROM services WHERE name = \"$service_name\"";
    $res = $conn->query($sql);
    return $res->fetch_assoc()['id'];
}

function get_city_id($conn, $city_name) {
    $sql = "SELECT id FROM cities WHERE name = \"$city_name\"";
    $res = $conn->query($sql);
    var_dump($res);
    return $res->fetch_assoc()['id'];
}

function insert_data($conn, $data) {
    foreach ($data as $row) {
        $date = DateTime::createFromFormat('d/m/Y', $row[1]);
        
        $sql1 = "INSERT INTO users (name, address) VALUES ('" . $row[0] . "', '" . $row[3] . "')";
        $conn->query($sql1);

        $last_id = $conn->insert_id;
        $sql2 = "INSERT INTO users_info (id, registration_date, tax, service_type) VALUES ('" . $last_id . "', '" . $date->format('Y-m-d') . "', '" . $row[2] .  "', '" . $row[4] . "')";
        $conn->query($sql2);

    }
}

function get_services($conn) {
    $sql = "SELECT name FROM services";
    $result = $conn->query($sql);
    $services = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row['name'];
        }
    }
    return $services;
}


function generate_dropdown_services($options, $selected = null) {
    $html = '<select name="service">';
    foreach ($options as $option) {
        $selected_attr = ($selected == $option) ? 'selected' : '';
        $html .= "<option value='$option' $selected_attr>$option</option>";
    }
    $html .= '</select>';
    return $html;
}

function get_cities($conn) {
    $sql = "SELECT name FROM cities";
    $result = $conn->query($sql);
    $cities = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row['name'];
        }
    }
    return $cities;
}

function generate_dropdown_cities($options, $selected = null) {
    $html = '<select name="city">';
    foreach ($options as $option) {
        $selected_attr = ($selected == $option) ? 'selected' : '';
        $html .= "<option value='$option' $selected_attr>$option</option>";
    }
    $html .= '</select>';
    return $html;
}

?>