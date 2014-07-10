<?php
/**
 * Zeon Solutions, Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Zeon Solutions License
 * that is bundled with this package in the file LICENSE_ZE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.zeonsolutions.com/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zeonsolutions.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please refer to http://www.zeonsolutions.com for more information.
 *
 * @category    Zeon
 * @package     Zeon_Manufacturer
 * @copyright   Copyright (c) 2012 Zeon Solutions, Inc. All Rights Reserved.(http://www.zeonsolutions.com)
 * @license     http://www.zeonsolutions.com/license/
 */

class Zeon_Manufacturer_Block_Adminhtml_Manufacturer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Set defaults
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('manufacturerGrid');
        $this->setDefaultSort('manufacturer_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Instantiate and prepare collection
     *
     * @return Zeon_Manufacturer_Block_Adminhtml_Manufacturer_Grid
     */
	
	 protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('zeon_manufacturer/manufacturer_collection');
		$tableNameEAOV = Mage::getModel('core/resource')->getTableName('eav_attribute_option_value');
		$tableNameEAO = Mage::getModel('core/resource')->getTableName('eav_attribute_option');

		$collection->getSelect()->distinct()->join(array('eaov' => $tableNameEAOV), 'main_table.manufacturer = eaov.option_id',array('manufacturer_name'=>'value'))
		->join(array('eao' => $tableNameEAO), 'eao.option_id = eaov.option_id',array());

		if (!Mage::app()->isSingleStoreMode()) {
		$collection->addStoresVisibility();
		}

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}


    /**
     * Define grid columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn('manufacturer_id', array(
                'header'=> Mage::helper('zeon_manufacturer')->__('ID'),
                'type'  => 'number',
                'width' => '1',
                'index' => 'manufacturer_id',
        ));

        $this->addColumn('manufacturer_name', array(
            'header' => Mage::helper('zeon_manufacturer')->__('Manufacturer Title'),
            'type'   => 'text',
            'index'  => 'manufacturer_name',
        ));
        
        $this->addColumn('update_time', array(
            'header'=> Mage::helper('zeon_manufacturer')->__('Update Time'),
            'type' => 'datetime',
            'index'=> 'update_time',
        ));

        $this->addColumn('status', array(
            'header'  => Mage::helper('zeon_manufacturer')->__('Status'),
            'align'   => 'center',
            'width'   => 1,
            'index'   => 'status',
            'type'    => 'options',
            'options' => Mage::getModel('zeon_manufacturer/status')->getAllOptions(),
        ));
        
        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('visible_in', array(
                    'header'     => Mage::helper('zeon_manufacturer')->__('Visible In'),
                    'type'       => 'store',
                    'index'      => 'stores',
                    'sortable'   => false,
                    'store_view' => true,
                    'width'      => 200
            ));
        }

        $this->addColumn('action', array(
                'header'  => Mage::helper('zeon_manufacturer')->__('Action'),
                'width'   => '50',
                'type'    => 'action',
                'align'   => 'center',
                'getter'  => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('zeon_manufacturer')->__('Edit'),
                        'url'     => array('base'=> '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('manufacturer_id');
        $this->getMassactionBlock()->setFormFieldName('manufacturer');
        $this->getMassactionBlock()->addItem('delete', array(
                'label'        => Mage::helper('zeon_manufacturer')->__('Delete'),
                'url'        => $this->getUrl('*/*/massDelete'),
                'confirm'    => Mage::helper('zeon_manufacturer')->__('Are you sure you want to delete these manufacturer?'),
        ));
        return $this;
    }

    /**
     * Grid row URL getter
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    /**
     * Define row click callback
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /**
     * Add store filter
     *
     * @param Mage_Adminhtml_Block_Widget_Grid_Column  $column
     * @return Zeon_Manufacturer_Block_Adminhtml_Manufacturer_Grid
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getIndex() == 'stores') {
            $this->getCollection()->addStoreFilter($column->getFilter()->getCondition(), false);
        } elseif ($column->getIndex() == 'manufacturer_name') {
            $this->getCollection()->addManufacturerNameFilter($column->getFilter()->getCondition());
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }
}