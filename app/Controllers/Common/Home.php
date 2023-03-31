<?php

namespace App\Controllers\Common;

use Core\Engine\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->session->set('customer_id', $this->data['customer_id']);

        $this->load->controller('account/seller');
    }
}
