<?php

namespace App\Helpers;

use Core\Engine\Helper;

class Currency extends Helper
{
    public function format($value)
    {
        return number_format($value, 2, ',', '.');
    }
}
