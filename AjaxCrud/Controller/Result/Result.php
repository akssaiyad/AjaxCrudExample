<?php

namespace Aks\AjaxCrud\Controller\Result;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Directory\Model\RegionFactory;

class Result extends \Magento\Framework\App\Action\Action
{

     /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $resultJsonFactory;

    protected $_date;
    protected $regionFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        RegionFactory $regionFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
        )
    {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->regionFactory = $regionFactory;
        $this->_date = $date;
        return parent::__construct($context);
    }


    public function execute()
    {
        /*$this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();*/
        $output = '';
        $age = '';
        $result = $this->resultJsonFactory->create();
        $dob = $this->getRequest()->getParam('dob');
        if (!empty($dob)) {
            $today = $this->_date->date()->format('y-m-d');
            $int = date_diff(date_create($dob), date_create($today));
            $output = "Age is"." ".$int->format('%y years %m months %d days');
            $age = $int->format('%y');
        }
        

        $regions = $this->regionFactory->create()->getCollection()->addFieldToFilter('country_id',$this->getRequest()->getParam('country'));

         $html = '';
        if(count($regions) > 0)
        {
            $html.='<option selected="selected" value="">Please select a region, state or province.</option>';
            foreach($regions as $state)
            {
                $html.=    '<option  value="'.$state->getName().'">'.$state->getName().'.</option>';
            }
        }

        /*$block = $resultPage->getLayout()
                ->createBlock('Aks\AjaxCrud\Block\Index')
                ->setTemplate('Aks_AjaxCrud::result.phtml')
                ->setData('date',$dob)
                ->toHtml();*/

        return $result->setData(['success' => true, 'value'=>$html, 'output' => $output, 'age' => $age]);
    } 
}