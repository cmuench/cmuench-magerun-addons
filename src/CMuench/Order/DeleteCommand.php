<?php

namespace CMuench\Order;

use N98\Magento\Command\AbstractMagentoCommand;
use N98\Magento\Command\Database\DumpCommand;
use N98\Util\OperatingSystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends DumpCommand
{
    protected function configure()
    {
        $this
            ->setName('order:delete')
            ->setDescription('Deletes all order data')
        ;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return version_compare($this->getApplication()->getVersion(), '1.74.1', '>=');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->detectDbSettings($output);

        $tables = $this->resolveTables(array('@sales'), $this->getTableDefinitions());

        $connection = $this->_getConnection();
        /* @var $connection \PDO */
        $connection->query('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            $output->writeln('<info>truncate table </info><comment>' . $table . '</comment>');
            $connection->query('TRUNCATE `' . $table . '`');
        }

        $connection->query('SET FOREIGN_KEY_CHECKS=1;');

        $output->writeln('<info>Done</info>');
    }
}
