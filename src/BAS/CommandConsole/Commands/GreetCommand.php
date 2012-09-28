<?php 
namespace BAS\CommandConsole\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command 
{
    protected function configure()
    {
        $this->setName('demo:greet')
             ->setDescription('Greet Someone')
             ->addArgument('name', InputArgument::OPTIONAL, 'Who do you think you are?')
             ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the task will yell in uppercase letters');
       
    }

    protected function execute(InputInterface $input, $output)
    {
        $name = $input->getArgument('name');
        if($name) {
            $text = 'Looser' . $name;
        } else {
            $text = 'Your still a Looser ';
        }

        if($input->getOption('yell')){
            $text = strtoupper($text);
        }

        $output->writeln("<error>{$text}</error>");
    }
}
