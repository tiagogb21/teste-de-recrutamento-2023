<?php

namespace App\Controllers\Costumer;

use Core\Engine\Controller;

class Register extends Controller
{
    public function loader()
    {
        $this->load->model('costumer/register');
        $this->load->model('costumer');
    }

    public function index()
    {
        $this->loader();
        $this->register();
    }

    public function checkExistence($propertyName, $propertyValue)
    {
        if (strlen($propertyName) <= 1) {
            $this->data["$propertyName . Error"] = "O campo $propertyValue deve ser preenchido";
            return false;
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstname = $this->request->post['firstname'];
            $lastname = $this->request->post['lastname'];
            $email = $this->request->post['email'];
            $telephone = $this->request->post['telephone'];
            $password = $this->request->post['password'];
            $confirmPassword = $this->request->post['confirm-password'];

            if (isset($_POST['submit'])) {
                $isValid = true;

                if (!$this->checkExistence($firstname, 'nome')) {
                    $isValid = false;
                }
                if (!$this->checkExistence($lastname, 'sobrenome')) {
                    $isValid = false;
                }
                if (!$this->checkExistence($email, 'email')) {
                    $isValid = false;
                }
                if (!$this->checkExistence($telephone, 'telefone')) {
                    $isValid = false;
                }
                if (!$this->checkExistence($password, 'senha')) {
                    $isValid = false;
                }
                if (!$this->checkExistence($confirmPassword, 'repetir a senha')) {
                    $isValid = false;
                }

                if ($password !== $confirmPassword) {
                    $isValid = false;
                    $data['error'] = "As senhas não coincidem";
                }

                $getUserByEmail = $this->model_costumer->getByEmail($email);

                if (!empty($getUserByEmail)) {
                    $isValid = false;
                    $data['error'] = "Usuário já cadastrado";
                }

                if ($isValid) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    $this->model_costumer_register->register(
                        $firstname,
                        $lastname,
                        $email,
                        $telephone,
                        $hashedPassword,
                    );
                    $this->response->redirect("/costumer/login");
                }
            }
        }

        $this->response->setOutput(
            $this->load->view('components/cadastro', $data)
        );
    }
}
