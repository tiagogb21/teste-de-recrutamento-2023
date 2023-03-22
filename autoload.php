<?php

DEFINE("ROOT_DIRECTORY", __DIR__);
DEFINE("CONTROLLER_DIRECTORY", __DIR__ . "/app/Controllers");
DEFINE("MODEL_DIRECTORY", __DIR__ . "/app/Models");
DEFINE("HELPER_DIRECTORY", __DIR__ . "/app/Helpers");
DEFINE("VIEW_DIRECTORY", __DIR__ . "/app/Views");

require_once ROOT_DIRECTORY . '/vendor/autoload.php';

function getControllers5fb29d36f96094bf4fd72e2ea1e2a73d($dir, $namespace, &$array)
{
    $files_folders = scandir($dir);

    foreach($files_folders as $value)
    {
        if ($value == "." || $value == "..")
            continue;

        if (!is_dir($dir . $value) AND pathinfo($value)['extension'] == 'php')
            $array[strtolower($namespace . pathinfo($value)['filename'])] = $dir . $value;
        else
            getControllers5fb29d36f96094bf4fd72e2ea1e2a73d($dir . $value . DIRECTORY_SEPARATOR, $namespace . pathinfo($value)['filename'] . "\\", $array);
    }
}

$controllers = [];

getControllers5fb29d36f96094bf4fd72e2ea1e2a73d(__DIR__ . '/app/Controllers/', "App\\Controllers\\", $controllers);

spl_autoload_register(function ($class) use ($controllers) {
    $class = strtolower($class);

    if(!isset($controllers[$class]))
        return false;

    require_once $controllers[$class];

    return true;
}, true, false);

unset($controllers);