<?php class ThemeOptions_ExtraConfig_Model_Boxlayout
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'3', 'label'=>Mage::helper('ExtraConfig')->__('No')),
            array('value'=>'1', 'label'=>Mage::helper('ExtraConfig')->__('With Shadow')),
            array('value'=>'2', 'label'=>Mage::helper('ExtraConfig')->__('Without Shadow'))
            
            
        );
    }

}?>