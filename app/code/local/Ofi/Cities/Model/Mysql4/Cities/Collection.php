<?php

class Ofi_Cities_Model_Mysql4_Cities_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('cities/cities');
    }

	public function addRegionFilter($regionId)
    {
        if (!empty($regionId)) {
        	$tableName = Mage::getSingleton('core/resource')->getTableName('cities/cities');
        	
            if (is_array($regionId)) {
                $this->addFieldToFilter('region_id', array('in'=>$regionId));
            } else {
                $this->addFieldToFilter('region_id', $regionId);
            }
        }
        return $this;
    }
}
