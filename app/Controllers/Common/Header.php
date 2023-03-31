<?php

namespace App\Controllers\Common;

use Core\Engine\Controller;

class Header extends Controller
{
    public function index()
    {
    }

    public function getTabs()
    {
        return [
            [
                'label' => 'Cadastro',
                'link'  => '/components/cadastro'
            ],
            [
                'label' => 'Login',
                'link'  => '/components/login'
            ],
        ];
    }

    public function getLink($data)
    {
        $data['title'] = "LinkAccount";
        $data['tabs']  = $this->getTabs();
    }
}
