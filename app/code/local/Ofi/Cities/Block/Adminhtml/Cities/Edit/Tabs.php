<?php
class Ofi_Cities_Block_Adminhtml_Cities_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('cities_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('cities')->__('Item Information'));
    }
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('cities')->__('Item Information'),
            'title' => Mage::helper('cities')->__('Item Information'),
            'content' => $this->getLayout()->createBlock('cities/adminhtml_cities_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
