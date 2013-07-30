<?php

namespace Cmuench\Magerun;

use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommandCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
      $this
          ->setName('magerun:command:create')
          ->addArgument('commandName', InputArgument::REQUIRED, 'Command name')
          ->addArgument('commandClass', InputArgument::REQUIRED, 'Command class')
          ->addArgument('namespace', InputArgument::REQUIRED, 'Namespace to code')
          ->setDescription('Creates a magerun command in current working directory')
      ;
    }

   /**
    * @param \Symfony\Component\Console\Input\InputInterface $input
    * @param \Symfony\Component\Console\Output\OutputInterface $output
    * @return int|void
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cwd = getcwd();
        $commandName = $input->getArgument('commandName');
        $commandClass = $input->getArgument('commandClass');
        if (substr($commandClass, -7, 7) != 'Command') {
            $commandClass .= 'Command';
        }
        $namespace = $input->getArgument('namespace');

        $twigVars = array(
            'commandName'  => $commandName,
            'commandClass' => $commandClass,
            'namespace'    => $namespace,
        );

        $commandFileTwig = file_get_contents(__DIR__ . '/res/ExampleCommand.twig');
        $commandFileContent = $this->getHelper('twig')->renderString($commandFileTwig, $twigVars);
        file_put_contents($cwd . '/' . $commandClass . '.php', $commandFileContent);
        $output->writeln('<info>Created file: <comment>' . $cwd . '/' . $commandClass . '.php</comment></info>');
    }
}
