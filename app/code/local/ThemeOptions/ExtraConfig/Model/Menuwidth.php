<?php class ThemeOptions_ExtraConfig_Model_Menuwidth
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'full', 'label'=>Mage::helper('ExtraConfig')->__('Full Width')),
            array('value'=>'template', 'label'=>Mage::helper('ExtraConfig')->__('Template Width'))
            
        );
    }

}?>