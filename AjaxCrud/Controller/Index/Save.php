<?php

namespace Aks\AjaxCrud\Controller\Index;

use Magento\Framework\App\Action\Context;
use Aks\AjaxCrud\Model\FormFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Framework\Filesystem;
use Magento\Store\Model\StoreManagerInterface;

class Save extends \Magento\Framework\App\Action\Action
{
	/**
     * @var CrudExample
     */
    protected $formFactory;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;
    protected $storeManager;

    public function __construct(
		Context $context,
        FormFactory $formFactory,
        UploaderFactory $uploaderFactory,
        AdapterFactory $adapterFactory,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager
    ) {
        $this->formFactory = $formFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
	public function execute()
    {
        $data = $this->getRequest()->getParams();
        $storeId = $this->storeManager->getStore()->getStoreId();
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            try{
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $imageAdapter = $this->adapterFactory->create();
                $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('ajaxcrud/image/');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                
                $imagePath = 'ajaxcrud/image'.$result['file'];
                $data['image'] = $imagePath;
                $data['store_id'] = $storeId;
            } catch (\Exception $e) {
            }
        }
    	$formFactory = $this->formFactory->create();
        $formFactory->setData($data);
        if($formFactory->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('ajaxcrud/index');
        return $resultRedirect;
    }
}
