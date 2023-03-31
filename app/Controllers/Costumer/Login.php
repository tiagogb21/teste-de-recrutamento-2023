<?php

namespace App\Controllers\Costumer;

use Core\Engine\Controller;

class Login extends Controller
{
    private $customer = [];

    public function loadDependencies()
    {
        $this->load->model('costumer');
    }

    public function index()
    {
        $this->loadDependencies();

        $this->verifyCostumerExists();

        if (
            $this->requestMethodIsPOST()
            && !empty($this->costumer)
            && $this->fieldsAreValid()
        ) {
            $this->data['customer_id'] = $this->costumer['customer_id'];
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

    private function comparePassword()
    {
        if (
            password_verify(
                $this->request->post['password'],
                $this->costumer['password']
            )
        ) {

            $this->errors[] = "Usuário ou senha inválidos";

            return false;
        }

        return true;
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

    private function verifyCostumerExists()
    {
        $costumer = $this->model_costumer->getByEmail(
            $this->request->post['email']
        );

        if (!empty($costumer)) {
            $this->customer = $costumer;
        }
    }
}
