<?php

namespace Aks\AjaxCrud\Model;

use Magento\Framework\Model\AbstractModel;

class Form extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Aks\AjaxCrud\Model\ResourceModel\Form');
    }
}