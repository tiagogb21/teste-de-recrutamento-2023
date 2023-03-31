<?php

namespace App\Controllers\Costumer;

use Core\Engine\Controller;

class Register extends Controller
{
    private $errors = [];

    public function loadDependencies()
    {
        $this->load->model('costumer/register');
        $this->load->model('costumer');
    }

    public function index()
    {
        $this->loadDependencies();

        if ($this->requestMethodIsPOST() && $this->fieldsAreValid() && $this->verifyCostumerExists()) {
            try {
                $this->registerUser();
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }

            $this->response->redirect('/customer/login');
        }

        $this->response->setOutput(
            $this->load->view('components/cadastro', ['errors' => $this->errors])
        );
    }

    private function fieldValidate($key, $field)
    {
        if (empty($field))
            $this->errors["$key"] = "O campo $key deve ser preenchido!";

        return !empty($field);
    }

    private function comparePassword()
    {
        if ($this->request->post['password'] !== $this->request->post['confirm-password']) {

            $this->errors[] = "As senhas não coincidem";

            return false;
        }

        return true;
    }

    private function requestMethodIsPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
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
        return empty($this->model_costumer->getByEmail(
            $this->request->post['email']
        ));
    }

    private function registerUser()
    {
        $this->model_costumer_register->register(
            $this->request->post['firstname'],
            $this->request->post['lastname'],
            $this->request->post['email'],
            $this->request->post['telephone'],
            password_hash($this->request->post['password'], PASSWORD_DEFAULT),
        );
    }
}
