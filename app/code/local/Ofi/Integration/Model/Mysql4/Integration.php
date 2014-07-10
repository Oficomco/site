<?php


class Ofi_Integration_Model_Mysql4_Integration extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        $this->_init('integration/integration', 'id');
    }

}
