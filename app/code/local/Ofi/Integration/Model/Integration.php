<?php


class Ofi_Integration_Model_Integration extends Mage_Core_Model_Abstract
{
 	public function _construct()
    {
        parent::_construct();
        $this->_init('integration/integration');
    }

}
