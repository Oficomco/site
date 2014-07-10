<?php

class Ofi_Integration_Model_Mysql4_Integration_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('integration/integration');
    }

	
}
