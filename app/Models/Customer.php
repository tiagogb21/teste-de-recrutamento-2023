<?php

namespace App\Models;

use Core\Engine\Model;

class Customer extends Model
{
    public function getByEmail(string $email)
    {
        $query = "SELECT * FROM recrutamento.customer WHERE email LIKE '$email';";

        return $this->db->query($query);
    }
}
