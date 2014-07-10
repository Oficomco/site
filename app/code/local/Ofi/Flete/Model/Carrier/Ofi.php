<?php
class Ofi_Flete_Model_Carrier_Ofi extends Mage_Shipping_Model_Carrier_Abstract {
	
	protected $_code = 'ofi';

	public function collectRates(Mage_Shipping_Model_Rate_Request $request){
	
		if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active')) {
			return false;
		}
		

        $weight    = $request->getPackageWeight();
        $city_id   = $request->getDestCity();
        $itemPrice = $request->getPackageQty();
        $total     = $request->getPackageValue();
        		
		//print_r($total);
		
		$DB = Mage::getSingleton('core/resource')->getConnection('core_write');
		$query = "SELECT monto, flete, tiempo, canal FROM ofi_flete WHERE city_id = '$city_id'";
		$results = $DB->fetchAll($query);
		$result = $DB->fetchRow($query);

		
		//costos fijos
		$valor_inicial = 10000;
		$valor_final= 60000;
		$flete_especial =  17500;
		$tarifa = 40000;
		$valor_adicional = 2800;
		$monto3 = 80000;
		
		//Verificamos si es trayecto especial
		$canal = $result['canal'];
	    if($canal == 'TRAYECTO ESPECIAL'):
				if($total >= $valor_inicial && $total <= $valor_final):
					$fleteTotal = $flete_especial;
				else:
					$fleteTotal = $flete_especial + ($valor_adicional*($total/$tarifa));
				endif;
		else:
			for ($i = 0; $i < count($results); $i++) { // Bucle exterior
			        $row = $results[$i];
					$monto = $row['monto'];
					$flete = $row['flete'];
			
				for ($j = 1; $j < count($results); $j++) { // Bucle interior
			        $row2 = $results[$j];
					$monto2 = $row2['monto'];
					$flete2 = $row2['flete'];
					   
					if($total >= $monto && $total < $monto2):
				         $fleteTotal = $flete;
					     break;
					elseif($total >= $monto2 && $total < $monto3):
						$fleteTotal = $flete2;
						break;
					elseif($total >= $monto3):
					    $fleteTotal = 0;
						break;
					endif;		
						
					 	
			    }
			
			}
		endif;
		
		  /*$canal = $result['canal'];
	       if($canal == 'TRAYECTO ESPECIAL'):
			   if($total >= $valor_inicial && $total <= $valor_final):
					$fleteTotal = $flete_especial;
				else:
					$fleteTotal = $flete_especial + ($valor_adicional*($total/$tarifa));
				endif;
		   else:
			   $fleteTotal = 9900;
		   endif;*/
		
		
		
		$handling = Mage::getStoreConfig('carriers/'.$this->_code.'/handling');
		$result = Mage::getModel('shipping/rate_result');

		$method = Mage::getModel('shipping/rate_result_method');
		$method->setCarrier($this->_code);
		$method->setMethod($this->_code);
		$method->setCarrierTitle($this->getConfigData('title'));
		$method->setMethodTitle($this->getConfigData('title'));
		
		//Verifica se existe regra pra frete gratis
		if($request->getFreeShipping() === true){
			$method->setCost(0.00);
			$method->setPrice(0.00);	
		}
		else{
			$method->setPrice($fleteTotal);
			$method->setCost($fleteTotal);
			
		}
		
		$result->append($method);

		return $result;
	}

   

	
}
