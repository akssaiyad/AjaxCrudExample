<?php

namespace Aks\AjaxCrud\Model\ResourceModel\Form;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'form_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Aks\AjaxCrud\Model\FormForm',
            'Aks\AjaxCrud\Model\ResourceModel\Form'
        );
    }
}