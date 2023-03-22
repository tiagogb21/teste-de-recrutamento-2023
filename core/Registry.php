<?php

namespace Core;

class Registry
{
    private $data = [];

    private static $instance;

    public function __construct()
    {
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function get($key)
    {
        if (isset($this->data[$key]))
            return $this->data[$key];

        return null;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }
}
