<?php

namespace App\Models\Customer;

use Core\Engine\Model;

class Register extends Model
{
    public function register(
        $firstname,
        $lastname,
        $email,
        $telephone,
        $password,
    ) {
        $sql = "INSERT INTO customer (
            firstname,
            lastname,
            email,
            password,
            telephone
        ) VALUES (
            '" . $firstname . "',
            '" . $lastname . "',
            '" . $email . "',
            '" . $password . "',
            '" . $telephone . "'
        )";

        $this->db->query($sql);

        return true;
    }
}
