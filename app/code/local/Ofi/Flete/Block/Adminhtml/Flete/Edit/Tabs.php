<?php

class Ofi_Flete_Block_Adminhtml_Flete_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('flete_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('flete')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('flete')->__('Item Information'),
          'title'     => Mage::helper('flete')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('flete/adminhtml_flete_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}