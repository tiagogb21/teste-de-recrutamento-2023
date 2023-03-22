<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Product extends Model
{
    public function getAll()
    {
        return $this->db->query("
            SELECT
                *
            FROM
                history_type
        ");
    }

    public function getOne(int $id = 0)
    {
        if (!$id) return null;

        return @$this->db->query("
            SELECT
                *
            FROM
                product
            WHERE
                product_id=$id
        ")[0];
    }
}
