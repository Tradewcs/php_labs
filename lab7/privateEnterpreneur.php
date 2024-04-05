<?php
class PrivateEntrepreneur {
    private $fullName;
    private $taxAmount;
    private $address;
    private $city;
    private $serviceArea;
    private $registration_date;

    public function __construct($fullName, $taxAmount, $address, $city, $serviceArea, $registration_date) {
        $this->fullName = $fullName;
        $this->taxAmount = $taxAmount;
        $this->address = $address;
        $this->city = $city;
        $this->serviceArea = $serviceArea;
        $this->registration_date = $registration_date;
    }

    public function getFullName() {
        return $this->fullName;
    }

    public function getTaxAmount() {
        return $this->taxAmount;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getServiceArea() {
        return $this->serviceArea;
    }

    public function getRegistrationDate() {
        return $this->registration_date;
    }

    public function writeToDadabase($conn) {
        $sql_users = "INSERT INTO users (name, tax, registration_date, service_id) VALUES ('" . $this->getFullName() . "', '" . $this->getTaxAmount() . "', '" . $this->getRegistrationDate() . "', '" . get_service_id($conn, $this->getServiceArea()) . "')";
        $conn->query($sql_users);
    
        $last_id = $conn->insert_id;
        $sql_address = "INSERT INTO user_addresses (user_id, city_id, address) VALUES ('" . $last_id . "', '" . get_city_id($conn, $this->getCity()) . "', '" . $this->getAddress() . "')";
        $conn->query($sql_address);
    }

    public static function getByAttribute($conn, $attribute, $value) {
        $atr = [
            "fullName" => "users.name",
            "city" => "cities.name",
            "serviceArea" => "services.name",
            "taxAmount" => "users.tax",
            "address" => "user_addresses.address",
            "registration_date" => "users.registration_date"
        ];

        $sql = "
            SELECT
                users.name AS fullName, 
                cities.name AS city, 
                services.name AS serviceArea, 
                users.tax AS taxAmount,
                user_addresses.address AS address,
                users.registration_date AS registration_date
            FROM 
                users
            INNER JOIN 
                user_addresses ON users.id = user_addresses.user_id
            INNER JOIN 
                cities ON user_addresses.city_id = cities.id
            LEFT JOIN 
                services ON users.service_id = services.id
            WHERE 
                $atr[$attribute] LIKE \"$value\";
        ";

        $privateEnterprenuers = [];

        $res = $conn->query($sql);
        while ($pe = $res->fetch_assoc()) {
            $privateEnterprenuers[] = new PrivateEntrepreneur($pe["fullName"], $pe["taxAmount"], $pe["address"], $pe["city"], $pe["serviceArea"], $pe["registration_date"]);
        }

        return $privateEnterprenuers;
    }
}
?>