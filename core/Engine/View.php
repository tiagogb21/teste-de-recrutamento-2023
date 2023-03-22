<?php

namespace Core;

class View
{
    protected $template_engine;

    public function __construct($path, $data)
    {
        $this->loadTemplateEngine();

        echo $this->template_engine->render($path, $data);
    }

    private function loadTemplateEngine()
    {
        $template_engine_class_name = "\\Framework\\Template\\" . $_ENV('TEMPLATE_ENGINE');

        $this->template_engine = new $template_engine_class_name;
    }
}