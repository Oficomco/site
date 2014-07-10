<?php

class Ofi_Flete_Model_Mysql4_Flete_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('flete/flete');
    }
}