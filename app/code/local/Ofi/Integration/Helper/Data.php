<?php

class Ofi_Integration_Helper_Data extends Mage_Core_Helper_Abstract
{

	/**
	* Set the header string with authentication
	*
	* @return The header string
	*/
	function _makeHeaderString(){
		$account = "3803303";
		$email = "mauricio.beltran@ofi.com.co";
		$pass = "MB0fic0mc0123";
		$role_id = "3";

		$content_type = "application/json";

		return  "Authorization: NLAuth nlauth_account=". $account . ", " .
			"nlauth_email=" . $email . ", " .
			"nlauth_signature=" . $pass . ", " .
			"nlauth_role=" . $role_id . "\r\n".
			"Content-Type:" . $content_type;  
	}

	/**
	* Validate a customer data in Netsuite
	*
	* @param $magentoid
	*/
   	public function validateCustomerInNetsuite($magentoid){
		$context = $this->_makeContextSearch($magentoid);

		//Send the JSON to the server
		$host ="https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=90&deploy=1";
		$response = file_get_contents($host, false, $context);

   		return $response;
   	}


	/**
	* Send customer data to Netsuite
	*
	* @param $customer
	*/
   	public function sendCustomerToNetsuite($customer){
		$context = $this->_makeContextCustomer($customer);
   	}


   	/**
	* Save the order data locally, to send it later
	*
	* @param $order
	*/
   	public function sendOrderToNetsuite($order){
   		$context = $this->_makeContextOrder($order);
   	}


   	/**
	* Save the order update data locally, to send it later
	*
	* @param $order
	*/
   	public function sendOrderUpdateToNetsuite($order){
   		$context = $this->_makeContextUpdateOrder($order);
   	}



   	/** Returns a stream context with the Authorization Header and Content set */
	function _makeContextSearch($magentoid){ 
		$w = new searchWrapper();
		$s = new search();

		$s->magentoid = $magentoid;
		$w->records = array($s);

	   	$json_string = json_encode($w);

		$options = array(
			'http'=>array(
			'header'=> $this->_makeHeaderString(),
			'method'=>"POST",
			'timeout'=>300,
			'content' => $json_string 
			)
		);
	    return stream_context_create($options);
	}

   	/** 
   	* Returns a stream context with the Authorization Header and Content set 
   	*/
	function _makeContextCustomer($customer){
		$customerID = $customer->getId();

		$wrapper = new customerWrapper();
		$c = new customer();

		//Get the address collection
		$addressCollection = $customer->getAddresses();

		if ($addressCollection != null){
			foreach ($addressCollection as $address) {
				$a1 = new address();
				$arrayA[] = "";

				$cityName = $this->_getCityName($address->getCity());

    			$a1->addresstype = "";
			    $a1->attention  = $address->getCompany();
			    $a1->address1 = $address->getStreet(1);
			    $a1->address2 = $address->getStreet(2);
			    $a1->city = $cityName;
			    $a1->state = $address->getRegion();
			    $a1->country = $address->getCountryId();
			    $a1->phone = $address->getTelephone();
			    $a1->mobilephone = "";
			    $a1->fax = $address->getFax();

			    $arrayA[] = $a1;
			}

			//Add the addresses to the customer array
			$c->addresses = array($arrayA);
		}

		//Check the subscription
		$sendemail = "F";
		$unsubscribe = "T";
		$emailExist = Mage::getModel('newsletter/subscriber')->load($customer->getEmail(), 'subscriber_email');
		if ($emailExist->getId()) {
		    $sendemail = "T";
		    $unsubscribe = "F";
		}

		//Set the customer data
	    $c->magentoid = $customer->getId();
	    $c->salutation = $customer->getPrefix();
		$c->firstname = htmlentities($customer->getFirstname());
	    $c->middlename = htmlentities($customer->getMiddlename());
	    $c->lastname = htmlentities($customer->getLastname());
	    $c->gender = $customer->getGender();
	    $c->email = $customer->getEmail();
	    $c->altemail = $customer->getAltEmail();
	    
	    if($customer->getDob() != ""){
	    	$datetoshow = date("d/m/Y", strtotime($customer->getDob()));
	    	$c->dob = $datetoshow ;	
	    }

	    $c->documentType = $customer->getDocumentType();
	    $c->nit = $customer->getNit();
	    $c->title = $customer->getTitle();
		$c->companyname = $customer->getCompanyName();
	    $c->companyurl = $customer->getCompanyUrl();
	    $c->sendemail = $sendemail;
	    $c->unsubscribe = $unsubscribe;
    	$c->customertype = "PROSPECT";

    	if($customer->getDocumentType() == 109)
    		$c->isperson = "F";
    	else
    		$c->isperson = "T";

    	$c->clientStatus = $customer->getClientStatus();
   
   		//Add the customer data to the wrapper
		$wrapper->records = array($c);

		//Encode to JSON
	   	$json_string = json_encode($wrapper);
	   	$tempo1 = str_replace("[[\"\",", "[", $json_string);
	   	$tempo2 = str_replace("]]", "]", $tempo1);
	   	$tempo3 = str_replace(",\"\",", ",", $tempo2);
	   	$json_string = $tempo3;

		//Save the JSON into the database
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$currentTime = now();
		$query = "INSERT INTO `ofi_integration_json` (`creation_date`, `customer_id`, `type`, `json`, `sent`) 
					VALUES ('" . $currentTime. "'," . $customerID. ",1,'" . $json_string ."',0);";
		$DB->exec($query);
	}

	/** 
   	* Returns a stream context with the Authorization Header and Content set 
   	*/
	function _makeContextOrder($order){ 
		$orderID = $order->getId();

		$wrapper = new orderWrapper();
		$o = new order();

		// Get the customer data
        $orderCustomerId = $order->getCustomerId();
		$customer = Mage::getModel('customer/customer')->load($orderCustomerId);
		$billing_address = $order->getBillingAddress();
        $shipping_address = $order->getShippingAddress();

        // Get payment method
        $payment = $order->getPayment();
		$paymentMethod = $payment->getData('method');

		// Date format
		$orderDate = (string)$order->getCreatedAtDate();

		// Set the items
		$items = $order->getAllItems();
        foreach ($items as $itemId => $item){
        	$i1 = new item();
        	$arrayA[] = "";

        	// Get the netsuite id
        	$_product = Mage::getModel('catalog/product')->load($item->getProductId());
			$netsuiteId = $_product->getResource()->getAttribute('netsuite_id')->getFrontend()->getValue($_product);
			
			//Get the tax class
			$taxClassId = $_product->getTaxClassId();

			switch ($taxClassId) {
			    case 0:
			    	//0
			        $taxcode = 1709;
			        break;
			    case 4:
			        //IVA_5
			        $taxcode = 8782;
			        break;
			    case 2:
			    	//IVA_16
			        $taxcode = 708;
			        break;
			}

			//Get the item prices
			$itemPrice = $_product->getPrice();
			$itemSpecialPrice = $_product->getSpecialPrice();
			$itemSoldPrice = $item->getPrice();

			if($itemSoldPrice == $itemPrice)
				$priceLevel = 5;
			else
				$priceLevel = 6;

			$i1->item = $netsuiteId;
			$i1->quantity = $item->getQtyToInvoice();
			$i1->taxcode = $taxcode;
			$i1->price = $priceLevel;

			$arrayA[] = $i1;
        }

		$o->item = array($arrayA);


        // Set the order data
        $o->incrementalId = $order->getIncrementId();
        $o->total = $order->getGrandTotal();
		$o->altshippingcost = $order->getShippingAmount();
		$o->taxtotal = $order->getTaxAmount();
		$o->shipcomplete = false;
		$o->discountrate = $order->getDiscountAmount();
		$o->entity = "0";

		$cityName = $this->_getCityName($billing_address->getCity());

		$o->billaddress = $customer->getFirstname() ." " . $customer->getLastname() . " " . $billing_address->getStreet(1) . " " . $billing_address->getStreet(2) . " " . $cityName . " " . $billing_address->getRegion() . " " . $billing_address->getCountryId();
		$o->salesrep = "-5";
		$o->ccapproved = false;
		$o->linkedtrackingnumbers = "";
		$o->shipmethod = "9583";
		$o->exchangerate = 1.00;
		$o->lastmodifieddate = $orderDate;
		$o->taxrate = "8.25%";
		$o->id = "769";

		$o->shipaddresslist = "55";
		$o->istaxable = true;
		$o->tobefaxed = false;
		$o->altsalestotal = 0.00;
		$o->getauth = false;
		$o->tobeprinted = false;
		$o->shippingcost = $order->getShippingAmount();
		$o->recordtype = "salesorder";
		$o->trandate = $orderDate;
		$o->fax = "";
		$o->customform = "88";

		$o->taxitem = "-112";
		$o->custbody1 = "";
		$o->custbody2 = "";
		$o->shipdate = "";
		$o->createddate = $orderDate;
		$o->subtotal = $order->getSubtotal();
		$o->currencyname = "COP";
		$o->revenuestatus = "A";
		$o->saleseffectivedate = $orderDate;
		$o->email = $customer->getEmail();

		$o->excludecommission = false;
		
		$cityName = $this->_getCityName($shipping_address->getCity());

		$o->shipaddress = $shipping_address->getStreet(1) . " " . $shipping_address->getStreet(2) . " " . $cityName . " " . $shipping_address->getRegion() . " " . $shipping_address->getCountryId();
		$o->magentoid = $orderCustomerId;

		// Set payment method
		switch ($paymentMethod) {
			case 'payu':
				$o->paymentmethod = 7;
				break;
			case 'cashondelivery':
				$o->paymentmethod = 8;
				break;
			default:
				$o->paymentmethod = 1;
				break;
		}

		// CUSTOMER DATA
		//Get the address collection
		$addressCollection = $customer->getAddresses();

		if ($addressCollection != null){
			foreach ($addressCollection as $address) {
				$b1 = new address();
				$arrayB[] = "";

    			$b1->addresstype = "";
			    $b1->attention  = $address->getCompany();
			    $b1->address1 = $address->getStreet(1);
			    $b1->address2 = $address->getStreet(2);

			    $cityName = $this->_getCityName($address->getCity());

			    $b1->city = $cityName;
			    $b1->state = $address->getRegion();
			    $b1->country = $address->getCountryId();
			    $b1->phone = $address->getTelephone();
			    $b1->mobilephone = "";
			    $b1->fax = $address->getFax();

			    $arrayB[] = $b1;
			}

			//Add the addresses to the customer array
			$o->addresses = array($arrayB);
		}

		//Check the subscription
		$sendemail = "F";
		$unsubscribe = "T";
		$emailExist = Mage::getModel('newsletter/subscriber')->load($customer->getEmail(), 'subscriber_email');
		if ($emailExist->getId()) {
		    $sendemail = "T";
		    $unsubscribe = "F";
		}

		//Set the customer data
	    $o->magentoid = $customer->getId();
	    $o->salutation = $customer->getPrefix();
		$o->firstname = $customer->getFirstname();
	    $o->middlename = $customer->getMiddlename();
	    $o->lastname = $customer->getLastname();
	    $o->gender = $customer->getGender();
	    $o->email = $customer->getEmail();
	    $o->altemail = $customer->getAltEmail();
	    
	    if($customer->getDob() != ""){
	    	$datetoshow = date("d/m/Y", strtotime($customer->getDob()));
	    	$o->dob = $datetoshow ;	
	    }

	    $o->documentType = $customer->getDocumentType();
	    $o->nit = $customer->getNit();
	    $o->title = $customer->getTitle();
		$o->companyname = $customer->getCompanyName();
	    $o->companyurl = $customer->getCompanyUrl();
	    $o->sendemail = $sendemail;
	    $o->unsubscribe = $unsubscribe;
    	$o->customertype = "PROSPECT";
    	
    	if($customer->getDocumentType() == 109)
    		$o->isperson = "F";
    	else
    		$o->isperson = "T";

    	$o->clientStatus = $customer->getClientStatus();
   		
   		// CUSTOMER DATA
   		//Add the customer data to the wrapper
		$wrapper->records = array($o);

	   	//Encode to JSON
	   	$json_string = json_encode($wrapper);
	   	$tempo1 = str_replace("[[\"\",", "[", $json_string);
	   	$tempo2 = str_replace("]]", "]", $tempo1);
	   	$tempo3 = str_replace(",\"\",", ",", $tempo2);
	   	$json_string = $tempo3;

		//Save the JSON into the database
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$currentTime = now();
		$query = "INSERT INTO `ofi_integration_json` (`creation_date`, `customer_id`, `order_id`, `type`, `json`, `sent`) 
					VALUES ('" . $currentTime. "'," . $orderCustomerId . "," .$orderID. ",2,'" . $json_string ."',0);";
		$DB->exec($query);
	}

	/** 
   	* Returns a stream context with the Authorization Header and Content set 
   	*/
	function _makeContextUpdateOrder($order){ 
		$wrapper = new orderUpdateWrapper();
		$o = new orderUpdate();

		$orderID = $order->getId();
        $orderCustomerId = $order->getCustomerId();
	
		$o->idSalesOrder = 3918;
		$o->estado = 4;
		$wrapper->records = array($o);

	   	//Encode to JSON
	   	$json_string = json_encode($wrapper);
	   	$tempo1 = str_replace("[[\"\",", "[", $json_string);
	   	$tempo2 = str_replace("]]", "]", $tempo1);
	   	$tempo3 = str_replace(",\"\",", ",", $tempo2);
	   	$json_string = $tempo3;

		//Save the JSON into the database
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$currentTime = now();
		$query = "INSERT INTO `ofi_integration_json` (`creation_date`, `customer_id`, `order_id`, `type`, `json`, `sent`) 
					VALUES ('" . $currentTime. "'," . $orderCustomerId . "," .$orderID. ",3,'" . $json_string ."',0);";
		$DB->exec($query);
	}



	/**
	* Send customer data to Netsuite (from JSON file)
	*
	* @param $customerID
	* @param $jsonString
	*/
   	public function sendCustomerToNetsuiteBatch($customerID, $jsonString){
		//Make tht context
		$context = $this->_makeContext($jsonString);

		//Send the JSON to the server
		$host ="https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=90&deploy=1";
		$response = file_get_contents($host, false, $context);

		return $response;
   	}
	

   	/**
	* Send order data to Netsuite (from JSON file)
	*
	* @param $orderID
	* @param $jsonString
	*/
   	public function sendOrderToNetsuiteBatch($orderID, $jsonString){
		//Make the context
		$context = $this->_makeContext($jsonString);

		//Send the JSON to the server
		$host ="https://rest.na1.netsuite.com/app/site/hosting/restlet.nl?script=90&deploy=1";
		$response = file_get_contents($host, false, $context);

   		return $response;
   	}


   	/** 
   	* Returns a stream context with the Authorization Header and Content set 
   	*/
	function _makeContext($json_string){
		$options = array(
			'http'=>array(
			'header'=> $this->_makeHeaderString(),
			'method'=>"POST",
			'timeout'=>300,
			'content' => $json_string 
			)
		);
	    return stream_context_create($options);
	}


   	
   	/**
	* Gets the city name based on the id
	*/
   	function _getCityName($cityId){
   		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$query = "SELECT `default_name`
		         FROM `ofi_directory_city`
		         WHERE `city_id` = ".$cityId;

		foreach ($DB->fetchAll($query) as $rs) {
			$cityName = $rs['default_name'];
		}

		return $cityName;
   	}
}





/**
* CUSTOM CLASSES
*/



/**
* Search wrapper class definition
*/
class searchWrapper {
    public $records = "";
	public $recordType = "searchCustomer";
}

/**
* Search class definition
*/
class search {
    public $magentoid = "";
}

/**
* Customer wrapper class definition
*/
class customerWrapper 
{
    public $records = "";
	public $recordType = "customer";
}

/**
* Customer class definition
*/
class customer
{
	public $magentoid = "";
    public $salutation = "";
    public $firstname = "";
    public $middlename  = "";
    public $lastname = "";
    public $gender = "";
    public $email = "";
    public $altemail = "";
    public $dob = "";
    public $documentType = "";
    public $nit = "";
    public $title = "";
	public $companyname = "";
    public $companyurl = "";
    public $sendemail = "";
    public $unsubscribe = "";
    public $customertype = "";
    public $isperson = "";
    public $clientStatus = "";
    public $addresses = "";
}

/**
* Address class definition
*/
class address 
{
    public $addresstype = "";
    public $attention  = "";
    public $address1 = "";
    public $address2 = "";
    public $city = "";
    public $state = "";
    public $country = "";
    public $phone = "";
    public $mobilephone = "";
    public $fax = "";
}



/**
* Update order wrapper class definition
*/
class orderUpdateWrapper {
    public $records = "";
	public $recordType = "updateSalesOrder";
}

/**
* Update order wrapper class definition
*/
class orderUpdate {
    public $idSalesOrder = "";
    public $estado = "";
}




/**
* Order wrapper class definition
*/
class orderWrapper {
    public $records = "";
	public $recordType = "salesOrder";
}

/**
* Order class definition
*/
class order {
    public $incrementalId = "";
    public $total = "";
	public $altshippingcost = "";
	public $taxtotal = "";
	public $shipcomplete = "";
	public $discountrate = "";
	public $entity = "";
	public $billaddress = "";
	public $salesrep = "";
	public $ccapproved = "";
	public $linkedtrackingnumbers = "";
	public $shipmethod = "";
	public $exchangerate = "";
	public $lastmodifieddate = "";
	public $taxrate = "";
	public $id = "";
	public $shipaddresslist = "";
	public $istaxable = "";
	public $tobefaxed = "";
	public $altsalestotal = "";
	public $getauth = "";
	public $tobeprinted = "";
	public $shippingcost = "";
	public $recordtype = "";
	public $trandate = "";
	public $fax = "";
	public $customform = "";
	public $taxitem = "";
	public $custbody1 = "";
	public $custbody2 = "";
	public $shipdate = "";
	public $createddate = "";
	public $subtotal = "";
	public $currencyname = "";
	public $revenuestatus = "";
	public $saleseffectivedate = "";
	public $email = "";
	public $item = "";
	public $excludecommission = "";
	public $shipaddress = "";
	public $magentoid = "";
	public $paymentmethod = "";

    public $salutation = "";
    public $firstname = "";
    public $middlename  = "";
    public $lastname = "";
    public $gender = "";
    public $altemail = "";
    public $dob = "";
    public $documentType = "";
    public $nit = "";
    public $title = "";
	public $companyname = "";
    public $companyurl = "";
    public $sendemail = "";
    public $unsubscribe = "";
    public $customertype = "";
    public $isperson = "";
    public $clientStatus = "";
    public $addresses = "";
}

/**
* Items class definition
*/
class item {
	public $item = "";
	public $quantity = "";
	public $taxcode = "";
	public $price = "";
}
