<?php
/**
 * Zeon Solutions, Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Zeon Solutions License
 * that is bundled with this package in the file LICENSE_ZE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.zeonsolutions.com/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zeonsolutions.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please refer to http://www.zeonsolutions.com for more information.
 *
 * @category    Zeon
 * @package     Zeon_Manufacturer
 * @copyright   Copyright (c) 2012 Zeon Solutions, Inc. All Rights Reserved.(http://www.zeonsolutions.com)
 * @license     http://www.zeonsolutions.com/license/
 */

class Zeon_Manufacturer_IndexController extends Mage_Core_Controller_Front_Action
{
    const XML_PATH_ENABLED = 'zeon_manufacturer/general/is_enabled';

    public function preDispatch()
    {
        parent::preDispatch();

        if ( !Mage::getStoreConfigFlag(self::XML_PATH_ENABLED) ) {
            $this->norouteAction();
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return;
        }
    }

    public function indexAction()
    {
        $this->loadLayout();
		$this->getLayout()->getBlock('head')->setTitle('Marcas');
        $this->renderLayout();
    }

    public function viewAction()
    {
        $this->loadLayout();
		$manufacturerId = $this->getRequest()->getParam('manufacturer_id', false);
		$manufacturer = Mage::getModel('zeon_manufacturer/manufacturer')->setStoreId(Mage::app()->getStore()->getId())->load($manufacturerId);
		$manufacturer = Mage::getModel('zeon_manufacturer/manufacturer')->getManufacturerName($manufacturer->getManufacturer(), Mage::app()->getStore()->getId());
		$website = Mage::app()->getStore()->getFrontendName();
		$this->getLayout()->getBlock('head')->setTitle("$manufacturer | $website");
        $this->renderLayout();
    }

}