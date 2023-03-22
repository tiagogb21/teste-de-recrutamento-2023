<?php

namespace Core;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function has($key)
    {
        return isset($_SESSION[$key]);
    }

    public function get($key = null)
    {
        if($key == null)
            return $_SESSION;

        return $this->has($key) ? $_SESSION[$key] : null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
}
