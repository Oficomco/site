<?php
class Ofi_Cities_Block_Adminhtml_Cities extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_cities';
        $this->_blockGroup = 'cities';
        $this->_headerText = Mage::helper('cities')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('cities')->__('Add Item');
        parent::__construct();
    }

}
