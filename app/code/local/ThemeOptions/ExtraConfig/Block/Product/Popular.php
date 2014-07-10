<?php
class ThemeOptions_ExtraConfig_Block_Product_Popular extends Mage_Catalog_Block_Product_Abstract
{
   protected function _beforeToHtml() {
    
    $productCount = 20;
    
    $storeId        = Mage::app()->getStore()->getId();
    $_productCollection = Mage::getResourceModel('reports/product_collection')
                              
                              ->addOrderedQty()
                              ->addAttributeToSelect('*')
                              ->addViewsCount()
                              ->setStoreId($storeId)
                              ->addStoreFilter($storeId)
                              ->setOrder('views_count', 'desc')
                              ->setPageSize($productCount);
        #echo $_productCollection->getSelect()->__toString();                            
        
        if ($_productCollection->isEnabledFlat())
        {
            $_productCollection->getSelect()
                        ->joinLeft(
                            array('cpl' => $_productCollection->getResource()->getFlatTableName()),
                                "e.entity_id = cpl.entity_id"
                        )
                        ->where("cpl.visibility IN (?)", 
                            array(
                                Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG, 
                                Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH
                            )
                        );      
        }
        else
        {
          $visibility     = array(
                          Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                          Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
                      );
            $_productCollection->addAttributeToFilter('visibility', $visibility);
        }
     
    
 
    $this->setProductCollection($_productCollection);
    return parent::_beforeToHtml();
}
}