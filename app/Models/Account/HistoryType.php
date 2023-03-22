<?php

namespace App\Models\Account;

use Core\Engine\Model;

class HistoryType extends Model
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

    public function getOne(int $id)
    {
        return @$this->db->query("
            SELECT
                *
            FROM
                history_type
            WHERE
                history_type_id=$id
        ")[0];
    }
}
