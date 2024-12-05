<?php

class Clients extends Validator
{

    private $client_id = null;
    private $name = null;
    private $lastname = null;
    private $email = null;
    private $phone_number = null;
    private $photo = null;
    private $route = '../../resources/img/clients/';


    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->client_id = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setName($value)
    {

        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->name = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setLastname($value)
    {

        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->lastname = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setEmail($value)
    {
        if ($this->validateEmail($value)) {
            $this->email = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPhoneNumber($value)
    {

        if ($this->validatePhone($value)) {
            $this->phone_number = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPhoto($file)
    {
        if ($this->validateImageFile($file, 5000, 5000)) {
            $this->photo = $this->getImageName();
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->client_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastname()
    {

        return $this->lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getRoute()
    {

        return $this->route;
    }

    public function readAll()
    {
        $sql = 'CALL getClients';
        $params = null;
        return Database::getRows($sql, $params);
    }

    public function getAllClients(){
        $sql = 'SELECT * FROM clients';
        $params = null;
        return Database::getRows($sql, $params);
    }


    public function create()
    {

        $sql = 'CALL addClient(?,?,?,?,?)';
        $params = array($this->name, $this->lastname, $this->email, $this->phone_number, $this->photo);
        return Database::executeRow($sql, $params);
    }

    public function delete()
    {
        $sql = 'CALL deleteClient(?)';
        $params = array($this->client_id);
        return Database::executeRow($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT * FROM clients
                WHERE id = ?';
        $params = array($this->client_id);
        return Database::getRow($sql, $params);
    }

    public function checkNewClient()
    {

        $sql = 'CALL checkNewClient(?,?)';
        $params = array($this->email, $this->phone_number);
        return Database::getRow($sql, $params);
    }

    public function searchRows($value)
    {

        $sql = 'SELECT * FROM  clients WHERE name LIKE ? OR lastname LIKE ? OR email LIKE ? OR phone_number LIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->photo) ? $this->deleteFile($this->getRoute(), $current_image) : $this->photo = $current_image;

        $sql = 'CALL UpdateClient(?, ?, ?, ?, ? ,?)';
        $params = array($this->name, $this->lastname, $this->email, $this->phone_number, $this->photo, $this->client_id);
        return Database::executeRow($sql, $params);
    }

    public function checkClientUpdate()
    {

        $sql = 'SELECT *
        FROM clients
        WHERE (phone_number = ? OR email = ?) AND id != ?;
        ';

        $params = array($this->phone_number, $this->email, $this->client_id);
        return Database::getRow($sql, $params);
    }

}
