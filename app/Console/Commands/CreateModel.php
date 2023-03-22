<?php

namespace App\Console\Commands;

use App\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModel extends Command
{
    protected $entity = "model";
    protected $namespace = "App\\Models";
    protected $dir = MODEL_DIRECTORY;

    protected function configure() : void
    {
        $this
            ->setName('create:model')
            ->setDescription('Criar Model')
            ->setHelp('Esse comando irá te ajudar a criar uma Model')
            ->addArgument('model_name', InputArgument::REQUIRED, 'O nome da Model');
    }

    public function execute(InputInterface $input, OutputInterface $ouput) : int
    {
        $io = new SymfonyStyle($input, $ouput);

        extract($this->getArgument($input));

        array_pop($parts_name);

        $this->createDirIsNotExist($parts_name);

        $content = $this->getContent($model_name, $parts_name);

        $parts_name[] = $model_name;

        $this->writeFileContent($parts_name, $content);

        $io->success("Model " . $input->getArgument('model_name') . " criado com sucesso!");

        return SymfonyCommand::SUCCESS;
    }
}