<?php

namespace Aks\AjaxCrud\Controller\Result;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Result extends \Magento\Framework\App\Action\Action
{

     /**
     * @var Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $resultJsonFactory;

    protected $_date;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
        )
    {

        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_date = $date;
        return parent::__construct($context);
    }


    public function execute()
    {
        $dob = $this->getRequest()->getParam('date');
        $selectedCountry = $this->getRequest()->getParam('country');
        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();

        // Query your database or perform logic to get city options based on the selected country.
        $cities = [
            '1' => 'City A',
            '2' => 'City B',
            // Add more cities...
        ];
        /*$block = $resultPage->getLayout()
                ->createBlock('Aks\AjaxCrud\Block\Index')
                ->setTemplate('Aks_AjaxCrud::result.phtml')
                ->setData('date',$dob)
                ->toHtml();*/
        
        $today = $this->_date->date()->format('y-m-d');
        $int = date_diff(date_create($dob), date_create($today));
        $output = "Age is"." ".$int->format('%y years %m months %d days');
        $result->setData(['output' => $output, 'cities' => $cities]);
        return $result;
    } 
}