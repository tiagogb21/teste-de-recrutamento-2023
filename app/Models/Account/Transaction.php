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
        $query = "
        SELECT bank.long_name AS nome_do_banco, bank_account.account AS numero_da_conta, bank_account.agency AS numero_da_agencia, transaction.date_added, transaction.value, transaction.status
        FROM transaction
        INNER JOIN transfer ON transaction.transfer_id = transfer.transfer_id
        INNER JOIN bank_account ON transfer.bank_account_id = bank_account.bank_account_id
        INNER JOIN bank ON bank_account.bank_id = bank.bank_id
        INNER JOIN customer ON transaction.customer_id = customer.customer_id
        WHERE customer.customer_id = 
        " . $this->session->get('customer_id');

        return @$this->db->query(
            $query
        );
    }
}
