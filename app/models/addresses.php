<?php

class Addresses extends Validator
{


    private $address = null;
    private $client_id = null;

    public function setAddress($value)
    {

        if ($this->validateText($value)) {

            $this->address = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setClientId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function getAddress(){
        return $this->address;
    }

    public function getClientId(){
        return $this->client_id;
    }   



    public function saveAddress(){

        $sql = 'INSERT INTO addresses (address, client_id) VALUES (?,?)';
        $params = array($this->address, $this->client_id);
        return Database::executeRow($sql, $params);
    }

}
