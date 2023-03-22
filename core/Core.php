<?php

namespace Core;

use Dotenv\Dotenv;

class Core
{
    protected $dotenv, $registry, $output;

    public function __construct()
    {
        $this->dotenv   = Dotenv::createImmutable(ROOT_DIRECTORY);

        $this->registry = new Registry;

        $this->start();

        $this->showOutput();
    }

    private function start()
    {
        $this->environmentVariables();

        $this->registry();

        $this->router();
    }

    private function environmentVariables()
    {
        $this->loadEnvironmentVariables();

        $this->requiredEnvironmentVariables();
    }

    private function loadEnvironmentVariables()
    {
        $this->dotenv->load();
    }

    private function requiredEnvironmentVariables()
    {
        $this->dotenv->required([
            'ACTION_DEFAULT',
            'TEMPLATE_ENGINE',
            'DB_HOST',
            'DB_NAME',
            'DB_USER',
            'DB_PASS'
        ]);
    }

    private function registry()
    {
        $this->loadLoaderOnRegistry();

        $this->loadRequestOnRegistry();

        $this->loadResponseOnRegistry();

        $this->loadDocumentOnRegistry();

        $this->loadDatabaseOnRegistry();

        $this->loadSessionOnRegistry();
    }

    private function loadLoaderOnRegistry()
    {
        $loader = new Loader($this->registry);

        $this->registry->set('load', $loader);
    }

    private function loadDatabaseOnRegistry()
    {
        $db = new Database(
            $_SERVER['DATABASE_ENGINE'],
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASS'],
            $_ENV['DB_NAME']
        );

        $this->registry->set('db', $db);
    }

    private function loadRequestOnRegistry()
    {
        $request = new Request;

        $this->registry->set('request', $request);
    }

    private function loadResponseOnRegistry()
    {
        $response = new Response;

        $response->addHeader('Content-Type: text/html; charset=utf-8');

        $this->registry->set('response', $response);
    }

    private function loadDocumentOnRegistry()
    {
        $document = new Document;

        $this->registry->set('document', $document);
    }

    private function loadSessionOnRegistry()
    {
        $session = new Session;

        $this->registry->set('session', $session);
    }

    private function router()
    {
        if (isset($this->registry->get('request')->get['_route_']))
            $route = $this->registry->get('request')->get['_route_'];
        else
            $route = $_ENV['ACTION_DEFAULT'];

        $action = new Action($route);

        $this->output = $action->execute($this->registry, []);
    }

    public function showOutput()
    {
        echo $this->registry->get('response')->getOutput();
    }
}
