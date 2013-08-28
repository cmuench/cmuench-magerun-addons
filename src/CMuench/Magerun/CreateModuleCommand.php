<?php

namespace Cmuench\Magerun;

use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModuleCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
      $this
          ->setName('magerun:module:create')
          ->addArgument('moduleName', InputArgument::REQUIRED, 'Name of module')
          ->addArgument('namespace', InputArgument::REQUIRED, 'Namespace to code')
          ->setDescription('Creates a magerun module')
      ;
    }

   /**
    * @param \Symfony\Component\Console\Input\InputInterface $input
    * @param \Symfony\Component\Console\Output\OutputInterface $output
    * @return int|void
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleName = $input->getArgument('moduleName');
        $namespace = $input->getArgument('namespace');

        $moduleBaseFolder = getcwd() . '/' . $moduleName;
        mkdir($moduleBaseFolder);
        $output->writeln('<info>Created directory: <comment>' .  $moduleBaseFolder . '<comment></info>');

        $twigVars = array(
            'moduleBaseFolder' => $moduleBaseFolder,
            'moduleName'      => $moduleName,
            'namespace'       => $namespace,
            'commandClass'    => 'ExampleCommand',
            'commandName'     => 'example',
        );

        $configFileTwig = file_get_contents(__DIR__ . '/res/n98-magerun-yaml.twig');
        $configFileContent = $this->getHelper('twig')->renderString($configFileTwig, $twigVars);
        file_put_contents($moduleBaseFolder . '/n98-magerun.yaml', $configFileContent);
        $output->writeln('<info>Created file: <comment>' . $moduleBaseFolder . '/n98-magerun.yaml' . '</comment></info>');

        mkdir($moduleBaseFolder . '/src');
        $output->writeln('<info>Created directory: <comment>' .  $moduleBaseFolder . '/src</comment></info>');
        $commandFileTwig = file_get_contents(__DIR__ . '/res/ExampleCommand.twig');
        $commandFileContent = $this->getHelper('twig')->renderString($commandFileTwig, $twigVars);
        mkdir($moduleBaseFolder . '/src/' . str_replace('\\', '/', $namespace), 0777, true);
        $output->writeln('<info>Created directory: <comment>' . $moduleBaseFolder . '/src/' . str_replace('\\', '/', $namespace) . '</comment></info>');
        file_put_contents($moduleBaseFolder . '/src/' . str_replace('\\', '/', $namespace) . '/ExampleCommand.php', $commandFileContent);
        $output->writeln('<info>Created file: <comment>' . $moduleBaseFolder . '/src/' . str_replace('\\', '/', $namespace) . '/ExampleCommand.php' . '</comment></info>');
    }
}
