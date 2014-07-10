<?php
class Ofi_Cities_Block_Adminhtml_Cities_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'cities';
        $this->_controller = 'adminhtml_cities';

        $this->_updateButton('save', 'label', Mage::helper('cities')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('cities')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('cities_data') && Mage::registry('cities_data')->getId()) {
            return Mage::helper('cities')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('cities_data')->getDefaultName()));
        } else {
            return Mage::helper('cities')->__('Add Item');
        }
    }
}
