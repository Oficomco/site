<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('ofi_directory_city')};
CREATE TABLE IF NOT EXISTS {$this->getTable('ofi_directory_city')} (
   `city_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `region_id` MEDIUMINT(8) UNSIGNED NOT NULL ,
  `code` VARCHAR(45) NOT NULL ,
  `default_name` VARCHAR(45) NOT NULL ,
  `cash_delivery` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`city_id`) ,
  INDEX `FK_ESTRATEGIC_REGION_HAS_COUNTRY` (`region_id` ASC) ,
  CONSTRAINT `FK_ESTRATEGIC_REGION_HAS_COUNTRY`
    FOREIGN KEY (`region_id` )
    REFERENCES `directory_country_region` (`region_id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE = InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->endSetup(); 
