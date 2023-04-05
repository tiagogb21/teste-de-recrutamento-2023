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

    // É o saldo da venda dos produtos que aconteceram a mais de 30 dias
    private function getAvailableBalance()
    {
        $customer_id = (string) $this->session->get('customer_id');

        $available = @$this->db->query("
        SELECT
            SUM(value) AS amount FROM recrutamento.transaction
            WHERE
                    status = 1
                AND
                    DATE_ADD(DATE_FORMAT(date_added, '%Y-%m-%d'), INTERVAL 30 DAY) <= NOW()
                AND
                    customer_id = $customer_id;    
        ");

        $this->available = $available[0]['amount'] ?? 0;
    }

    // É o saldo da venda dos produtos que aconteceram em menos de 30 dias
    private function getFutureBalance()
    {
        $future = @$this->db->query("
            SELECT
                SUM(value) AS amount
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
                    status = 1
            LIMIT 1;
        ")[0];

        $this->future = $future['amount'] ?? 0;
    }

    private function getBlockedBalance()
    {
        $blocked = @$this->db->query("
            SELECT
                SUM(value) AS amount
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
