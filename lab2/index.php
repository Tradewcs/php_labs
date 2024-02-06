<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Лабораторна робота №2</h2>

<form class="form_get_data" method="post">
    <input type="submit" name="readButton" value="Зчитати дані з файлу">
</form>


<?php
if (array_key_exists('readButton', $_POST)) {
    load_file_info();
}




function load_file_info() {
    $htmlTable = "<table border='1'>
                <tr>
                    <th>№</th>
                    <th>Прізвище та Ім'я</th>
                    <th>Дата реєстрації</th>
                    <th>Розмір податку</th>
                    <th>Адреса</th>
                    <th>Сфера надання послуг</th>
                </tr>";


    $filename = '../input/pp.txt';

    if (file_exists($filename)) {
        $fileContent = file($filename);

        $recordsCount = 0;
        foreach ($fileContent as $line) {
            $recordsCount++;

            $values = explode(", ", $line);
            $htmlTable .= "<tr>
                    <td>{$recordsCount}</td>
                    <td>{$values[0]}</td>
                    <td>{$values[1]}</td>
                    <td>{$values[2]}</td>
                    <td>{$values[3]}</td>
                    <td>{$values[4]}</td>
                </tr>";

        }

        $htmlTable .= "</table>";
        echo $htmlTable;
        echo 'Кількість записів у файлі: ' . $recordsCount;

    } else {
        echo '<p> Файл не знайдено </p>';
    }
}
?>

<form class="form_add_new_record" action="addRecord.php" method="post">
    <input type="text" name="fullName" placeholder="Прізвище та Ім'я">
    <input type="text" name="registationDate" placeholder="Дата реєстрації">
    <input type="number" name="taxSize" placeholder="Розмір податку">
    <input type="text" name="address" placeholder="Адреса">
    <input type="text" name="serviceName" placeholder="Сфера надання послуг">



    <input type="submit" name="addButton" value="Додати запис">
</form>

<div class="before_home"></div>
<a class="home" href="http://localhost/php/lab1/index.html">На головну</a>

</body>
</html>