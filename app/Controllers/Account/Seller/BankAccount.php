<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class BankAccount extends Controller
{
    private function loader()
    {
        $this->load->model('account/bank');
    }

    public function add()
    {
        $this->loader();

        if (
            $this->requestMethodIsPOST()
            && $this->fieldsAreValid()
            && $this->checkAccountExists()
        ) {
            try {
                $this->createAccount();
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }

            // $this->response->redirect('/account/seller');
        }

        $this->getForm();
    }

    private function fieldValidate($key, $field)
    {
        if (empty($field))
            $this->errors["$key"] = "O campo $key deve ser preenchido!";

        return !empty($field);
    }

    private function fieldsAreValid()
    {
        foreach ($this->request->post as $key => $field)
            if (!$this->fieldValidate($key, $field))
                return false;

        if (
            strlen($this->request->post['agency']) < 4
            || strlen($this->request->post['account']) < 7
        )
            return false;

        return true;
    }

    private function requestMethodIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function getForm()
    {
        $data['banks'] = $this->getAllBanks();
        $data['account_types'] = ['Conta Corrente', 'Conta Poupança', 'Conta Salário'];
        $data['left_menu'] = $this->load->view('account/leftMenu');

        $this->response->setOutput(
            $this->load->view('account/forms/addBankAccount', $data)
        );
    }

    public function getAllBanks()
    {
        return $this->model_account_bank->getAll();
    }

    public function createAccount()
    {
        $this->model_account_bank->create(
            $this->request->post['account-type'],
            $this->request->post['bank-name'],
            $this->request->post['agency'],
            $this->request->post['account'],
        );
    }

    public function checkAccountExists()
    {
        $myArray = $this->model_account_bank->checkAccount(
            $this->request->post['agency'],
            $this->request->post['account'],
        );

        if (!empty($myArray) && count($myArray) > 0) {
            return false;
        }

        return true;
    }
}
