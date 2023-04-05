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

    public function getAllAccounts()
    {
        $customer_id = (string) $this->session->get('customer_id');

        $query = "SELECT * FROM recrutamento.bank_account where customer_id='$customer_id'";

        return $this->db->query($query);
    }

    public function getBankId($bank_name)
    {
        $query = "SELECT bank_id from bank WHERE name='$bank_name'";

        return $this->db->query($query)[0]['bank_id'];
    }

    public function getBankName($bank_id)
    {
        $query = "SELECT name from bank WHERE bank_id='$bank_id'";

        return $this->db->query($query)[0]['name'];
    }

    public function create(
        $type,
        $bank_name,
        $agency,
        $account
    ) {
        $customer_id = (string) $this->session->get('customer_id');

        $bank_id = $this->getBankId($bank_name);

        $query = "INSERT INTO bank_account (
            customer_id,
            type,
            bank_id,
            agency,
            account
        ) VALUES (
            '" . $customer_id . "',
            '" . $type . "',
            '" . $bank_id . "',
            '" . $agency . "',
            '" . $account . "'
        )";

        return $this->db->query($query);
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

    public function getAccountInfo()
    {
        $customer_id = (string) $this->session->get('customer_id');

        $query = "SELECT * FROM bank_account WHERE customer_id='$customer_id'";

        return $this->db->query($query);
    }
}
