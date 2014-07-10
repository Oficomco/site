<?php

class Ofi_Flete_Model_Flete extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('flete/flete');
    }
}
