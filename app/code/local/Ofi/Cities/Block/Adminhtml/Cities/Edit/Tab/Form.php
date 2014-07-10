<?php
class Ofi_Cities_Block_Adminhtml_Cities_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('cities_form', array('legend' => Mage::helper('cities')->__('Item information')));
		$DB = Mage::getSingleton('core/resource')->getConnection('core_write');	 
		$query = "SELECT region_id , default_name FROM directory_country_region WHERE country_id = 'CO' ORDER BY default_name";
		$result = $DB->fetchAll($query); 

		$array_region[0] = "Seleccione un departamento";
		for($i=0 ; $i<sizeof($result); $i++){
			$row = $result[$i];	
			$region_id = $row['region_id'];
			$region = $row['default_name'];
			
			$array_region[$region_id] = $region;
			
											
		}		  
	  
      $fieldset->addField('region_id', 'select', array(
          'label'     => 'Departamento',
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'region_id',
		  'options'   => $array_region ,		  
      ));
		

        $fieldset->addField('default_name', 'text', array(
            'label' => Mage::helper('cities')->__('Name'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'default_name',
        ));		
        
        if (Mage::getSingleton('adminhtml/session')->getCitiesData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCitiesData());
            Mage::getSingleton('adminhtml/session')->setCitiesData(null);
        } elseif (Mage::registry('cities_data')) {
            $form->setValues(Mage::registry('cities_data')->getData());
        }
        return parent::_prepareForm();
    }
}
