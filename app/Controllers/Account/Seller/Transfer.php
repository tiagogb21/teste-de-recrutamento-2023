<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class Transfer extends Controller
{
    private function loader()
    {
        $this->load->model('account/bank');
        $this->load->model('account/balance');
        $this->load->model('account/transfer');
        $this->load->helper('currency');
    }

    public function add()
    {
        $this->loader();
        $this->getForm();
    }

    public function getForm()
    {
        if (
            $this->requestMethodIsPOST()
            && $this->verifyIfCostumerCanGetValue()
        ) {
            try {
                $this->registerTransfer();
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }

            $this->response->redirect('/account/seller/transfers');
        }

        $banks = $this->model_account_bank->getAllAccounts();

        $account_data = array_map(function ($bank) {
            $bank_name = $this->model_account_bank->getBankName($bank["bank_id"]);
            return
                [
                    'name' => "BANCO: $bank_name, CONTA: " . $bank["account"] . ", AGÊNCIA: " . $bank["agency"],
                    'id' => $bank["bank_id"]
                ];
        }, $banks);

        $data['left_menu'] = $this->load->view('account/leftMenu');

        $data['banks'] = $account_data;

        $data['balances']  = $this->getBalance();

        $this->response->setOutput(
            $this->load->view('account/forms/addTransfer', $data)
        );
    }

    private function getBalance()
    {
        $inputValue = $this->request->post['value'];

        $balance = $this->model_account_balance->get($this->session->get('customer_id'));

        $newValue = $balance['available'] - $inputValue;

        $balance['available'] = $this->helper_currency->format($newValue);

        return $balance;
    }

    private function requestMethodIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    private function verifyIfCostumerCanGetValue()
    {
        $balance = $this->model_account_balance->get($this->session->get('customer_id'));

        $value = $this->request->post['value'];

        return $value > 0 && $value <= $balance['available'];
    }

    private function registerTransfer()
    {
        $accountId = $this->request->post['id'];
        $accountValue = $this->request->post['value'] * -1;

        return $this->model_account_transfer->registerTransfer(
            $accountId,
            $accountValue,
        );
    }
}
