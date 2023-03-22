<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand
{
    protected $entity, $namespace, $dir;

    protected function writeFileContent($parts_name, $content, $extension = '.php'): void
    {
        $fp = fopen($this->getDirName($parts_name) . $extension, 'wb');

        fwrite($fp, $content);
        fclose($fp);
    }

    protected function createDirIsNotExist($parts_name)
    {
        if (!empty($parts_name) && !is_dir($this->getDirName($parts_name)))
            mkdir($this->getDirName($parts_name), 0777, true);
    }

    protected function getContent($model_name, $parts_name): string
    {
        $content = $this->getDraft();
        $content = str_replace("<EntityNamespace>", $this->getNameSpace($parts_name), $content);
        $entityName = str_replace('/', '', $model_name);
        $content = str_replace("<EntityName>", $entityName, $content);

        return $content;
    }

    protected function getDraft()
    {
        return file_get_contents(__DIR__ . "/Drafts/" . $this->entity. ".txt");
    }

    protected function getDirName($parts_name): string
    {
        return $this->dir . "/" . implode("/", $parts_name);
    }

    protected function getNameSpace($parts_name = []): string
    {
        return  $this->namespace . (empty($parts_name) ? "" : "\\" . implode("\\", $parts_name));
    }

    private function getPartsName($argument = ""): array
    {
        $key = "/";

        if (str_contains($argument, "\\")) $key = "\\";

        return explode($key, $argument);
    }

    protected function getArgument($input)
    {
        $name = $this->entity . "_name";

        $parts_name = $this->getPartsName($input->getArgument($name));
        $model_name = end($parts_name);

        return [
            "parts_name" => $parts_name,
            $name => $model_name
        ];
    }
}
