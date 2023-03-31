<?php

namespace App\Controllers\Costumer;

use Core\Engine\Controller;

class Login extends Controller
{
    public function loader()
    {
        $this->load->model('costumer');
    }

    public function index()
    {
        $this->loader();
        $this->login();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $emailLogin = $this->request->post['email'];
            $passwordLogin = $this->request->post['password'];

            $getUserByEmail = $this->model_costumer->getByEmail($emailLogin);

            if (empty($getUserByEmail)) {
                $data['error']['login'] = "Usuário ou senha inválidos";
            }

            $costumerPassword = $getUserByEmail['password'];

            if (!password_verify($passwordLogin, $costumerPassword)) {
                $data['error']['login'] = "Usuário ou senha inválidos";
            }

            if (empty($data['error'])) {
                $this->response->redirect("/account/seller");
            }
        }

        $this->response->setOutput(
            $this->load->view('components/login', $data)
        );
    }
}
