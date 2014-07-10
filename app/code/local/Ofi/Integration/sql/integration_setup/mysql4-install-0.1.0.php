<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('ofi_integration_json')};
CREATE TABLE IF NOT EXISTS {$this->getTable('ofi_integration_json')} (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `json` text NOT NULL,
  `sent` tinyint(4) NOT NULL,
  `sent_date` datetime DEFAULT NULL,
  `response` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
    ");

$installer->endSetup(); 
