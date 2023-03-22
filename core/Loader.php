<?php

namespace Core;

class Loader
{
    private $registry;

    public function __construct($registry)
    {
        $this->registry = $registry;
    }

    public function controller(string $route, ...$data)
    {
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', $route);

        $action = new Action($route);

        $output = $action->execute($this->registry, $data);

        return $output;
    }

    public function model($path)
    {
        $class = "App\\Models\\" . $this->transformPath($path);

        $this->registry->set(
            "model_" . str_replace("/", "_",  $path),
            new $class($this->registry)
        );
    }

    public function helper($path)
    {
        $class = "App\\Helpers\\" . $this->transformPath($path);

        $this->registry->set(
            "helper_" . str_replace("/", "_",  $path),
            new $class($this->registry)
        );
    }

    private function transformPath($path)
    {
        $path = str_replace("/", " ", $path);

        $path = ucwords($path);

        $path = str_replace(" ", "\\", $path);

        $path = str_replace("_", " ", $path);

        $path = ucwords($path);

        $path = str_replace(" ", "", $path);

        return $path;
    }

    public function view($route, $data = [])
    {
        $route = preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route);

        $template = new Template($_ENV['TEMPLATE_ENGINE']);

        $template->set('document', $this->registry->get('document'));

        foreach ($data as $key => $value)
            $template->set($key, $value);

        return $template->render($route);
    }
}
