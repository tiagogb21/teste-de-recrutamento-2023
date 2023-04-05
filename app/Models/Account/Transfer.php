<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Transfer extends Model
{
    public function getTransferInfo()
    {
        $query = "SELECT
            t.value AS value, t.status, t.date_added
            FROM transaction t
            LEFT JOIN
                transfer tr ON t.transfer_id = tr.transfer_id
            WHERE t.transfer_id IS NOT NULL;
        ";

        return @$this->db->query($query);
    }

    public function transfer($accountType, $value)
    {
        // $query = "INSERT INTO
        //     t.value AS value, t.status, t.date_added
        //     FROM transaction t
        //     LEFT JOIN
        //         transfer tr ON t.transfer_id = tr.transfer_id
        //     WHERE t.transfer_id IS NOT NULL;
        // ";

        // @$this->db->query($query);
        return true;
    }
}
