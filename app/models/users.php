<?php


class Users extends Validator
{

    //declaracion de atributos
    private $user_id = null;
    private $username = null;
    private $password = null;
    private $email = null;
    private $verification_code = null;


    //asignando valores y validaciones a los atributos

    public function setId($value)
    {
        if ($this->validateNaturalNumber($value)) {
            $this->user_id = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setUsername($value)
    {


        if ($this->validateAlphanumeric($value, 1, 50)) {
            $this->username = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setPassword($value)
    {
        if ($this->validatePassword($value)) {
            $this->password = $value;
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


    public function setVerificationCode($value)
    {
        if ($this->validateString($value, 1, 200)) {
            $this->verification_code = $value;
            return true;
        } else {
            return false;
        }
    }


    public function getId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getVerificationCode()
    {
        return $this->verification_code;
    }

    public function checkUser($username)
    {
        $sql = 'SELECT id, email FROM users WHERE username = ?';
        $params = array($username);
        if ($data = Database::getRow($sql, $params)) {
            $this->user_id = $data['id'];
            $this->username = $username;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT password FROM users WHERE id = ?';
        $params = array($this->user_id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['password'])) {
            return true;
        } else {
            return false;
        }
    }


    public function readAll()
    {
        $sql = 'SELECT *
                FROM users
                ';
        $params = null;
        return Database::getRows($sql, $params);
    }


    public function createRow()
    {
        // Se encripta la clave por medio del algoritmo bcrypt que genera un string de 60 caracteres.
        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = 'CALL saveUser(?,?,?);';
        $params = array($this->username, $hash, $this->email);
        return Database::executeRow($sql, $params);
    }


    public function saveLog($action, $details)
    {
        $sql = 'CALL saveLog(?,?,?);';
        $params = array($this->user_id, $action, $details);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT * FROM users WHERE id =?';
        $params = array($this->user_id);
        return Database::getRow($sql, $params);
    }

    public function checkUserUpdate()
    {

        $sql = 'SELECT *
        FROM users
        WHERE (username = ? OR email = ?) AND id != ?;
        ';

        $params = array($this->username, $this->email, $this->user_id);
        return Database::getRow($sql, $params);
    }


    public function editProfile()
    {

        $sql = ' UPDATE users 
        SET  email = ? , username = ?
        WHERE id = ?;';
        $params = array($this->email, $this->username, $this->user_id);
        return Database::executeRow($sql, $params);
    }

    public function validateMail()
    {
        // Declaramos la sentencia que enviaremos a la base
        $sql = "SELECT email from users where email = ?";
        // Enviamos los parametros
        $params = array($this->email);
        return Database::getRow($sql, $params);
    }

    public function getUser($email)
    {
        // Creamos la sentencia SQL que contiene la consulta que mandaremos a la base
        $sql = 'SELECT username,id FROM users WHERE email = ?';
        $params = array($email);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['username_temp'] = $data['username'];
            $_SESSION['user_id_temp'] = $data['id'];

            return true;
        } else {
            return false;
        }
    }


    //metodo que registra un código de verificación cifrado
    public function updateCode()
    {
        $bcrypt = password_hash($this->verification_code, PASSWORD_BCRYPT);

        // Declaramos la sentencia que enviaremos a la base
        $sql = "UPDATE users set verification_code = ? where email = ?";
        // Enviamos los parametros
        $params = array($bcrypt, $this->email);
        return Database::executeRow($sql, $params);
    }

    //metodo que verifica si el código de verificación coincide con el cifrado en la base
    public function validateCode($code, $id)
    {
        // Declaramos la sentencia que enviaremos a la base con el parametro del nombre de la tabla (dinamico)
        $sql = "SELECT email, verification_code from users where id = ?";
        // Enviamos los parametros
        $params = array($id);
        $data = Database::getRow($sql, $params);
        if (password_verify($code, $data['verification_code'])) {
            return true;
        } else {
            return false;
        }
    }


    //metodo que genera vacia el código de verificación
    public function resetCode($id)
    {
        // Declaramos la sentencia que enviaremos a la base con el parametro del nombre de la tabla (dinamico)
        $sql = "UPDATE users set verification_code = null where id = ?";
        // Enviamos los parametros
        $params = array($id);
        return Database::executeRow($sql, $params);
    }

    public function changePassword()
    {
        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $sql = 'UPDATE users SET password = ? WHERE id = ?';
        $params = array($hash, $this->user_id);
        return Database::executeRow($sql, $params);
    }


}
