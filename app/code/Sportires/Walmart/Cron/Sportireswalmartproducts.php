<?php
declare(strict_types=1);

namespace Sportires\Walmart\Cron;

class Sportireswalmartproducts
{

    protected $logger;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob sportireswalmartproducts is executed.");
    }
}

