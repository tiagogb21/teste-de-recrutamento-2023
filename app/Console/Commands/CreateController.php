<?php

namespace App\Console\Commands;

use App\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class CreateController extends Command
{
    protected $entity = "controller";
    protected $namespace = "App\\Controllers";
    protected $dir = CONTROLLER_DIRECTORY;

    protected function configure() : void
    {
        $this
            ->setName('create:controller')
            ->setDescription('Criar Controller')
            ->setHelp('Esse comando irá te ajudar a criar uma Controller')
            ->addArgument('controller_name', InputArgument::REQUIRED, 'O nome da Controller')
            ->addOption(
                'with_view',
                'w',
                InputOption::VALUE_NONE,
                'Create controller with view'
            );
    }

    public function execute(InputInterface $input, OutputInterface $ouput) : int
    {
        $io = new SymfonyStyle($input, $ouput);

        extract($this->getArgument($input));

        $parts_name_clone = $parts_name;

        array_pop($parts_name);

        $this->createDirIsNotExist($parts_name);

        $content = $this->getContent($controller_name, $parts_name);

        $parts_name[] = $controller_name;

        $this->writeFileContent($parts_name, $content);

        if($input->getOption('with_view'))
            $this->createWithView($parts_name_clone, $controller_name);

        $io->success("Controller " . $input->getArgument('controller_name') . " criado com sucesso!");

        return SymfonyCommand::SUCCESS;
    }

    public function createWithView($parts_name, $controller_name){
        $cmdView = new CreateView;
        $cmdView->executeManually($parts_name, $controller_name);
    }
}