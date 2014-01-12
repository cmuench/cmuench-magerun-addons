<?php

namespace CMuench\Privacy;

use N98\Magento\Command\AbstractMagentoCommand;
use N98\Util\OperatingSystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DataDeleteCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
        $this
            ->setName('privacy:data-delete')
            ->setDescription('Deletes all defined data')
            ->addArgument('strip', InputArgument::OPTIONAL, 'Tables to strip', '@all')
        ;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return version_compare($this->getApplication()->getVersion(), '1.85.0', '>=');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbHelper = $this->getHelper('database');
        $dbHelper->detectDbSettings($output);
        $config = $this->getCommandConfig();
        $tables = $dbHelper->resolveTables(explode(' ', $input->getArgument('strip')), $dbHelper->getTableDefinitions($config));

        $connection = $dbHelper->getConnection();
        /* @var $connection \PDO */
        $connection->query('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            $output->write('<info>truncate table </info><comment>' . $table . '</comment> ');
            if ($connection->query('TRUNCATE `' . $table . '`')) {
                $output->writeln('<info>[OK]</info>');
            } else {
                $output->writeln('<error>[ERROR]</error>');
            }
        }

        $connection->query('SET FOREIGN_KEY_CHECKS=1;');

        $output->writeln('<info>Done</info>');
    }
}
