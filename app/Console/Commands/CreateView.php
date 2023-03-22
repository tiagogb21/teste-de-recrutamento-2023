<?php

namespace App\Console\Commands;

use App\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateView extends Command
{
    protected $entity = "view";
    protected $namespace = "App\\Views";
    protected $dir = VIEW_DIRECTORY;

    protected function configure() : void
    {
        $this
            ->setName('create:view')
            ->setDescription('Criar View')
            ->setHelp('Esse comando irá te ajudar a criar uma View')
            ->addArgument('view_name', InputArgument::REQUIRED, 'O nome da View');
    }

    public function execute(InputInterface $input, OutputInterface $ouput) : int
    {
        $io = new SymfonyStyle($input, $ouput);

        extract($this->getArgument($input));

        $this->executeManually($parts_name, $view_name);

        $io->success("View " . $input->getArgument('view_name') . " criado com sucesso!");

        return SymfonyCommand::SUCCESS;
    }

    public function executeManually($parts_name, $view_name){
        array_pop($parts_name);

        $this->createDirIsNotExist($parts_name);

        $content = $this->getContent($view_name, $parts_name);

        $parts_name[] = $view_name;

        $this->writeFileContent($parts_name, $content, '.twig');
    }
}