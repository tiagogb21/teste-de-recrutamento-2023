<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Balance extends Model
{
    private $available, $future, $blocked;
    private $customer_id;

    public function get($customer_id)
    {
        $this->customer_id = $customer_id;

        $this->getAvailableBalance();

        $this->getFutureBalance();

        $this->getBlockedBalance();

        return $this->balances();
    }

    private function getAvailableBalance()
    {
        $available = @$this->db->query("
            SELECT
                abs(value) AS amount
            FROM
                transaction
            WHERE
                    (
                        CASE
                            WHEN
                                product_id is not null
                                    AND
                                order_id is not null
                            THEN
                                DATE_ADD(DATE_FORMAT(date_added, '%Y-%m-%d'), INTERVAL 30 DAY) <= NOW()
                            ELSE
                                1 = 1
                        END
                    )
                    AND
                        value < 0
                    AND
                        status = 1
            LIMIT 1;
        ")[0];

        $this->available = $available['amount'] ?? 0;
    }

    private function getFutureBalance()
    {
        $future = @$this->db->query("
            SELECT
                abs(value) AS amount
            FROM
                transaction
            WHERE
                    customer_id = $this->customer_id
                AND
                    product_id is not null
                AND
                    order_id is not null
                AND
                    DATE_ADD(DATE_FORMAT(date_added, '%Y-%m-%d'), INTERVAL 30 DAY) > NOW()
                AND
                    value < 0
                AND
                    status = 1
            LIMIT 1;
        ")[0];

        $this->future = $future['amount'] ?? 0;
    }

    private function getBlockedBalance()
    {
        $blocked = @$this->db->query("
            SELECT
                abs(value) AS amount
            FROM
                transaction
            WHERE
                    customer_id = $this->customer_id
                AND
                    status = 2
            LIMIT 1;
        ")[0];

        $this->blocked = $blocked['amount'] ?? 0;
    }

    private function balances()
    {
        return [
            'available' => $this->available,
            'future'    => $this->future,
            'blocked'   => $this->blocked
        ];
    }
}
