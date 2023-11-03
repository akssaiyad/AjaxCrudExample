<?php

namespace Aks\AjaxCrud\Model\ResourceModel;

class Form extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('aks_ajaxcrud', 'form_id'); //here "aks_ajaxcrud" is table name and "form_id" is the primary key of custom table
    }
}