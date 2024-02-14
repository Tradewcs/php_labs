<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


<h2>Лабораторна робота №4</h2>


<?php


class PrivateEntrepreneur {
    private $fullName;
    private $registrationDate;
    private $taxAmount;
    private $residenceAddress;
    private $serviceArea;

    public function __construct($fullName, $registrationDate, $taxAmount, $residenceAddress, $serviceArea) {
        $this->fullName = $fullName;
        $this->registrationDate = $registrationDate;
        $this->taxAmount = $taxAmount;
        $this->residenceAddress = $residenceAddress;
        $this->serviceArea = $serviceArea;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getRegistrationDate() {
        return $this->registrationDate;
    }

    public function getTaxAmount() {
        return $this->taxAmount;
    }

    public function getResidenceAddress() {
        return $this->residenceAddress;
    }

    public function getServiceArea() {
        return $this->serviceArea;
    }
}


function print_and_load_file_info() {
    $privateEnterpreneurs = [];

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

            $human = new PrivateEntrepreneur(...$values);
            $privateEnterpreneurs[] = $human;
            // print_r($human);
        }

        $htmlTable .= "</table>";

        echo $htmlTable;
    }

    return $privateEnterpreneurs;
}

function privateEnterpreneursToTable($privateEnterpreneurs) {
    $htmlTable = "<table border='1'>
    <tr>
        <th>№</th>
        <th>Прізвище та Ім'я</th>
        <th>Дата реєстрації</th>
        <th>Розмір податку</th>
        <th>Адреса</th>
        <th>Сфера надання послуг</th>
    </tr>";

    $recordsCount = 0;
    foreach ($privateEnterpreneurs as $human) {
        $recordsCount++;

        $htmlTable .= "<tr>
                <td>{$recordsCount}</td>
                <td>{$human->getFullName()}</td>
                <td>{$human->getRegistrationDate()}</td>
                <td>{$human->getTaxAmount()}</td>
                <td>{$human->getResidenceAddress()}</td>
                <td>{$human->getServiceArea()}</td>
            </tr>";

    }

    $htmlTable .= "</table>";

    return $htmlTable;
}


function getPrivateEntrepreneursThatInclude($privateEnterpreneurs, $symbols) {
    $res = [];

    foreach ($privateEnterpreneurs as $human) {
        $sht = strpos($human->getFullName(), $symbols);
        echo $sht;
        if (strpos($human->getFullName(), $symbols)) {
            $res[] = $human;
        }
    }

    return $res;
}

function main() {
    $symbols = $_POST['symbols'];
    echo 'symb: ' . $symbols;

    echo 'Дані з файлу:';
    echo "<br> <br>";
    $privateEnterpreneurs = print_and_load_file_info($privateEnterpreneurs);
    
    echo "<br> <br>";
    echo "ПП, які містять {$symbols}:";

    if (array_key_exists('getPEButton', $_POST)) {
        echo "<br> <br>";
        $res = getPrivateEntrepreneursThatInclude($privateEnterpreneurs, "c");
        echo privateEnterpreneursToTable($res);
    }
}

main();

?>

<br>
<form method="post">
    <input type="text" name="symbols">
    <input type="submit" name="getPEButton" value="Отримати ПП">
</form>

</body>
</html>
