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
}
?>