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

    public function registerTransfer(
        $accountId,
        $amount,
    ) {
        $customer_id = (string) $this->session->get('customer_id');
        $status = 1;

        $query = "
            START TRANSACTION;

            INSERT INTO transfer (
                customer_id,
                bank_account_id,
                amount,
                status
            )
            VALUES (
                '$customer_id',
                '$accountId',
                '$amount',
                '$status'
            );
            
            SET @last_transfer_id = LAST_INSERT_ID();
            
            INSERT INTO transaction (
                transfer_id,
                customer_id,
                order_id,
                product_id,
                value,
                status,
                date_added
            )
            VALUES (
                @last_transfer_id,
                '$customer_id',
                NULL,
                NULL,
                '$amount',
                $status,
                NOW()
            );
            
            COMMIT;
        ";

        return $this->db->query($query);
    }
}
