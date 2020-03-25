<?php
 
namespace Firstdata\Gateway\Model\Config\Backend;
 
class Pem extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * @return string[]
     */
    public function getAllowedExtensions() {
        return ('pem');
    }
}