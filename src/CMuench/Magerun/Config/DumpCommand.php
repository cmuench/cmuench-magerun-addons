<?php

namespace Cmuench\Magerun\Config;

use N98\Magento\Command\AbstractMagentoCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class DumpCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
        $this
            ->setName('magerun:config:dump')
            ->setDescription('Dumps complete n98-magerun config')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $yaml = Yaml::dump($this->getApplication()->getConfig());
        $output->writeln($yaml);
    }
}