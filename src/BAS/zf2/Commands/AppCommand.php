<?php 
namespace BAS\zf2\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

class AppCommand extends Command 
{
    protected function configure()
    {
        $this->setName('generate:app')->setDescription('Create a Brand Spanking New zf2 Project')
             ->addArgument('{ProjectName}', InputArgument::REQUIRED, 'Please choose a project name.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectName = $input->getArgument('{ProjectName}');
 
        $output->writeln("<info>Cloning New Skeleton Application as {$projectName}</info>");
        passthru("git clone git://github.com/zendframework/ZendSkeletonApplication.git {$projectName}");
        $workingDirectory = getcwd() . "/{$projectName}/";    
        
        $output->writeln("<info>Now going through and Cleaning up the files that are not needed!</info>");
        foreach($this->getUnlinkFiles() as $file) {
            $path = $workingDirectory . $file;
            if(is_file($path)) {
                $output->writeln("Deleting File -- <error>{$file}</error>");
                unlink($path);
            }
        }
        
        $output->writeln("<comment>Running Composer to install dependencies.</comment>");
        
        passthru("cd {$workingDirectory}; php composer.phar install");
        
        $output->writeln("<error>Remember to setup your vhost file to run the site!</error>");
    }

    public function getUnlinkFiles() 
    {
        //Am planning on adding the ZF2 directory in vendor because composer install the library in the zendframework directory.  
        return array('LICENSE.txt',
                     'README.md',
                     
                    );
    }
}
