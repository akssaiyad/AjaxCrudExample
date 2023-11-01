<?php

namespace Aks\AjaxCrud\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    protected $_date;

    public function __construct(
        Context $context,      
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    )
    {        
        $this->_date = $date;
        parent::__construct($context);
    }

    public function getBaseUrl()
    {
        return $this->_storeManager->getStore()->getBaseUrl();
    }

    public function getDob()
    {
        return $this->getDate();
    }

    public function getCurrentData()
    {
        return $this->_date->date()->format('Y-m-d H:i:s');
    }
}