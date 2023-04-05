<?php

namespace App\Controllers\Account;

use Core\Engine\Controller;

class Seller extends Controller
{

    public function __construct($registry)
    {
        parent::__construct($registry);

        if (!$this->session->has('customer_id'))
            $this->response->redirect('/customer/login');
    }

    private function loader()
    {
        $this->load->model('account/bank');
        $this->load->model('account/balance');
        $this->load->model('account/history');
        $this->load->model('account/product');
        $this->load->model('account/transaction');
        $this->load->model('account/transfer');
        $this->load->model('account/history_type');
        $this->load->helper('currency');
    }

    public function index()
    {
        $this->loader();
        $this->panel();
    }

    public function getTabs()
    {
        return [
            [
                'label' => 'Painel',
                'link'  => '/account/seller'
            ],
            [
                'label' => 'Produtos',
                'link'  => '/account/seller/products'
            ],
            [
                'label' => 'Contas Bancárias',
                'link'  => '/account/seller/bankaccounts'
            ],
            [
                'label' => 'Transferências',
                'link'  => '/account/seller/transfers'
            ],
        ];
    }

    public function getProductTabs()
    {
        return [
            ['label' => 'Activos'],
            ['label' => 'Vendidos'],
            ['label' => 'Em Análise']
        ];
    }

    private function getBalance()
    {
        $balance = $this->model_account_balance->get($this->session->get('customer_id'));

        $balance['available'] = $this->helper_currency->format($balance['available']);
        $balance['future']    = $this->helper_currency->format($balance['future']);
        $balance['blocked']   = $this->helper_currency->format($balance['blocked']);

        return $balance;
    }

    public function panel()
    {
        $data['selected_tab'] = 1;
        $data['histories'] = $this->model_account_history->getAll();
        $data['balances']  = $this->getBalance();

        foreach ($data['histories'] as &$history) {
            $history['history_type'] = $this->model_account_history_type->getOne($history['history_type_id']);
            $history['transaction']  = $this->model_account_transaction->getOne($history['transaction_id']);

            $history['date_added'] = date_format(date_create($history['date_added']), "d/m/Y");
            @$history['transaction']['value'] = $this->helper_currency->format($history['transaction']['value']);

            if (@$history['transaction']['product_id'])
                $history['transaction']['product'] = $this->model_account_product->getOne($history['transaction']['product_id']);
        }

        $data['tabBody'] = $this->load->view('account/tabs/panel', $data);

        $this->getForm($data);
    }


    public function verifyDate()
    {
        $json = file_get_contents('php://input');

        if (!$json) {
            echo json_encode(array('success' => false, 'message' => 'No data received'));
            return;
        }

        $jsonData = json_decode($json, true);

        if (!$jsonData || !isset($jsonData['start_date']) || !isset($jsonData['end_date'])) {
            echo json_encode(array('success' => false, 'message' => 'Invalid data'));
            return;
        }

        $startDate = $jsonData['start_date'];
        $endDate = $jsonData['end_date'];

        $this->session->set('start_date', $startDate);
        $this->session->set('end_date', $endDate);

        $response = array('success' => true, 'data' => array('start_date' => $startDate, 'end_date' => $endDate));

        echo json_encode($response);
    }


    public function products()
    {
        $data['selected_tab']         = 2;
        $data['selected_product_tab'] = 1;
        $data['product_tabs']         = $this->getProductTabs();
        $data['tabBody']              = $this->load->view('account/tabs/products', $data);

        $this->getForm($data);
    }

    public function bankaccounts()
    {
        $this->load->model('account/bank');
        $data['account_infos'] = $this->model_account_bank->getAccountInfo();
        $data['selected_tab'] = 3;
        $data['tabBody'] = $this->load->view('account/tabs/bankAccount', $data);

        $this->getForm($data);
    }

    public function transfers()
    {
        $this->loader();

        $banks = $this->model_account_bank->getAllAccounts();

        $transactions = $this->model_account_transaction->getAll();

        $data['transactions'] = $transactions;

        $data['selected_tab'] = 4;
        $data['tabBody'] = $this->load->view('account/tabs/transfer', $data);

        $this->getForm($data);
    }

    public function getForm($data)
    {
        $data['title']     = "Área do Vendedor";
        $data['tabs']      = $this->getTabs();
        $data['left_menu'] = $this->load->view('account/leftMenu');

        $this->response->setOutput(
            $this->load->view('account/seller', $data)
        );
    }
}
