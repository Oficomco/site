<?php

class Ofi_Cities_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_cityJson;
	protected $_regionCollection;
	/**
	 * Retrieve cities data json
	 *
	 * @return string
	 */
	public function getCityJson()
	{

		if (!$this->_cityJson) {
			$cacheKey = 'OFI_DIRECTORY_CITIES_JSON_STORE'.Mage::app()->getStore()->getId();
			if (Mage::app()->useCache('config')) {
				$json = Mage::app()->loadCache($cacheKey);
			}
			if (empty($json)) {
				$regionIds = array();
				foreach ($this->getRegionCollection() as $region) {
					$regionIds[] = $region->getRegionId();
				}
				$collection = Mage::getModel('cities/cities')->getResourceCollection()
				->addRegionFilter($regionIds)
				->setOrder('default_name', 'ASC')
				->load();
				$cities = array();
				foreach ($collection as $city) {
					if (!$city->getCityId()) {
						continue;
					}
					$cities[$city->getRegionId()][$city->getCityId()] = array(
                        'code'=>$city->getCode(),
                        'name'=>$city->getDefaultName()
					);
				}
				$json = Mage::helper('core')->jsonEncode($cities);

				if (Mage::app()->useCache('config')) {
					Mage::app()->saveCache($json, $cacheKey, array('config'));
				}
			}
			$this->_cityJson = $json;
		}

		return $this->_cityJson;
	}

	public function getRegionCollection()
	{
		if (!$this->_regionCollection) {
			$this->_regionCollection = Mage::getModel('directory/region')->getResourceCollection()
			->load();
		}
		return $this->_regionCollection;
	}
}
