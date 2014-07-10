<?php
class Ofi_Cities_Block_Adminhtml_Cities_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('citiesGrid');
        $this->setDefaultSort('default_name');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('cities/cities')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('city_id', array(
            'header' => Mage::helper('cities')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'city_id',
        ));
 
         $this->addColumn('default_name', array(
            'header' => Mage::helper('cities')->__('Name'),
            'align' => 'left',
            'index' => 'default_name',
        ));
		
		$DB = Mage::getSingleton('core/resource')->getConnection('core_write');	 
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
          'header'    => Mage::helper('frete')->__('Departamento'),
          'align'     =>'left',
		  'type'  => 'options',
          'index'     => 'region_id',
		  'options' => $array_region,
		  
      ));	

        $this->addColumn('action',
            array(
                'header' => Mage::helper('cities')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('cities')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'action',
                'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('cities')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('cities')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('city_id');
        $this->getMassactionBlock()->setFormFieldName('cities');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('cities')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('cities')->__('Are you sure?')
        ));
        return $this;
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
