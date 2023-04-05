<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Transaction extends Model
{
    public function getOne(int $id)
    {
        return @$this->db->query(
            "
            SELECT
                *
            FROM
                transaction
            WHERE
                transaction_id=$id
            AND
                customer_id=" . $this->session->get('customer_id')
        )[0];
    }

    public function getAll()
    {
        return @$this->db->query(
            "
            SELECT
                *
            FROM
                transaction
            WHERE
                customer_id=" . $this->session->get('customer_id')
        );
    }
}
