<?php
class Ofi_Flete_Block_Adminhtml_Flete extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_flete';
    $this->_blockGroup = 'flete';
    $this->_headerText = Mage::helper('flete')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('flete')->__('Add Item');
    parent::__construct();
  }
}