<?php

namespace App\Models\Seller;

use Core\Engine\Model;

class Seller extends Model
{
    private $firstname, $lastname, $email, $password, $confirmPassword, $telephone;

    public function create($firstname, $lastname, $email, $telephone, $password, $confirmPassword)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
        $this->telephone = $telephone;

        if ($this->password !== $this->confirmPassword) {
            return false;
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);

        $this->saveUser();

        return true;
    }

    private function saveUser()
    {
        $sql = "INSERT INTO customer (
            firstname, lastname, email, password, telephone
        ) VALUES (:firstname, :lastname, :email, :password, :telephone)";
        $params = [
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':email' => $this->email,
            ':password' => $this->password,
            ':telephone' => $this->telephone,
        ];

        $this->db->query($sql, $params);
    }

    public function getById($customer_id)
    {
        return $this->db->select('customer', '*', ['id' => $customer_id])[0];
    }

    public function getByEmail($email)
    {
        return $this->db->select('customer', '*', ['email' => $email])[0];
    }
}
