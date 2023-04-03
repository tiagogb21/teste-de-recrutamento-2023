<?php

namespace App\Controllers\Account\Seller;

use Core\Engine\Controller;

class Order extends Controller
{
    private function loader()
    {
        $this->load->model('account/order');
    }

    public function add()
    {
        $this->loader();

        if (
            $this->requestMethodIsPOST()
            && $this->fieldsAreValid()
        ) {
            try {
                $this->sumAllOrders();
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }

            $this->response->redirect('/account/seller');
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

    public function sumAllOrders()
    {
        $orders = $this->model_account_order->getAllOrder();
    }
}
