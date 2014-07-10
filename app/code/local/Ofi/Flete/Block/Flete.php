<?php
class Ofi_Flete_Block_Flete extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFlete()     
     { 
        if (!$this->hasData('flete')) {
            $this->setData('flete', Mage::registry('flete'));
        }
        return $this->getData('flete');
        
    }
}