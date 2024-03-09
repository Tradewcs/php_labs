<?php
function load_data($connection) {
    if (!$connection) {
        return;
    }

    $sql = "SELECT * FROM privateenterprenuers";
    $records = $connection->query($sql);

    $res_arr = [];
    while ($row = $records->fetch_assoc()) {
        $res_arr[] = $row;
    }

//     $connection->query("DELETE t1
// FROM privateenterprenuers t1
// JOIN privateenterprenuers t2 ON t1.name = t2.name AND t1.id > t2.id;
// ");

    return $res_arr;
}

function print_table($arr_data) {
    $htmlTable = "<table border='1'>
                <tr>
                    <th>№</th>
                    <th>Прізвище та Ім'я</th>
                    <th>Дата реєстрації</th>
                    <th>Адреса</th>
                    <th>Розмір податку</th>
                    <th>Сфера надання послуг</th>
                </tr>";


    foreach ($arr_data as $row) {
        $htmlTable .= "<tr>
                    <td>{$row["id"]}</td>
                    <td>{$row["name"]}</td>
                    <td>{$row["date"]}</td>
                    <td>{$row["city"]}</td>
                    <td>{$row["postal_code"]}</td>
                    <td>{$row["position"]}</td>
                </tr>";
    }

    $htmlTable .= "</table>";

    echo $htmlTable;
}

function calculate_average_tax($arr_data) {
    $sum = 0;
    foreach ($arr_data as $row) {
        $sum += $row["postal_code"];
    }

    return $sum / count($arr_data);
}

function getPrivateEntrepreneursThatInclude($privateEnterpreneurs, $symbols) {
    $res = [];

    foreach ($privateEnterpreneurs as $human) {
        if (strpos($human["name"], $symbols)) {
            $res[] = $human;
        }
    }

    return $res;
}
?>