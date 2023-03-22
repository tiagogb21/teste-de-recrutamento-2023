<?php

namespace App\Controllers\Common;

use Core\Engine\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->session->set('customer_id', 1);

        $this->load->controller('account/seller');
    }
}
