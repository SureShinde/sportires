<?php
/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 ********************************************************************
 * @category   BelVG
 * @package    BelVG_ColorOrderStatus
 * @copyright  Copyright (c) BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */
/**
 * Created by PhpStorm.
 * User: zyr3x
 * Date: 3.9.18
 * Time: 9.24
 */
namespace BelVG\ColorOrderStatus\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class EditStatusFormBeforeHtml
 * @package BelVG\ColorOrderStatus\Observer
 */
class EditStatusFormBeforeHtml implements ObserverInterface {

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \BelVG\ColorOrderStatus\Helper\Data
     */
    protected $helper;

    /**
     * AssignFormBeforeHtml constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \BelVG\ColorOrderStatus\Helper\Data $helper
    )
    {
        $this->request = $request;
        $this->helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
         $block =  $observer->getEvent()->getBlock();
         if($block->getId() == 'new_order_status') {

             /** @var \Magento\Framework\Data\Form $form */
             $form = $block->getForm();
             $fieldset = $form->addFieldset('base_fieldset_color', ['legend' => __('Customize')]);

             $fieldset->addType('color',
                 \BelVG\ColorOrderStatus\Block\System\Config\Form\Field\Color::class);

             $status = $this->request->getParam('status');

             $fieldset->addField(
                 'color',
                 'color',
                 [
                     'name' => 'color',
                     'label' => __('Color'),
                     'required' => false,
                     'value'=>$this->helper->getStatusColor($status)
                 ]
             );
         }
    }
}