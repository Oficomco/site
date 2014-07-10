<?php


class Ofi_Cities_Model_Cities extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('cities/cities');
    }
    
	public function getHtmlCities($region, $selected="")
	{
		$collection = Mage::getModel('cities/cities')->getResourceCollection()
				->addRegionFilter($region)
				->load();
        //$collection = $this->getCollection();
       // $size = $collection->getSize();
       // $cnt = count($collection);
        //$select.="<option value=\"\">- Seleccione su ciudad -</option>";
        $select = "";
        foreach ($collection as $item) {
			$ville=$item->getDefaultName();
			$sel=$ville==$selected?"selected=\"true\"":"";
            $select.="<option value=\"$ville\" $sel>$ville</option>\n";
        }

		//$select.="</select>";


        return $select;
	}

}
