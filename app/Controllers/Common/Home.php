<?php

namespace App\Controllers\Common;

use Core\Engine\Controller;

class Home extends Controller
{
    public function index()
    {
        $customer_id = (string) $this->session->get('customer_id');

        if (isset($customer_id)) {
            $this->load->controller('account/seller');
        }

        $this->load->controller('customer/login');
    }
}
