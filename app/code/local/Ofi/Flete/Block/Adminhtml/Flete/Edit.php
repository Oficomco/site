<?php

class Ofi_Flete_Block_Adminhtml_Flete_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'flete';
        $this->_controller = 'adminhtml_flete';
        
        $this->_updateButton('save', 'label', Mage::helper('flete')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('flete')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('flete_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'flete_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'flete_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('flete_data') && Mage::registry('flete_data')->getId() ) {
            return Mage::helper('flete')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('flete_data')->getTitle()));
        } else {
            return Mage::helper('flete')->__('Add Item');
        }
    }
}