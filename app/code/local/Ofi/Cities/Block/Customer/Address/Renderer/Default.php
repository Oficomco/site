<?php
class Ofi_Cities_Block_Customer_Address_Renderer_Default extends Mage_Customer_Block_Address_Renderer_Default
{
    /**
     * Render address
     *
     * @param Mage_Customer_Model_Address_Abstract $address
     * @return string
     */
    public function render(Mage_Customer_Model_Address_Abstract $address, $format=null)
    {
        switch ($this->getType()->getCode()) {
            case 'html':
                $dataFormat = Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_HTML;
                break;
            case 'pdf':
                $dataFormat = Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_PDF;
                break;
            case 'oneline':
                $dataFormat = Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_ONELINE;
                break;
            default:
                $dataFormat = Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_TEXT;
                break;
        }

        $formater   = new Varien_Filter_Template();
        $attributes = Mage::helper('customer/address')->getAttributes();

        $data = array();
        foreach ($attributes as $attribute) {
            /* @var $attribute Mage_Customer_Model_Attribute */
            if (!$attribute->getIsVisible()) {
                continue;
            }
            if ($attribute->getAttributeCode() == 'country_id') {
                $data['country'] = $address->getCountryModel()->getName();
            } else if ($attribute->getAttributeCode() == 'region') {
                
				$DB = Mage::getSingleton('core/resource')->getConnection('core_write');
				$query = "SELECT default_name FROM directory_country_region WHERE region_id = '". $address->getData('region_id') ."'";
				$row = $DB->fetchRow($query);
				$data['region'] = $row['default_name'];					

            } else if ($attribute->getAttributeCode() == 'city') {
            	//Retrieve info id
            	$city   = $address->getData('city');
            	//Find the city model
            	$city = Mage::getModel('cities/cities')->load($city);
            	$this->setData('city', $city);
            	//Set the defail_name in data
                $data['city'] = $city->getDefaultName();
            }else {
                $dataModel = Mage_Customer_Model_Attribute_Data::factory($attribute, $address);
                $value     = $dataModel->outputValue($dataFormat);
                if ($attribute->getFrontendInput() == 'multiline') {
                    $values    = $dataModel->outputValue(Mage_Customer_Model_Attribute_Data::OUTPUT_FORMAT_ARRAY);
                    // explode lines
                    foreach ($values as $k => $v) {
                        $key = sprintf('%s%d', $attribute->getAttributeCode(), $k + 1);
                        $data[$key] = $v;
                    }
                }
                $data[$attribute->getAttributeCode()] = $value;
            }
        }

        if ($this->getType()->getHtmlEscape()) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->htmlEscape($value);
            }
        }

        $formater->setVariables($data);

        $format = !is_null($format) ? $format : $this->getFormat($address);

        return $formater->filter($format);
    }
}
