<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Лабороторна робота №3</h2>

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
/*
$entrepreneur = new PrivateEntrepreneur(
    "John Doe",
    "2022-02-06",
    1000.00,
    "123 Main Street, Cityville",
    "Consulting Services"
);
*/


$privateEntreprenueurs = [];

$filename = '../input/pp.txt';


if (file_exists($filename)) {
    $fileContent = file($filename);

    $recordsCount = 0;
    $totalTax = 0;
    foreach ($fileContent as $line) {
        
        $values = explode(", ", $line);
        
        $privateEntreprenueurs[] = new PrivateEntrepreneur(...$values);
        $totalTax += $privateEntreprenueurs[$recordsCount]->getTaxAmount(); 
        
        
        $recordsCount++;

    }


    // print_r($privateEntreprenueurs);
    // echo $privateEntreprenueurs[0]->getFullName();
}

function print_array($privateEntreprenueurs) {
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
        foreach ($privateEntreprenueurs as $record) {
            $recordsCount++;

            $htmlTable .= "<tr>
                    <td>{$recordsCount}</td>
                    <td>{$record->getFullName()}</td>
                    <td>{$record->getRegistrationDate()}</td>
                    <td>{$record->getTaxAmount()}</td>
                    <td>{$record->getResidenceAddress()}</td>
                    <td>{$record->getServiceArea()}</td>
                </tr>";

        }

        $htmlTable .= "</table>";
        echo $htmlTable;

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

    }
}

function compareByTaxAmount($a, $b) {
    return $a->getTaxAmount() - $b->getTaxAmount();
}

usort($privateEntreprenueurs, 'compareByTaxAmount');

echo 'Дані з файлу';
load_file_info();
echo 'Загальний податок: ' . $totalTax;

echo '<br>';
echo '<br>';
echo '<br>';
echo 'Посортовані дані';
print_array($privateEntreprenueurs);


?>

<a class="home" href="http://localhost/php/lab1/index.html">На головну</a>

</body>
</html>