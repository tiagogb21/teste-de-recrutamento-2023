<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class BankAccount extends Controller
{
    public function add()
    {
        $this->getForm();
    }

    public function getForm()
    {
        $data['left_menu'] = $this->load->view('account/leftMenu');

        $this->response->setOutput(
            $this->load->view('account/forms/addBankAccount', $data)
        );
    }
}
