<?php

namespace Core;

class Template
{
    private $adaptor;

    public function __construct($adaptor)
    {
        $classname = __NAMESPACE__ . "\\Template\\" . ucfirst($adaptor);

        if (class_exists($classname))
            $this->adaptor = new $classname;
        else
            throw new \Exception('Error: Could not load template adaptor ' . $adaptor . '!');
    }

    public function set($key, $value)
    {
        $this->adaptor->set($key, $value);
    }

    public function render($template)
    {
        return $this->adaptor->render($template);
    }
}
