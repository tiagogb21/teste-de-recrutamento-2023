<?php

namespace App\Models\Account;

use Core\Engine\Model;

class History extends Model
{
    public function getAll()
    {
        return $this->db->query("
            SELECT
                *
            FROM
                history
            WHERE
                customer_id='" . $this->session->get('customer_id') . "'
            ORDER BY
                date_added DESC
        ");
    }
}
