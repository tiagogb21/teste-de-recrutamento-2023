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

    public function updateHistoryByDateRange($start_date, $end_date)
    {
        $customer_id = (string) $this->session->get('customer_id');

        $sql = "UPDATE account_history 
                SET date_added = DATE_ADD(date_added, INTERVAL 1 DAY) 
                WHERE customer_id = '" . $customer_id . "' 
                AND date_added >= STR_TO_DATE('" . $start_date . "', '%d/%m/%Y') 
                AND date_added <= STR_TO_DATE('" . $end_date . "', '%d/%m/%Y')";

        $this->db->query($sql);
    }
}
