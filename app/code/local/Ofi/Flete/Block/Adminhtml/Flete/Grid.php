<?php

class Ofi_Flete_Block_Adminhtml_Flete_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('fleteGrid');
      $this->setDefaultSort('flete_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('flete/flete')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('flete_id', array(
          'header'    => Mage::helper('flete')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'flete_id',
      ));

		$DB = Mage::getSingleton('core/resource')->getConnection('core_write');	 
		$query = "SELECT city_id , default_name FROM ofi_directory_city ORDER BY default_name";
		$result = $DB->fetchAll($query); 

		for($i=0 ; $i<sizeof($result); $i++){
			$row = $result[$i];	
			$city_id = $row['city_id'];
			$city = $row['default_name'];
			
			$array_cidade[$city_id] = $city;
			
		}		  
	  
      $this->addColumn('city_id', array(
          'header'    => Mage::helper('flete')->__('Ciudad'),
          'align'     =>'left',
		  'type'  => 'options',
          'index'     => 'city_id',
		  'options' => $array_cidade,
		  
      ));
	  
		$query = "SELECT region_id , default_name FROM directory_country_region WHERE country_id = 'CO' ORDER BY default_name";
		$result = $DB->fetchAll($query); 

		$array_region[0] = "Seleccione una Ciudad";
		for($i=0 ; $i<sizeof($result); $i++){
			$row = $result[$i];	
			$region_id = $row['region_id'];
			$region = $row['default_name'];
			
			$array_region[$region_id] = $region;
			
											
		}	  
	  
      $this->addColumn('region_id', array(
          'header'    => Mage::helper('flete')->__('Departamento'),
          'align'     =>'left',
		  'type'  => 'options',
          'index'     => 'region_id',
		  'options' => $array_region,
		  
      ));	  

      $this->addColumn('monto', array(
          'header'    => Mage::helper('flete')->__('Monto'),
          'align'     =>'left',
          'index'     => 'monto',
      ));
	  
	  $this->addColumn('flete', array(
          'header'    => Mage::helper('flete')->__('Flete'),
          'align'     =>'left',
          'index'     => 'flete',
      ));

      $this->addColumn('adicional', array(
          'header'    => Mage::helper('flete')->__('Adicional Kg'),
          'align'     =>'left',
          'index'     => 'adicional',
      ));	  

      $this->addColumn('tiempo', array(
          'header'    => Mage::helper('flete')->__('Tiempo de entrega'),
          'align'     =>'left',
          'index'     => 'tiempo',
      ));	
  		  
 		
		$this->addExportType('*/*/exportCsv', Mage::helper('flete')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('flete')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}