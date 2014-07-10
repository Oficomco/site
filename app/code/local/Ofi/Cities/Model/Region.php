<?php


class Ofi_Cities_Model_Region extends Mage_Core_Model_Abstract
{
 	public function _construct()
    {
        parent::_construct();
        $this->_init('cities/cities');
    }

}
