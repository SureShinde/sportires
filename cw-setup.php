#!/usr/bin/env php
<?php
/**
 * Copyright Â© 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

if (PHP_SAPI !== 'cli') {
    echo 'bin/magento must be run as a CLI application';
    exit(1);
}

try {
    require __DIR__ . '/app/bootstrap.php';
} catch (\Exception $e) {
    echo 'Autoload error: ' . $e->getMessage();
    exit(1);
}

class CwSetup extends \Symfony\Component\Console\Command\Command
{

    protected function configure()
    {
        $this->setName('cw:setup');
        $this->setDescription('Customweb Setup');
    }
    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output)
    {
        $locale = array_unique(array_merge(['en_US'], $this->getStoreLocales(), $this->getUserLocales()));
        $output->writeln('<comment>Commands to run:</comment>');
        $output->writeln('1) <info>php bin/magento setup:upgrade</info>');
        $output->writeln('2) <info>php bin/magento setup:di:compile</info>');
        $output->writeln('3) <info>php bin/magento setup:static-content:deploy ' . implode(' ', $locale) . '</info>');
    }

    private function getStoreLocales() {
        return $this->query('core_config_data', 'value', ['path = ?' => 'general/locale/code']);
    }

    private function getUserLocales() {
        return $this->query('admin_user', 'interface_locale');
    }

    private function query($tableName, $column, $where = null) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection();
        $query = $connection->select()->from([$tableName], [$column]);
        if ($where) {
            foreach ($where as $condition => $value) {
                $query->where($condition, $value);
            }
        }
        $result = [];
        foreach($connection->fetchAll($query) as $row) {
            $result[] = $row[$column];
        }
        return $result;
    }
}


try {
    $handler = new \Magento\Framework\App\ErrorHandler();
    set_error_handler([$handler, 'handler']);
    $application = new Magento\Framework\Console\Cli('Magento CLI');
    $application->add(new CwSetup());

    $application->run(new \Symfony\Component\Console\Input\ArrayInput([
        'command' => 'cw:setup'
    ]));
} catch (\Exception $e) {
    while ($e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
        echo "\n\n";
        $e = $e->getPrevious();
    }
    exit(Magento\Framework\Console\Cli::RETURN_FAILURE);
}