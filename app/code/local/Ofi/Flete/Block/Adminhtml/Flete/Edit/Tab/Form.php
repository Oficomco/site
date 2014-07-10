<?php

class Ofi_Flete_Block_Adminhtml_Flete_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('flete_form', array('legend'=>Mage::helper('flete')->__('Item information')));
	  
	  $fieldset->addField('canal', 'select', array(
          'label'     => Mage::helper('flete')->__('Canal'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'canal',	  
      ));
     
		$DB = Mage::getSingleton('core/resource')->getConnection('core_write');	 
		$query = "SELECT city_id , default_name FROM ofi_directory_city ORDER BY default_name";
		$result = $DB->fetchAll($query); 

		$array_city[0] = "Seleccione una Ciudad";
		for($i=0 ; $i<sizeof($result); $i++){
			$row = $result[$i];	
			$city_id = $row['city_id'];
			$city = $row['default_name'];
			
			$array_city[$city_id] = $city;
			
											
		}		 
	 
      $fieldset->addField('city_id', 'select', array(
          'label'     => Mage::helper('flete')->__('Ciudad'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'city_id',
		  'options'   => $array_city ,		  
      ));

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
          'label'     => Mage::helper('flete')->__('Departamento'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'region_id',
		  'options'   => $array_region ,		  
      ));

      $fieldset->addField('monto', 'text', array(
          'label'     => Mage::helper('flete')->__('Monto'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'monto',
      ));
	  
	  $fieldset->addField('flete', 'text', array(
          'label'     => Mage::helper('flete')->__('Flete'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'flete',
      ));


      $fieldset->addField('adicional', 'text', array(
          'label'     => Mage::helper('flete')->__('Adicional Kg'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'adicional',
      ));	

      $fieldset->addField('tiempo', 'text', array(
          'label'     => Mage::helper('flete')->__('Tiempo de entrega'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'tiempo',
      ));		
	   	 	 	 	
	  
      if ( Mage::getSingleton('adminhtml/session')->getFleteData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFleteData());
          Mage::getSingleton('adminhtml/session')->setFleteData(null);
      } elseif ( Mage::registry('flete_data') ) {
          $form->setValues(Mage::registry('flete_data')->getData());
      }
      return parent::_prepareForm();
  }
}