<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class Transfer extends Controller
{
    private function loader()
    {
        $this->load->model('account/bank');
        $this->load->model('account/balance');
        $this->load->helper('currency');
    }

    public function add()
    {
        $this->loader();
        $this->getForm();
    }

    public function getForm()
    {
        // if (
        //     $this->requestMethodIsPOST()
        //     && $this->verifyIfCostumerCanGetValue()
        // ) {
        //     try {
        //         $this->makeTransfer();
        //     } catch (\Exception $e) {
        //         $this->errors[] = $e->getMessage();
        //     }

        //     $this->response->redirect('/seller/transfers');
        // }

        $banks = $this->model_account_bank->getAllAccounts();

        $account_data = array_map(function ($bank) {
            $bank_name = $this->model_account_bank->getBankName($bank["bank_id"]);
            return "BANCO: $bank_name, CONTA: " . $bank["account"] . " AGÊNCIA: " . $bank["agency"];
        }, $banks);

        var_dump($account_data);

        $data['left_menu'] = $this->load->view('account/leftMenu');

        $data['banks'] = $account_data;

        $data['balances']  = $this->getBalance();

        $this->response->setOutput(
            $this->load->view('account/forms/addTransfer', $data)
        );
    }

    private function getBalance()
    {
        $balance = $this->model_account_balance->get($this->session->get('customer_id'));

        $balance['available'] = $this->helper_currency->format($balance['available']);

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

    private function makeTransfer()
    {
        $accountType = $this->request->post['type'];
        $value = $this->request->post['value'];

        var_dump($accountType);

        $this->model_account_transfer->transfer(
            $this->request->post['type'],
            $this->request->post['value'],
        );
    }
}
