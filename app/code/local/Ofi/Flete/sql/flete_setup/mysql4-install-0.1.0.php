<?php

$installer = $this;

$installer->startSetup();

$installer->run("


CREATE TABLE IF NOT EXISTS `ofi_flete` (
  `flete_id` int(10) unsigned NOT NULL AUTO_INCREMENT,   
  `canal` varchar(45) NOT NULL,
  `city_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,  
  `monto` decimal(12,0) NOT NULL,
  `flete` decimal(12,0) NOT NULL,
  `adicional` decimal(12,0) NOT NULL,
  `tiempo` int(10) NOT NULL,
  PRIMARY KEY (`flete_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


    ");

$installer->endSetup(); 
