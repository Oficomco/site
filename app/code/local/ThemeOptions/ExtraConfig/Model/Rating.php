<?php class ThemeOptions_ExtraConfig_Model_Rating
{
    public function toOptionArray()
    {
        return array(
            
            array('value'=>'hover', 'label'=>Mage::helper('ExtraConfig')->__('Hover')),
            array('value'=>'default', 'label'=>Mage::helper('ExtraConfig')->__('Default'))     
        );
    }

}?>