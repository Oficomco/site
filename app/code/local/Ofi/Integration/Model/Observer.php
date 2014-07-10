<?php
class Ofi_Integration_Model_Observer {
	
	private $_categoryTree = array();
	private $_categoryProducts = array();

	private $_fromName = 'Admin';
	private $_fromEmail = 'admin@ofi.com.co';
	private $_toName = 'Luz Ortega';
	private $_toEmail = 'luz.ortega@ofi.com.co';



	/**
	 * Exports the pending clients to Netsuite
	 *
	 * @return bool
	 */
	public function startexportActionClientsBatch() {
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$query = "SELECT `id`,`customer_id`,`json`
		         FROM `ofi_integration_json`
		         WHERE `sent` = 0 and `type`=1;";

		try {
			foreach ($DB->fetchAll($query) as $rs) {
				$id = $rs['id'];
				$customerID = $rs['customer_id'];
				$fileContent = $rs['json'];
				$currentTime = now();

				// Send to netsuite
				$helper = Mage::helper('integration');
                $response  = $helper->sendCustomerToNetsuiteBatch($customerID, $fileContent);

                // Update the record
                $query = "UPDATE `ofi_integration_json`
                			SET `sent` = 1,
                			`sent_date` = '" . $currentTime . "',
                			`response` = '" . $response . "'
		         			WHERE `id` = " . $id . ";";

		        $DB->exec($query);
		 	}
		}catch (MySQLDuplicateKeyException $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}catch (MySQLException $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}catch (Exception $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}

		return true;
	}


	/**
	 * Exports the pending orders to Netsuite
	 *
	 * @return bool
	 */
	public function startexportActionOrdersBatch() {
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$query = "SELECT `id`,`customer_id`,`order_id`,`json`
		         FROM `ofi_integration_json`
		         WHERE (`sent` = 0 or `response` ='') and `type`=2;";

		try {
			foreach ($DB->fetchAll($query) as $rs) {
				$id = $rs['id'];
				$customer_id = $rs['customer_id'];
				$orderID = $rs['order_id'];
				$fileContent = $rs['json'];
				$currentTime = now();

				//Validate the netsuite customer id
				$helper = Mage::helper('integration');
		        $idNew = $helper->validateCustomerInNetsuite($customer_id);
		        
		        if($idNew == "0"){
		        	//Mage::getSingleton('adminhtml/session')->addError("NO ESTA");
		        	//TBD
		        }else{
		        	//REPLACE "id":""
		        	$fileContentTemp = str_replace('"entity":""', '"entity":'.$idNew, $fileContent);
		        	$fileContent = $fileContentTemp;
		        }

				// Send to netsuite
				$helper = Mage::helper('integration');
               	$response = $helper->sendOrderToNetsuiteBatch($orderID, $fileContent);

               	if($response != '[]' && $response != ''){
               		// Update the record
			        $query = "UPDATE `ofi_integration_json`
	                			SET `sent` = 1,
	                			`sent_date` = '" . $currentTime . "',
	                			`response` = '" . $response . "'
			         			WHERE `id` = " . $id . ";";

			        $DB->exec($query);
               	}
		 	}
		}catch (MySQLDuplicateKeyException $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}catch (MySQLException $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}catch (Exception $e) {
		    Mage::log($e,null,'integration.log');
			return false;
		}

		return true;
	}


/**
	 * Imports the data from a remote XML with orders
	 *
	 * @return bool
	 */
	public function startimportActionOrdersBatch(){
		$title = 'Importación de Ordenes de Venta';

		$filename = 'http://localhost/test.xml';
		$ordersFileLogPath = 'var/log/orders/';
		$logFilename = Mage::getBaseDir () . DS . $ordersFileLogPath . "order_log_full_" . date ( 'mdY' ) . ".txt";
		
		// Start to log
		$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
		$this->saveProductLog ( $logFilename, "INICIANDO " . date ( 'm-d-Y H:i:s' ) );
		$this->saveProductLog ( $logFilename, "SERVIDOR " . Mage::getBaseUrl ( Mage_Core_Model_Store::URL_TYPE_WEB ) );
		$this->saveProductLog ( $logFilename, "*****************************************************************************************************\r\n" );
		
		//Validate if file exists
		$exists = $this->remoteFileExists($filename);

		if ($exists) {
			try {
				//Read the XML file
				$orders = simplexml_load_file($filename);
				$count = 0;

				foreach ($orders as $order){
					$count = $count +1;

			        $orderId = (string)$order->order_id;
			        $incrementalId = (string)$order->incremental_id;
			        $status = (string)$order->status;
			        $customerId = (string)$order->customer_id;
			        $documentNumber = (string)$order->document_number;
			        $documentType = (string)$order->document_type;
			        $firstName = (string)$order->first_name;
			        $lastName = (string)$order->last_name;
			        $company = (string)$order->company;
			        $email = (string)$order->email;
			        $password = (string)$order->password;
			        $address1 = (string)$order->address1;
			        $address2 = (string)$order->address2;
			        $city = (string)$order->city;
			        $region = (string)$order->region;
			        $country = (string)$order->country;
			        $telephone = (string)$order->telephone;
			        $useForShipping = (string)$order->use_for_shipping;
			        $paymentMethod = (string)$order->payment_method;

			        // Log the action
					$logContent = "ID " . $orderId . " ------------------------------------------------------------------------------------------\r\n" . date ( 'm-d-Y H:i:s' ) . " - Inicia";
					$this->saveProductLog ( $logFilename, $logContent );

			        //Get the region
			        $regionId = $this->getRegionId($region);

			        if($regionId != ''){
			        	$cityId = $this->getCityId($city, $regionId);

			        	if($cityId != ''){
			        		// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asigna ciudad y region";
							$this->saveProductLog ( $logFilename, $logContent );


							//Creates a new quote
					        $quote = Mage::getModel('sales/quote')
							        ->setStoreId(Mage::app()->getStore('default')->getId());

							//Get the items
					        $item_b = $order->items;

					        foreach ($item_b as $items){
					        	foreach ($items as $item){
						        	$itemId = (string)$item->id;
						        	$quantity = (string)$item->qty;

						        	// Update the stock
									/*$product = Mage::getModel('catalog/product')->load($itemId);
									$qty = $product->getStockItem()->getQty();

									$stockData = $product->getStockData ();
									$stockData ['qty'] = (integer)$qty + (integer)$quantity;
									$stockData ['is_in_stock'] = 1;
									$stockData ['manage_stock'] = 1;
									$stockData ['use_config_manage_stock'] = 1;
									$product->setStockData ( $stockData );
									$product->save ();

									// Log the action
									$logContent = date ( 'm-d-Y H:i:s' ) . " - Se aumenta el inventario del producto";
									$this->saveProductLog ( $logFilename, $logContent );*/

									
									//Set the products
									$product = Mage::getModel('catalog/product')->load($itemId);
									$buyInfo = array('qty' => $quantity);
									$quote->addProduct($product, new Varien_Object($buyInfo));

									// Log the action
									$logContent = date ( 'm-d-Y H:i:s' ) . " - Se adiciona a la orden el item " . $itemId;
									$this->saveProductLog ( $logFilename, $logContent );
						        }
					        }

							// Set the billing address
							$billingAddress = array(
							    'firstname' => $firstName,
							    'lastname' => $lastName,
							    'company' => $company,
							    'email' =>  $email,
							    'street' => array(
							        $address1,
							        $address2),
							    'city' => $cityId,
							    'region_id' => $regionId,
							    'region' => $regionId ,
							    'country_id' => $country,
							    'telephone' =>  $telephone,
							    'save_in_address_book' => '1',
							    'use_for_shipping' => $useForShipping,
							);

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Se crea la direccion de cobro";
							$this->saveProductLog ( $logFilename, $logContent );
							 
							$quote->getBillingAddress()
							        ->addData($billingAddress);
							 
							$quote->getShippingAddress()
							        ->addData($billingAddress)
							        ->setShippingMethod('ofi_ofi')
							        ->setPaymentMethod($paymentMethod)
							        ->setCollectShippingRates(true)
							        ->collectTotals();

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Se crea la direccion de envio";
							$this->saveProductLog ( $logFilename, $logContent );



							//Assign the order to a customer
							if($customerId != ''){
								$customer = Mage::getModel('customer/customer')->load($customerId);
								$quote->assignCustomer($customer);
								// Log the action
								$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asocia la orden al cliente existente " . $customerId;
								$this->saveProductLog ( $logFilename, $logContent );
							}else{
								//Check the user by email
							    $customerEmail = $this->customerExists($email, 1);

							    if($customerEmail != false){
									$quote->assignCustomer($customerEmail);

									$customerId = $customerEmail->getId();

									// Log the action
									$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asocia la orden al cliente existente " . $customerId;
									$this->saveProductLog ( $logFilename, $logContent );
								}else{
									$customerNew = $this->customerCreate($email, $firstName, $lastName, $password, $documentType, $documentNumber, $company, 1);
									$quote->assignCustomer($customerNew);

									$customerId = $customerNew->getId();

									// Log the action
									$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asocia la orden al nuevo cliente " . $customerId;
									$this->saveProductLog ( $logFilename, $logContent );
								}
							}


							//Assign the customer to session
							Mage::getSingleton('customer/session')->loginById($customerId);

							//Assign the customer to the order
							$quote->setCustomerId($customerId)
						            ->setCustomerEmail($email)
						            ->setCustomerIsGuest(false);


						 	//Set the payment method
							$quote->getPayment()->importData( array('method' => $paymentMethod));
							$quote->save();

							//Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asigna el metodo de pago";
							$this->saveProductLog ( $logFilename, $logContent );
							 
							//Save the order
							$service = Mage::getModel('sales/service_quote', $quote);
							$service->submitAll();

							Mage::getSingleton('customer/session')->logout();


							//Set the status
							//$order = $service->getOrder();
							//$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING,true)->save();

							// Log the action
							//$logContent = date ( 'm-d-Y H:i:s' ) . " - Se asigna el estado";
							//$this->saveProductLog ( $logFilename, $logContent );
							
							/*
							//POSSIBLE STATUSES
							$order->setState(Mage_Sales_Model_Order::STATE_NEW, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_PROCESSING, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_COMPLETE, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_CLOSED, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true)->save();
							$order->setState(Mage_Sales_Model_Order::STATE_HOLDED, true)->save();
							*/

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nID " . $orderId . " ------------------------------------------------------------------------------------------\r\n";
							$this->saveProductLog ( $logFilename, $logContent );
						}else{
							$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: CIUDAD NO ENCONTRADA: " . $city );
							$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nID " . $orderId . " ------------------------------------------------------------------------------------------\r\n");
							return false;
						}
			        }else{
			        	$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: REGION NO ENCONTRADA: " . $region );
						$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nID " . $orderId . " ------------------------------------------------------------------------------------------\r\n");
						return false;
			        }			
		    	}
					
				// Save the external log file
				$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
				$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
				$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
				
				// Send email notification
				$message = 'Finalizado. Se cargo el archivo. ' . $count . ' orden(es) encontrada(s).';
				$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );
				
				//Save the log in the database
				$this->saveLogDatabase($logFilename, $message, 2);

			}catch (Exception $e) {
			    Mage::log($e,null,'orders.log');
			    return false;
			}
		} else {
			// Save the external log file
			$this->saveProductLog ( $logFilename, "ERROR: NO SE ENCONTRO EL ARCHIVO EN EL SERVIDOR\r\n" );
			$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
			$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
			$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );

			// Send email notification
			$message = 'Error: No se encontro el archivo en el servidor';
			$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );

			//Save the log in the database
			$this->saveLogDatabase($logFilename, $message, 2);

			return false;
		}
	
		return true;
	}


	/**
	 * Imports the data from the uploaded file of products
	 *
	 * @return bool
	 */
	public function startimportActionProductsBatch() {
		$title = 'Importación de Productos';
		ini_set ( 'auto_detect_line_endings', true );

		$productsFilePath = 'media/products/PRODUCTS.csv';
		$productsFileMovedPath = 'media/products/processed/';
		$productsFileLogPath = 'var/log/products/';
		$productsSeparator = ',';
		
		$filename = Mage::getBaseDir () . DS . $productsFilePath;
		$filenameProcessed = Mage::getBaseDir () . DS . $productsFileMovedPath . date ( 'mdY' ) . '.csv';
		$logFilename = Mage::getBaseDir () . DS . $productsFileLogPath . "product_log_full_" . date ( 'mdY' ) . ".txt";
		
		ini_set('memory_limit', '-1');

		// Create the category tree
		$this->getCategoryTree();
		
		// Start to log
		$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
		$this->saveProductLog ( $logFilename, "INICIANDO " . date ( 'm-d-Y H:i:s' ) );
		$this->saveProductLog ( $logFilename, "SERVIDOR " . Mage::getBaseUrl ( Mage_Core_Model_Store::URL_TYPE_WEB ) );
		$this->saveProductLog ( $logFilename, "*****************************************************************************************************\r\n" );
		
		
		if (file_exists ( $filename )) {
			try {
				if (($handle = fopen ( $filename, "r" )) !== FALSE) {
					// Set the index to manual
					$pCollection = Mage::getSingleton('index/indexer')->getProcessesCollection(); 
					foreach ($pCollection as $process) {
					  	$process->setMode(Mage_Index_Model_Process::MODE_MANUAL)->save();
					}
					
					$row = 0;
					$goodRows = 0;
					$badRows = 0;
					$headerFlag = TRUE; // just a flag that will make skip the header in the csv
					
					while ( ($data = fgetcsv ( $handle, 0, $productsSeparator )) !== FALSE ) {
						if ($headerFlag) {
							$headerFlag = FALSE;
						} else {
							if ($this->_bufferAndProcessProducts ( $logFilename, $data )) {
								$goodRows ++;
							} else {
								$badRows ++;
							}
							$row ++;
						}
					}
					
					// Save the categories per products
					$this->_processCategoriesProducts ( $logFilename );
					
					// Set the index to real time again
					$pCollection = Mage::getSingleton('index/indexer')->getProcessesCollection(); 
					foreach ($pCollection as $process) {
					  	$process->setMode(Mage_Index_Model_Process::MODE_REAL_TIME)->save();
					}
					
					// Reindex all processes
					$logContent = "------------------------------------------------------------------------------------------\r\n" . date ( 'm-d-Y H:i:s' ) . " - REINDEXANDO\r\n------------------------------------------------------------------------------------------\r\n";
					$this->saveProductLog ( $logFilename, $logContent);
					
					$indexingProcesses = Mage::getSingleton('index/indexer')->getProcessesCollection(); 
					foreach ($indexingProcesses as $process) {
					      $process->reindexEverything();
					}
					
					// Save the external log file
					$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
					$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
					$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
					
					// Send email notification
					$message = 'Finalizado. Se cargo el archivo. ' . $goodRows . ' registro(s) cargado(s). ' . $badRows . ' registro(s) no cargado(s) con errores.';
					$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );
					
					//Save the log in the database
					$this->saveLogDatabase($logFilename, $message, 1);

					// Move the file to /procesado
					rename ( $filename, $filenameProcessed );

					return true;
				} else {
					// Save the external log file
					$this->saveProductLog ( $logFilename, "ERROR: NO SE PUDO ABRIR EL ARCHIVO\r\n" );
					$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
					$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
					$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );

					// Send email notification
					$message = 'Error: No se pudo abrir el archivo.';
					$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );

					//Save the log in the database
					$this->saveLogDatabase($logFilename, $message, 1);
				}
			} catch ( Exception $e ) {
				// Save the external log file
				$this->saveProductLog ( $logFilename, "ERROR: " . $e . "\r\n" );
				$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
				$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
				$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );

				// Send email notification
				$message = $e;
				$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );

				//Save the log in the database
				$this->saveLogDatabase($logFilename, $message, 1);
			}
		} else {
			// Save the external log file
			$this->saveProductLog ( $logFilename, "ERROR: NO SE ENCONTRO EL ARCHIVO EN EL SERVIDOR\r\n" );
			$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );
			$this->saveProductLog ( $logFilename, "FINALIZANDO " . date ( 'm-d-Y H:i:s' ) );
			$this->saveProductLog ( $logFilename, "*****************************************************************************************************" );

			// Send email notification
			$message = 'Error: No se encontro el archivo en el servidor';
			$this->sendNotification ( $title, $message . "<br /><br />Para mayor informacion, consulte el log de este proceso en: " . $logFilename . ", o en la base de datos en la tabla ofi_integration_log" );

			//Save the log in the database
			$this->saveLogDatabase($logFilename, $message, 1);
		}
		
		return false;
	}
	

	/**
	 * Processes the record from the products file
	 *
	 * @return bool
	 */
	private function _bufferAndProcessProducts($logFilename, $data) {
		try {
			$name =					trim ( $data [0] );
			$netsuiteId =			trim ( $data [1] );
			$manufacturersID =		trim ( $data [2] );
			$vendorCode =			trim ( $data [3] );
			$categories =			trim ( $data [4] );
			$detailedDescription =	trim ( $data [5] );
			$shortDescription =		trim ( $data [6] );
			$pageTitle =			trim ( $data [7] );
			$metaTagHTML =			trim ( $data [8] );
			$webStoreDescription =	trim ( $data [9] );
			$quantity =				trim ( $data [10] );
			$leadTime =				trim ( $data [11] );
			$group =				trim ( $data [12] );
			$cost =					trim ( $data [13] );
			$salesPrice =			trim ( $data [14] );
			$isFeatured =			trim ( $data [15] );
			$status =				trim ( $data [16] );
			$visibility =			trim ( $data [17] );
			$taxClassId = 			trim ( $data [18] );
			$brand =				trim ( $data [19] );
			$color =				trim ( $data [20] );
			$warranty =				trim ( $data [21] );
			$weight =				trim ( $data [22] );
			$weightUnitRef =		trim ( $data [23] );
			$height =				trim ( $data [24] );
			$width =				trim ( $data [25] );
			$depth =				trim ( $data [26] );
			$box =					trim ( $data [27] );
			$weightPackage =		trim ( $data [28] );
			$weightUnitPackage =	trim ( $data [29] );
			$heightPackage =		trim ( $data [30] );
			$widthPackage =			trim ( $data [31] );
			$depthPackage =			trim ( $data [32] );
			//TECONOLOGIA -COMPUTADORES
			$screenSize =			trim ( $data [33] );
			$screenType =			trim ( $data [34] );
			$screenResolucion =		trim ( $data [35] );
			$operatingSystem =		trim ( $data [36] );
			$processor =			trim ( $data [37] );
			$velocityCPU =			trim ( $data [38] );
			$memoryRam =			trim ( $data [39] );
			$memoryRamType =		trim ( $data [40] );
			$hardDrive =			trim ( $data [41] );
			$webCamara =			trim ( $data [42] );
			$connectivity =			trim ( $data [43] );
			$ports =				trim ( $data [44] );
			$multimedia =			trim ( $data [45] );
			$dvd =					trim ( $data [46] );
			$model =				trim ( $data [47] );
			$velocityTurboCPU =		trim ( $data [48] );
			$recording =			trim ( $data [49] );
			$graphicCard =			trim ( $data [50] );
			$graphicCardRam =		trim ( $data [51] );
			$microphone =			trim ( $data [52] );
			$keyboardLight =		trim ( $data [53] );
			$speakers =				trim ( $data [54] );
			$compatibility =		trim ( $data [55] );
			//PAPELERIA
			$bodyColor =			trim ( $data [56] );
			$bodyShape =			trim ( $data [57] );
			$thickTip =				trim ( $data [58] );
			$material =				trim ( $data [59] );
			$draft =				trim ( $data [60] );
			$lineWidth =			trim ( $data [61] );
			$graduation =			trim ( $data [62] );
			$operation =			trim ( $data [63] );
			$sew =					trim ( $data [64] );
			$tipType =				trim ( $data [65] );
			$retractable =			trim ( $data [66] );
			$ink =					trim ( $data [67] );
			$scope =				trim ( $data [68] );
			$surface =				trim ( $data [69] );
			$unitVolume =			trim ( $data [70] );
			$size =					trim ( $data [71] );
			$utility =				trim ( $data [72] );
			$leavesNumber =			trim ( $data [73] );
			$leavesDesign =			trim ( $data [74] );
			$bookType =				trim ( $data [75] );
			$quantityIndexDividers=	trim ( $data [76] );
			$rings =				trim ( $data [77] );
			//ASEO
			$gauge =				trim ( $data [78] );
			$capacity =				trim ( $data [79] );
			$fragancy =				trim ( $data [80] );
			$extracts =				trim ( $data [81] );
			//CAFETERIA
			$flavor =				trim ( $data [82] );

			//ADICIONALES
			$featuredHome = 		trim ( $data [83] );
			$units =				trim ( $data [84] );
			$level =				trim ( $data [85] );


			$sku = $manufacturersID;

			// Log the action
			$logContent = "SKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" . date ( 'm-d-Y H:i:s' ) . " - Inicia";
			$this->saveProductLog ( $logFilename, $logContent );
			
			if ($sku != '') {
				//if($salesPrice > 10){
					$categories = str_replace(' > ', '/', $categories);
					$categoryId = $this->validateCategory ( $categories );

					// Log the action
					$logContent = date ( 'm-d-Y H:i:s' ) . " - Obtiene la categoria para ". $categories . ": " . $categoryId;
					$this->saveProductLog ( $logFilename, $logContent );
					
					if ($categoryId != null) {
						// Get the set
						$set = $this->getAttributeSet ( $categories );

						// Get the parent category
						$parentCategory = $this->getParentCategory ( $categories );

						// Log the action
						$logContent = date ( 'm-d-Y H:i:s' ) . " - Obtiene el set del producto: ". $set;
						$this->saveProductLog ( $logFilename, $logContent );

						if ($set != null) {
							// Get the attributes values
							$color_value = null;
							$manufacturer_value = null;
							//Tecnologia
							$screenSize_value = null;
							$screenType_value = null;
							$screenResolucion_value = null;
							$operatingSystem_value = null;
							$processor_value = null;
							$velocityCPU_value = null;
							$memoryRam_value = null;
							$memoryRamType_value = null;
							$hardDrive_value = null;
							//Papeleria
							$bodyColor_value = null;
							$bodyShape_value = null;
							$thickTip_value = null;
							$material_value = null;
							$draft_value = null;
							$lineWidth_value = null;
							$graduation_value = null;
							$operation_value = null;
							$sew_value = null;
							$tipType_value = null;
							$retractable_value = null;
							$ink_value = null;
							$scope_value = null;
							$surface_value = null;
							$unitVolume_value = null;
							$leavesNumber_value = null;
							$leavesDesign_value = null;
							$bookType_value = null;
							//seo
							$gauge_value = null;
							$capacity_value = null;
							$fragancy_value = null;
							//Cafeteria
							$flavor_value = null;

							if ($brand != '')
								$manufacturer_value = $this->addAttributeValue ( "manufacturer", $brand );

							if ($color != '')
								$color_value = $this->addAttributeValue ( "color", $color );
							

							//Tecnologia
							if($set == 9){
								if ($screenSize != '')
									$screenSize_value = $this->addAttributeValue ( "screen_size", $screenSize );
								
								if ($screenType != '')
									$screenType_value = $this->addAttributeValue ( "screen_type", $screenType );

								if ($screenResolucion != '')
									$screenResolucion_value = $this->addAttributeValue ( "screen_resolucion", $screenResolucion );

								if ($operatingSystem != '')
									$operatingSystem_value = $this->addAttributeValue ( "operating_system", $operatingSystem );

								if ($processor != '')
									$processor_value = $this->addAttributeValue ( "processor", $processor );

								if ($velocityCPU != '')
									$velocityCPU_value = $this->addAttributeValue ( "velocity_cpu", $velocityCPU );

								if ($memoryRam != '')
									$memoryRam_value = $this->addAttributeValue ( "memory_ram", $memoryRam );

								if ($memoryRamType != '')
									$memoryRamType_value = $this->addAttributeValue ( "memory_ram_type", $memoryRamType );

								if ($hardDrive != '')
									$hardDrive_value = $this->addAttributeValue ( "hard_drive", $hardDrive );
							}

							//Papeleria
							if($set == 10){
								if ($bodyColor != '')
									$bodyColor_value = $this->addAttributeValue ( "body_color", $bodyColor );

								if ($bodyShape != '')
									$bodyShape_value = $this->addAttributeValue ( "body_shape", $bodyShape );

								if ($thickTip != '')
									$thickTip_value = $this->addAttributeValue ( "thick_tip", $thickTip );

								if ($material != '')
									$material_value = $this->addAttributeValue ( "material", $material );

								if ($draft != '')
									$draft = $this->addAttributeValue ( "draft", $draft );

								if ($lineWidth != '')
									$lineWidth_value = $this->addAttributeValue ( "line_width", $lineWidth );

								if ($graduation != '')
									$graduation_value = $this->addAttributeValue ( "graduation", $graduation );

								if ($operation != '')
									$operation_value = $this->addAttributeValue ( "operation", $operation );

								if ($sew != '')
									$sew_value = $this->addAttributeValue ( "sew", $sew );

								if ($tipType != '')
									$tipType_value = $this->addAttributeValue ( "tip_type", $tipType );

								if ($retractable != '')
									$retractable_value = $this->addAttributeValue ( "retractable", $retractable );

								if ($ink != '')
									$ink_value = $this->addAttributeValue ( "ink", $ink );

								if ($scope != '')
									$scope_value = $this->addAttributeValue ( "scope", $scope );

								if ($surface != '')
									$surface_value = $this->addAttributeValue ( "surface", $surface );

								if ($unitVolume != '')
									$unitVolume_value = $this->addAttributeValue ( "unit_volume", $unitVolume );

								if ($leavesNumber != '')
									$leavesNumber_value = $this->addAttributeValue ( "leaves_number", $leavesNumber );

								if ($leavesDesign != '')
									$leavesDesign_value = $this->addAttributeValue ( "leaves_design", $leavesDesign );

								if ($bookType != '')
									$bookType_value = $this->addAttributeValue ( "book_type", $bookType );
							}

							//Aseo
							if($set == 11){
								if ($gauge != '')
									$gauge_value = $this->addAttributeValue ( "gauge", $gauge );

								if ($capacity != '')
									$capacity_value = $this->addAttributeValue ( "capacity", $capacity );

								if ($fragancy != '')
									$fragancy_value = $this->addAttributeValue ( "fragancy", $fragancy );
							}

							//Cafeteria
							if($set == 12){
								if ($flavor != '')
									$flavor_value = $this->addAttributeValue ( "flavor", $flavor );
							}

								
							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Obtiene atributos adicionales";
							$this->saveProductLog ( $logFilename, $logContent );

							// Validate some fields
							if($visibility == 'Yes' || $visibility == 'Sí')
								$visibility_value = 4;
							else
								$visibility_value = 1;

							if($featuredHome == 'Yes' || $featuredHome == 'Sí')
								$isFeatured_value = 1;
							else
								$isFeatured_value = 0;

							if($status == 'No')
								$status_value = 1;
							else
								$status_value = 2;
							
							
							switch ($taxClassId) {
							    case 'IVA_0':
							        $taxClassId_value = 0;
							        break;
							    case 'IVA_5':
							        $taxClassId_value = 4;
							        break;
							    case 'IVA_16':
							        $taxClassId_value = 2;
							        break;
							}

							// Set burned values for quantity
							switch ($set) {
							    case 9:
							        $quantity_value = 20;
							        break;
							    case 10:
							        $quantity_value = 1000;
							        break;
							    case 11:
							    	$quantity_value = 20;
							        break;
							    case 12:
							    	$quantity_value = 20;
							        break;
							    default:
							        $quantity_value = 10;
							        break;
							}

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Define los valores personalizados ";
							$this->saveProductLog ( $logFilename, $logContent );
							

							// Create the product to load
							$product = Mage::getModel ( 'catalog/product' );
							
							$product->setSku ( $sku );
							$product->setName ( $name );
							$product->setNetsuiteId ( $netsuiteId );
							$product->setDescription ( $detailedDescription );
							$product->setShortDescription ( $detailedDescription );

							//Modified by Luz request
							$pageTitle = $name . " en venta en OFI.com.co";
							$metaTagHTML = $name;
							$webStoreDescription = $name . " y otros productos de " . $parentCategory . " en venta en OFI.com.co. " . $name . " con especificaciones garantía y envío a todo Colombia";

							$product->setMetaTitle ( $pageTitle );
							$product->setMetaKeyword ( $metaTagHTML );
							$product->setMetaDescription ( $webStoreDescription );

							$product->setCost ( $cost );

							//Special price validation
							if($level == "Online Price"){
								$product->setPrice ( $salesPrice );
							}else{
								if($salesPrice == 0)
									$salesPrice = '';
								
								$product->setSpecialPrice ( $salesPrice );
							}

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Tipo de precio: ". $level;
							$this->saveProductLog ( $logFilename, $logContent );


							$product->setTaxClassId ( $taxClassId_value );
							$product->setLeadTime ( $leadTime );

							$product->setManufacturer ( $manufacturer_value );
							$product->setColor ( $color_value );
							$product->setWarranty ( $warranty );
							$product->setWeight ( $weight );
							$product->setWeightUnitRef ( $weightUnitRef );
							$product->setHeight ( $height );
							$product->setWidth ( $width );
							$product->setDepth ( $depth );
							$product->setBox ( $box );
							$product->setWeightPackage ( $weightPackage );
							$product->setWeightUnitPackage ( $weightUnitPackage );
							$product->setHeightPackage ( $heightPackage );
							$product->setWidthPackage ( $widthPackage );
							$product->setDepthPackage ( $depthPackage );

							//Tecnologia
							if($set == 9){
								$product->setScreenSize ( $screenSize_value );
								$product->setScreenType ( $screenType_value );
								$product->setScreenResolucion ( $screenResolucion_value );
								$product->setOperatingSystem ( $operatingSystem_value );
								$product->setProcessor ( $processor_value );
								$product->setVelocityCpu ( $velocityCPU_value );
								$product->setMemoryRam ( $memoryRam_value );
								$product->setMemoryRamType ( $memoryRamType_value );
								$product->setHardDrive ( $hardDrive_value );
								$product->setWebCamara ( $webCamara );
								$product->setConnectivity ( $connectivity );
								$product->setPorts ( $ports );
								$product->setMultimedia ( $multimedia );
								$product->setDvd ( $dvd );
								$product->setModel ( $model );
								$product->setVelocityTurboCpu ( $velocityTurboCPU );
								$product->setRecording ( $recording );
								$product->setGraphicCard ( $graphicCard );
								$product->setGraphicCardRam ( $graphicCardRam );
								$product->setMicrophone ( $microphone );
								$product->setKeyboardLight ( $keyboardLight );
								$product->setSpeakers ( $speakers );
								$product->setCompatibility ( $compatibility );
							}
							
							//Papeleria
							if($set == 10){
								$product->setBodyColor ( $bodyColor_value );
								$product->setBodyShape ( $bodyShape_value );
								$product->setThickTip ( $thickTip_value );
								$product->setMaterial ( $material_value );
								$product->setDraft ( $draft_value );
								$product->setLineWidth ( $lineWidth_value );
								$product->setGraduation ( $graduation_value );
								$product->setOperation ( $operation_value );
								$product->setSew ( $sew_value );
								$product->setTipType ( $tipType_value );
								$product->setRetractable ( $retractable_value );
								$product->setInk ( $ink_value );
								$product->setScope_ ( $scope_value );
								$product->setSurface ( $surface_value );
								$product->setUnitVolume ( $unitVolume_value );
								$product->setSize ( $size );
								$product->setUtility ( $utility );
								$product->setLeavesNumber ( $leavesNumber_value );
								$product->setLeavesDesign ( $leavesDesign_value );
								$product->setBookType ( $bookType_value );
								$product->setQuantityIndexDividers ( $quantityIndexDividers );
								$product->setRings ( $rings );
							}

							//Aseo
							if($set == 11){
								$product->setGauge ( $gauge_value );
								$product->setCapacity ( $capacity_value );
								$product->setFragancy ( $fragancy_value );
								$product->setExtracts ($extracts );
							}
							
							//Cafeteria
							if($set == 12){
								$product->setFlavor ( $flavor_value );
							}


							//Other attributes
							$product->setUnits ( $units );
							
							$product->setWebsiteIds ( array(1) );
							$product->setStatus ( $status_value );
							$product->setVisibility ( $visibility_value );
							//$product->setPromotion ( $isFeatured_value );
							$product->setAttributeSetId ( $set );
							$product->setType ( 'Simple Product' );
							$product->setTypeId ( 'simple' );
							$product->setCategoryIds( array($categoryId) );
							$product->save ();

							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Carga el producto";
							$this->saveProductLog ( $logFilename, $logContent );



							// Save the category and the sku in a public variable
							$categoryProducts = $this->_categoryProducts;
							
							// Validates if the array already exists
							if (array_key_exists ( $sku, $categoryProducts )) {
								array_push ( $categoryProducts [$sku] ["items"], 
									array (
										"sku" => $sku,
										"categoryId" => $categoryId 
									) 
								);
							} else {
								$newarray = array (
										"items" => array (
												array (
														"sku" => $sku,
														"categoryId" => $categoryId
												) 
										) 
								);
								$categoryProducts [$sku] = $newarray;
							}
							
							// Assign the category to the public variable
							$this->_categoryProducts = $categoryProducts;

							
							// Update the stock
							$product->load ( $product->getIdBySku ( $sku ) );
							$stockData = $product->getStockData ();
							$stockData ['qty'] = $quantity_value;
							$stockData ['is_in_stock'] = 1;
							$stockData ['manage_stock'] = 1;
							$stockData ['use_config_manage_stock'] = 1;
							$product->setStockData ( $stockData );
							$product->save ();
							
							// Log the action
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Actualiza el inventario";
							$this->saveProductLog ( $logFilename, $logContent );


							// Save the log
							$logContent = date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n";
							$this->saveProductLog ( $logFilename, $logContent );
							return true;

						}else {
							$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: NO SE ENCONTRO EL SET PARA: " . $categories );
							$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
							return false;
						}
					} else {
						$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: NO SE ENCONTRO LA CATEGORIA: " . $categories );
						$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
						return false;
					}
				//}else{
				//	$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: EL PRECIO NO ES VALIDO: " . $salesPrice );
				//	$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
				//	return false;
				//}
			} else {
				$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: EL SKU ES INVALIDO" );
				$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
				return false;
			}
		} catch ( Exception $e ) {			
			$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: " . $e );
			$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
			return false;
		}
	}
	


	/**
	 * Processes the categories per products from the public array
	 *
	 * @return bool
	 */
	private function _processCategoriesProducts($logFilename) {
		// Get the public array
		$categoryProducts = $this->_categoryProducts;
		$logContent = "";
		$cleanImport=TRUE;

		// Log the action
		$logContent = "\r\nCATEGORIES";
		$this->saveProductLog ( $logFilename, $logContent );
		
		foreach ( $categoryProducts as $simpleArray ) {
			try {
				$items = $simpleArray ['items'];
				$numberItems = count ( $items );
				$skuUni = "";
				$categoriesIds = "";
				
				if ($numberItems > 1) {
					for($i = 0; $i < $numberItems; ++ $i) {
						$sku = $items [$i] ["sku"];
						$categoryId = $items [$i] ["categoryId"];
						$skuUni = $sku;
						$categoriesIds = $categoryId.",".$categoriesIds;
					}

					$categoriesIds = substr($categoriesIds, 0, -1);

					// Log the action
					$logContent = "SKU " . $sku . " -----------------------------------------------------------------------------------------\r\n" . date ( 'm-d-Y H:i:s' ) . " - Inicia";
					$this->saveProductLog ( $logFilename, $logContent );
					
					// Set the product attributes
					$product = Mage::getModel ( 'catalog/product' );
						
					$product->setSku ( $sku );
					$product->setCategoryIds( $categoriesIds );
					$product->save ();

					// Log the action
					$logContent = date ( 'm-d-Y H:i:s' ) . " - Actualiza las categorias: ". $categoriesIds;
					$this->saveProductLog ( $logFilename, $logContent );
		
					// Log the action
					$logContent = date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " -----------------------------------------------------------------------------------------\r\n";
					$this->saveProductLog ( $logFilename, $logContent );
				}
			} catch ( Exception $e ) {
				$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - ERROR: " . $e );
				$this->saveProductLog ( $logFilename, date ( 'm-d-Y H:i:s' ) . " - Finaliza\r\nSKU " . $sku . " ------------------------------------------------------------------------------------------\r\n" );
				
				$cleanImport = FALSE;
				continue;
			}
		}
		
		return $cleanImport;
	}

	
	
	
	/**
	 * Adds an attribute value for a specific product
	 *
	 * @return the value for the created attribute
	 */
	public function addAttributeValue($arg_attribute, $arg_value) {
		$attribute_model = Mage::getModel ( 'eav/entity_attribute' );
		$attribute_code = $attribute_model->getIdByCode ( 'catalog_product', $arg_attribute );
		$attribute = $attribute_model->load ( $attribute_code );
		
		if (! $this->attributeValueExists ( $arg_attribute, $arg_value )) {
			$value ['option'] = array (
					$arg_value,
					$arg_value 
			);
			$result = array (
					'value' => $value 
			);
			$attribute->setData ( 'option', $result );
			$attribute->save ();
		}
		
		$attribute_options_model = Mage::getModel ( 'eav/entity_attribute_source_table' );
		$attribute_table = $attribute_options_model->setAttribute ( $attribute );
		$options = $attribute_options_model->getAllOptions ( false );
		
		foreach ( $options as $option ) {
			if ($option ['label'] == $arg_value) {
				return $option ['value'];
			}
		}
		
		return false;
	}

	/**
	 * Gets the category tree and leave a public array with the data
	 *
	 * 
	 */
	public function getCategoryTree(){
		$category = Mage::getModel('catalog/category');
		$tree = $category->getTreeModel();
		$tree->load();
		 
		$ids = $tree->getCollection()->getAllIds();
		$categories = array();
		$categoryTree = array();

		if ($ids){
		    foreach ($ids as $id){
		        $category->load($id);
		        $categories[$id]['name'] = $category->getName();
		        $categories[$id]['path'] = $category->getPath();
		    }

		    foreach ($ids as $id){
		        $path = explode('/', $categories[$id]['path']);
		        $string = '';

		        foreach ($path as $pathId){
		            $string.= $categories[$pathId]['name'] . '/';
		            $cnt++;
		        }

		        $categoryTree[$id]['id'] = $id;
		        $categoryTree[$id]['name'] = str_replace('Root Catalog/','',substr($string, 0, -1));
		        $categoryTree[$id]['path'] = $categories[$id]['path'];

		        $string.= $id;
		    }
		}

		$this->_categoryTree = $categoryTree;
		//Mage::log($categoryTree,null,'categories.log');
	}

	/**
	 * Validates/creates a category
	 *
	 * @return the value
	 */
	public function validateCategory($categories){
		foreach ($this->_categoryTree as $cat){
			if($cat['name'] == $categories)
				return $cat['id'];
		}

		// If the category is not found, returns NULL
		return null;
	}


	/**
	 * Get the attribute set for the product
	 *
	 * @return the value
	 */
	public function getAttributeSet($category){
		if (0 === strpos($category, 'Home/Tecnología', 0)) {
   			return 9;
   		}

   		if (0 === strpos($category, 'Home/Papelería', 0)) {
			return 10;
		}

		if (0 === strpos($category, 'Home/Aseo', 0)) {
			return 11;
		}

		if (0 === strpos($category, 'Home/Cafetería', 0)) {
			return 12;
		}

		return 4;
	}


	/**
	 * Get the parent category for the product
	 *
	 * @return the value
	 */
	public function getParentCategory($category){
		if (0 === strpos($category, 'Home/Tecnología', 0)) {
   			return "Tecnología";
   		}

   		if (0 === strpos($category, 'Home/Papelería', 0)) {
			return "Papelería";
		}

		if (0 === strpos($category, 'Home/Aseo', 0)) {
			return "Aseo";
		}

		if (0 === strpos($category, 'Home/Cafetería', 0)) {
			return "Cafetería";
		}

		return "Home";
	}
	
	/**
	 * Validates if a value exists for a specific attribute
	 *
	 * @return the value
	 */
	public function attributeValueExists($arg_attribute, $arg_value) {
		$attribute_model = Mage::getModel ( 'eav/entity_attribute' );
		$attribute_options_model = Mage::getModel ( 'eav/entity_attribute_source_table' );
		
		$attribute_code = $attribute_model->getIdByCode ( 'catalog_product', $arg_attribute );
		$attribute = $attribute_model->load ( $attribute_code );
		
		$attribute_table = $attribute_options_model->setAttribute ( $attribute );
		$options = $attribute_options_model->getAllOptions ( false );
		
		foreach ( $options as $option ) {
			if ($option ['label'] == $arg_value) {
				return $option ['value'];
			}
		}
		
		return false;
	}
	
	/**
	 * Saves the full product log
	 */
	public function saveProductLog($logFilename, $log) {
		$fileHandle = fopen ( $logFilename, "a" );
		fwrite ( $fileHandle, $log . "\r\n" );
		fclose ( $fileHandle );
	}

	/**
	 * Gets the log file content
	 */
	public function getLogContent($logFilename){
		$logContent = file_get_contents($logFilename, true);
		return $logContent;
	}

	/**
	 * Save the log into the database
	 */
	public function saveLogDatabase($logFilename, $message, $type){
		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$content = $this->getLogContent($logFilename);
		$currentTime = now();

		$query = "INSERT INTO `ofi_integration_log` (`type`, `creation_date`, `summary`, `log`) 
					VALUES (" . $type . ",'" . $currentTime. "','" . $message . "','" . $content . "');";
		$DB->exec($query);

		return true;
	}

	/**
	 * Sends an email notification for the process
	 *
	 * @return bool
	 */
	public function sendNotification($title, $message) {
		$storeId = Mage::app ()->getStore ()->getId ();
		$templateId = '1';
		$mailSubject = $title;
		$fromName = $this->_fromName;
		$fromEmail = $this->_fromEmail;
		$toName = $this->_toName;
		$toEmail = $this->_toEmail;
		$sender = array (
				'name' => $fromName,
				'email' => $fromEmail 
		);
		
		$vars = Array (
				'title' => $title,
				'message' => $message 
		);
		
		$mailTemplate = Mage::getModel ( 'core/email_template' );
		$mailTemplate->setTemplateSubject ( $mailSubject )->sendTransactional ( $templateId, $sender, $toEmail, $toName, $vars, $storeId );
		
		return true;
	}

	/**
	 * Checks if a remote file exists
	 *
	 * @return bool
	 */
	function remoteFileExists($url) {
	    $curl = curl_init($url);

	    //don't fetch the actual page, you only want to check the connection is ok
	    curl_setopt($curl, CURLOPT_NOBODY, true);

	    //do request
	    $result = curl_exec($curl);
	    $ret = false;

	    //if request did not fail
	    if ($result !== false) {
	        //if request was ok, check response code
	        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

	        if ($statusCode == 200) {
	            $ret = true;   
	        }
	    }

	    curl_close($curl);
	    return $ret;
	}


	/**
	* Gets the region id based on the name
	*/
   	function getRegionId($regionName){
   		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$query = "SELECT `region_id` 
		         FROM `directory_country_region`
		         WHERE `country_id` = 'CO' 
		         AND `default_name` = '" . $regionName . "'";

		foreach ($DB->fetchAll($query) as $rs) {
			$regionId = $rs['region_id'];
		}

		return $regionId;
   	}

	/**
	* Gets the city id based on the name and region id
	*/
   	function getCityId($cityName, $regionId){
   		$DB = Mage::getSingleton('core/resource') -> getConnection('core_write');
		$query = "SELECT `city_id`
		        FROM `ofi_directory_city`
		        WHERE `default_name` = '" . $cityName . "'
		        AND `region_id` = " . $regionId;

		foreach ($DB->fetchAll($query) as $rs) {
			$cityId = $rs['city_id'];
		}

		return $cityId;
   	}

   	/**
	* Validates if the customer exists based on the email
	*/
   	function customerExists($email, $websiteId = null)
	{
	    $customer = Mage::getModel('customer/customer');
	    if ($websiteId) {
	        $customer->setWebsiteId($websiteId);
	    }

	    $customer->loadByEmail($email);
	    if ($customer->getId()) {
	        return $customer;
	    }
	    return false;
	}

	/**
	* Creates a customer
	*/
	function customerCreate($email, $firstName, $lastName, $password, $documentType, $nit, $company, $websiteId){
		$customer = Mage::getModel('customer/customer');
		$customer->setWebsiteId($websiteId);
		
	    $customer->setEmail($email);
	    $customer->setFirstname($firstName);
	    $customer->setLastname($lastName);
	    $customer->setPassword($password);
	    $customer->setDocumentType($documentType);
	    $customer->setNit($nit);
	    $customer->setCompanyName($company);
	
	    $customer->save();
	    return $customer;
	}
}
