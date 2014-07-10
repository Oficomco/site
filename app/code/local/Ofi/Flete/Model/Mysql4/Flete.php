<?php

class Ofi_Flete_Model_Mysql4_Flete extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the frete_id refers to the key field in your database table.
        $this->_init('flete/flete', 'flete_id');
    }
}