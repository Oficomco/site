<?php


class Ofi_Cities_Model_Mysql4_Cities extends Mage_Core_Model_Mysql4_Abstract
{

    public function _construct()
    {
        // Note that the city_id refers to the key field in your database table.
        $this->_init('cities/cities', 'city_id');
    }

}
