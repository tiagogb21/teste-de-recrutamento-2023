<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class Transfer extends Controller
{
    private function loader()
    {
        $this->load->model('account/bank');
    }

    public function add()
    {
        $this->loader();
        $this->getForm();
    }

    public function getForm()
    {
        $banks = $this->model_account_bank->getAllAccounts();

        $account_data = array_map(function ($bank) {
            $bank_name = $this->model_account_bank->getBankName($bank["bank_id"]);
            return "BANCO: $bank_name, CONTA: " . $bank["account"] . " AGÊNCIA: " . $bank["agency"];
        }, $banks);

        $data['left_menu'] = $this->load->view('account/leftMenu');

        $data['banks'] = $account_data;

        $this->response->setOutput(
            $this->load->view('account/forms/addTransfer', $data)
        );
    }
}
