<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Order extends Model
{
    public function getAllOrder()
    {
        $query = "
            SELECT
                *
            FROM
                order
        ";

        return $this->db->query($query);
    }
}
