<?php

namespace Core\Template;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    private $twig;
    private $data = [];

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function render($path)
    {
        $this->load();

        $template = $this->twig->load($path . ".twig");

        return $template->render($this->data);
    }

    public function load()
    {
        $this->twig = new Environment(
            new FilesystemLoader($this->getPath())
        );
    }

    private function getPath()
    {
        return ROOT_DIRECTORY . "/app/Views/";
    }
}
