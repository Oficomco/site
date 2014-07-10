<?php
/**
 * Zeon Solutions,Inc.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Zeon Solutions License
 * that is bundled with this package in the file LICENSE_ZE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.zeonsolutions.com/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web,please send an email
 * to license@zeonsolutions.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * versions in the future. If you wish to customize this extension for your
 * needs please refer to http://www.zeonsolutions.com for more information.
 *
 * @category    Zeon
 * @package     Zeon_Manufacturer
 * @copyright   Copyright (c) 2012 Zeon Solutions,Inc. All Rights Reserved.(http://www.zeonsolutions.com)
 * @license     http://www.zeonsolutions.com/license/
 */

/* @var $installer Zeon_Manufacturer_Model_Mysql4_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("

/* Table structure for table `zeon_manufacturer` */

DROP TABLE IF EXISTS {$this->getTable('zeon_manufacturer/manufacturer')};
CREATE TABLE {$this->getTable('zeon_manufacturer/manufacturer')} (
    `manufacturer_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Manufacturer Id',
    `manufacturer` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Manufacturer Option Id',
    `status` smallint(6) NOT NULL COMMENT 'Status',
    `is_display_home` smallint(6) NOT NULL COMMENT 'Is Display Home',
    `identifier` varchar(255) DEFAULT NULL COMMENT 'Identifier',
    `manufacturer_logo` varchar(255) DEFAULT NULL COMMENT 'Manufacturer Logo',
    `manufacturer_banner` varchar(255) DEFAULT NULL COMMENT 'Manufacturer Banner',
    `description` text NOT NULL COMMENT 'Description',
    `sort_order` smallint(6) DEFAULT NULL COMMENT 'Sort Order',
    `meta_keywords` text COMMENT 'Meta Keywords',
    `meta_description` text COMMENT 'Meta Description',
    `creation_time` datetime DEFAULT NULL COMMENT 'Creation Time',
    `update_time` datetime DEFAULT NULL COMMENT 'Update Time',
    PRIMARY KEY (`manufacturer_id`),
    KEY `IDX_ZEON_MANUFACTURER_OPTION_ID` (`manufacturer`),
    CONSTRAINT `FK_ZEON_MANUFACTURER_OPT_ID_EAV_ATTR_OPT_OPT_ID` FOREIGN KEY (`manufacturer`) REFERENCES {$this->getTable('eav_attribute_option')} (`option_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Zeon Manufacturer';

/*Table structure for table `zeon_manufacturer_store` */

DROP TABLE IF EXISTS {$this->getTable('zeon_manufacturer/store')};
CREATE TABLE {$this->getTable('zeon_manufacturer/store')} (
    `manufacturer_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Manufacturer Id',
    `store_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Store Id',
    PRIMARY KEY (`manufacturer_id`,`store_id`),
    KEY `IDX_ZEON_MANUFACTURER_STORE_MANUFACTURER_ID` (`manufacturer_id`),
    KEY `IDX_ZEON_MANUFACTURER_STORE_STORE_ID` (`store_id`),
    CONSTRAINT `FK_ZEON_MANUFR_STORE_MANUFR_ID_ZEON_MANUFR_MANUFR_ID` FOREIGN KEY (`manufacturer_id`) REFERENCES {$this->getTable('zeon_manufacturer/manufacturer')} (`manufacturer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `FK_ZEON_MANUFR_STORE_STORE_ID_CORE_STORE_STORE_ID` FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core_store')} (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Zeon Manufacturer Store';

");

$installer->endSetup();
