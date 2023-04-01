<?php

namespace App\Models\Account;

use Core\Engine\Model;

class Bank extends Model
{
    public function getAll()
    {
        $query = "SELECT * FROM recrutamento.bank";

        return $this->db->query($query);
    }

    public function getBankId($bank_name)
    {
        $query = "SELECT bank_id from bank WHERE name='$bank_name'";

        return $this->db->query($query)[0]['bank_id'];
    }

    public function create(
        $type,
        $bank_name,
        $agency,
        $account
    ) {
        $customer_id = (string) $this->session->get('customer_id');

        $bank_id = $this->getBankId($bank_name);

        var_dump([
            $type,
            $customer_id,
            $bank_id,
            $agency,
            $account
        ]);

        $query = "INSERT INTO bank_account (
            $customer_id,
            $type,
            $bank_id,
            $agency,
            $account
        ) VALUES (
            '" . $customer_id . "',
            '" . $type . "',
            '" . $bank_id . "',
            '" . $agency . "',
            '" . $account . "'
        )";

        $stmt = $this->db->query($query);

        var_dump($stmt);

        return true;
    }

    public function checkAccount($agency, $account)
    {
        $query = "
            SELECT * FROM bank_account
            WHERE agency='$agency'
            AND account='$account'
        ";

        return $this->db->query($query);
    }
}
