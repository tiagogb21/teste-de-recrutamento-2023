<?php

namespace App\Controllers\Customer;

use Core\Engine\Controller;

class Login extends Controller
{

    public function loadDependencies()
    {
        $this->load->model('customer');
    }

    public function index()
    {
        $this->loadDependencies();

        if (
            $this->requestMethodIsPOST()
            && $this->fieldsAreValid()
        ) {
            $this->response->redirect('/account/seller');
        }

        $this->response->setOutput(
            $this->load->view('components/login', ['errors' => $this->errors])
        );
    }

    private function requestMethodIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function comparePassword()
    {
        if (
            !$this->teste()
            || md5($this->request->post['password']) !== $this->teste()['password']
        ) {
            $this->errors[] = "Usuário ou senha inválidos";

            return false;
        }

        return true;
    }

    public function teste()
    {
        $customer = $this->model_customer->getByEmail(
            $this->request->post['email']
        );

        if (!$customer) {
            $this->errors[] = "Usuário ou senha inválidos";
            return false;
        }

        if (!empty($customer)) {
            $customer_id = $customer[0]['customer_id'];
            $this->session->set('customer_id', $customer_id);
        }

        return $customer;
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

        $this->comparePassword();

        return true;
    }
}
