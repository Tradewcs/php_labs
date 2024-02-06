<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = $_POST["fullName"];
        $registationDate = $_POST["registationDate"];
        $taxSize = $_POST["taxSize"];
        $address = $_POST["address"];
        $serviceName = $_POST["serviceName"];

        $filePath = '../input/pp.txt';
        // $fileHandle = fopen($filePath, 'w');

        $record = $fullName . ', ' . $registationDate . ', ' . $taxSize . ', ' . $address . ', ' . $serviceName . PHP_EOL;
        file_put_contents($filePath, $record, FILE_APPEND);
        // fclose($fileHandle);

    }
?>

<script>
    // history.pushState({}, '', 'index.php');
    window.location = 'http://localhost/php/lab2/index.php';
</script>