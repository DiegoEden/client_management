<?php

Class Documents extends Validator{

    //declaracion de atributos
    private $document_id = null;
    private $client_id = null;
    private $document_number= null;
    private $document_type = null;



    //asignando valores y validaciones a los atributos

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->document_id = $value;
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

    public function setDocumentNumber($value)
    {
        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->document_number = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDocumentType($value)
    {
        
        if ($this->validateText($value)) {

            $this->document_type = $value;
            return true;
        } else {
            return false;
        }
    }


    public function getId(){
        return $this->document_id;

    }

    public function getClientId(){
        return $this->client_id;
    }

    public function getDocumentNumber(){
        return $this->document_number;
    }

    public function getDocumentType(){
        return $this->document_type;
    }


    public function create(){
        $sql = "INSERT INTO documents (client_id, document_type, document_number) VALUES (?, ?, ?)";
        $params = array($this->client_id, $this->document_type, $this->document_number);
        return Database::executeRow($sql, $params);
        
    }


}