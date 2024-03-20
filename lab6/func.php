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
                    <td>{$row["date"]}</td>
                    <td>{$row["city"]}</td>
                    <td>{$row["postal_code"]}</td>
                    <td>{$row["position"]}</td>
                </tr>";
    }

    $htmlTable .= "</table>";

    echo $htmlTable;
}
?>