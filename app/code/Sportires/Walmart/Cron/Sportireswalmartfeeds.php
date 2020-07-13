<?php
declare(strict_types=1);

namespace Sportires\Walmart\Cron;

class Sportireswalmartfeeds
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
        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/Marketplaces-Walmart-Feeds-'.date('Ymd').'.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        $logger->info("Iniciando Proceso para Verificar estatus de los Feeds a Walmart");
        $logger->info(date('Y-m-d H:i:s'));

        $walmart = $objectManager->get('Sportires\Walmart\Helper\Configuration');
        $oAuth = $walmart->getToken();
        $walmartFeeds = $objectManager->get('Sportires\Walmart\Helper\Feed');
        $result = $walmartFeeds->getItemFeedStatus($oAuth,'');

        if(!empty($result->results->feed)){
            $walmartFeeds->updateFeed($result->results->feed);
        }

        $logger->info("RESPONSE : ".print_r($result,true));
        $logger->info('CONCLUYE : '.date('Y-m-d H:i:s'));
    }
}

