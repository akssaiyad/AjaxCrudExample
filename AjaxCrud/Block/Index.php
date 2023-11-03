<?php

namespace Aks\AjaxCrud\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;

class Index extends Template
{
    protected $_date;
    protected $directoryBlock;

    public function __construct(
        Context $context,      
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Block\Data $directoryBlock,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    )
    {        
        $this->_date = $date;
        $this->directoryBlock = $directoryBlock;
        parent::__construct($context);
    }

    public function getCountries()
    {
        $country = $this->directoryBlock->getCountryHtmlSelect();
        return $country;
    }
    public function getRegion()
    {
        $region = $this->directoryBlock->getRegionHtmlSelect();
        return $region;
    }
     public function getAction()
    {
        return $this->getUrl('ajaxcrud/result/result', ['_secure' => true]);
    }
}