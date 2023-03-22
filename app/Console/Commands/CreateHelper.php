<?php

namespace App\Console\Commands;

use App\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateHelper extends Command
{
    protected $entity = "helper";
    protected $namespace = "App\\Helpers";
    protected $dir = HELPER_DIRECTORY;

    protected function configure() : void
    {
        $this
            ->setName('create:helper')
            ->setDescription('Criar Helper')
            ->setHelp('Esse comando irá te ajudar a criar uma helper')
            ->addArgument('helper_name', InputArgument::REQUIRED, 'O nome da Helper');
    }

    public function execute(InputInterface $input, OutputInterface $ouput) : int
    {
        $io = new SymfonyStyle($input, $ouput);

        extract($this->getArgument($input));

        array_pop($parts_name);

        $this->createDirIsNotExist($parts_name);

        $content = $this->getContent($helper_name, $parts_name);

        $parts_name[] = $helper_name;

        $this->writeFileContent($parts_name, $content);

        $io->success("Helper " . $input->getArgument('helper_name') . " criado com sucesso!");

        return SymfonyCommand::SUCCESS;
    }
}