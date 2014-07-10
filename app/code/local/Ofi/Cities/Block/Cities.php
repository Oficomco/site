<?php
class Ofi_Cities_Block_Cities extends Mage_Core_Block_Template
{
	protected $_address = array();
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getCities()
     {
        if (!$this->hasData('cities')) {
            $this->setData('cities', Mage::registry('cities'));
        }
        return $this->getData('cities');

    }
    
	/**
     * Get address model
     *
     * @return Mage_Sales_Model_Quote_Address
     */
    public function getAddress()
    {
        if (empty($this->_address)) {
            $this->_address = $this->getQuote()->getShippingAddress();
        }
        return $this->_address;
    }


}
