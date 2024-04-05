<?php


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
        registration_date DATE,
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

function arrayToPrivateEntrepreneur($data) {
    $privateEntrepreneurs = [];
    while ($pe = $data->fetch_assoc()) {
        $privateEntrepreneurs[] = new PrivateEntrepreneur(
            $pe['user_name'],
            $pe['user_tax'],
            $pe['address'],
            $pe['city_name'],
            $pe['service_name'],
            $pe['user_date']
        );
    }
        
    return $privateEntrepreneurs;
}

function print_table($entrepreneurs) {
    $htmlTable = "<table border='1'>
                <tr>
                    <th>Full Name</th>
                    <th>Tax Amount</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Registration date</th>
                    <th>Service Area</th>
                </tr>";

    foreach ($entrepreneurs as $pe) {
        $htmlTable .= "<tr>
                    <td>{$pe->getFullName()}</td>
                    <td>{$pe->getTaxAmount()}</td>
                    <td>{$pe->getAddress()}</td>
                    <td>{$pe->getCity()}</td>
                    <td>{$pe->getRegistrationDate()}</td>
                    <td>{$pe->getServiceArea()}</td>
                </tr>";
    }

    $htmlTable .= "</table>";

    echo $htmlTable;
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

function writePEToDatabase($conn, $pe) {
    $sql_users = "INSERT INTO users (name, tax, registration_date, service_id) VALUES ('" . $pe->getFullName() . "', '" . $pe->getTaxAmount() . "', '" . $pe->getRegistrationDate() . "', '" . get_service_id($conn, $pe->getServiceArea()) . "')";
    $conn->query($sql_users);

    $last_id = $conn->insert_id;
    $sql_address = "INSERT INTO user_addresses (user_id, city_id, address) VALUES ('" . $last_id . "', '" . get_city_id($conn, $pe->getCity()) . "', '" . $pe->getAddress() . "')";
    $conn->query($sql_address);

}

function getPEByRegistrationDate($conn, $date) {
    $sql = "
SELECT
    users.name AS user_name, 
    cities.name AS city_name, 
    services.name AS service_name, 
    users.tax AS user_tax
    user_addresses.address AS address
FROM 
    users
INNER JOIN 
    user_addresses ON users.id = user_addresses.user_id
INNER JOIN 
    cities ON user_addresses.city_id = cities.id
LEFT JOIN 
    services ON users.service_id = services.id
WHERE 
    users.registration_date LIKE '$date';
    ";
}

?>