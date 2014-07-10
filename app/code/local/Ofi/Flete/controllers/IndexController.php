<?php
class Ofi_Flete_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/frete?id=15 
    	 *  or
    	 * http://site.com/frete/id/15 	
    	 */
    	/* 
		$frete_id = $this->getRequest()->getParam('id');

  		if($frete_id != null && $frete_id != '')	{
			$frete = Mage::getModel('frete/frete')->load($frete_id)->getData();
		} else {
			$frete = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($frete == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$freteTable = $resource->getTableName('frete');
			
			$select = $read->select()
			   ->from($freteTable,array('frete_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$frete = $read->fetchRow($select);
		}
		Mage::register('frete', $frete);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}