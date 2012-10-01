<?php 
namespace BAS\zf2\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

class ModuleCommand extends Command 
{
    protected function configure() {
        $this->setName('generate:module')->setDescription('Create a Brand Spanking New zf2 Module in an Exsisting Project!');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln("<info>Creating a Module</info>");
        $output->writeln("<comment>Things to Remember</comment>");
        $output->writeln("<error>Required Argument -- Namespace</error>");
        $output->writeln("<error>Required Argument -- Module Name</error>");
        $output->writeln("<error>Maybe doesn't happen here but will need a route to each view file (This is a new command)</error>");

        passthru('whoami');
        
    }

    protected function createDirectoryStructure() {
        

    }

}
