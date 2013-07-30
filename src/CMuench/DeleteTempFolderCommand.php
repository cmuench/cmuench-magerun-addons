<?php

namespace CMuench;

use N98\Magento\Command\AbstractMagentoCommand;
use N98\Util\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteTempFolderCommand extends AbstractMagentoCommand
{
    protected function configure()
    {
      $this
          ->setName('tmp:remove')
          ->setDescription('Removes folder /tmp/magento if it exists')
      ;
    }

   /**
    * @param \Symfony\Component\Console\Input\InputInterface $input
    * @param \Symfony\Component\Console\Output\OutputInterface $output
    * @return int|void
    */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = '/tmp/magento';
        if (is_dir($folder)) {
            try {
                $filesystem = new Filesystem();
                $filesystem->recursiveRemoveDirectory($folder);
            } catch (Exception $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
            }
        }
    }
}
