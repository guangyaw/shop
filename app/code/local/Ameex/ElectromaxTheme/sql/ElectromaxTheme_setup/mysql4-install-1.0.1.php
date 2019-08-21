<?php
 
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
 
$installer->startSetup();
$installer->addAttribute('catalog_product', 'today_special', array(
    'label'                    => "Today's Special",
    'group'                    => 'General',
    'type'					   => 'int',
    'input'                    => 'boolean',
    'required'                 => false,
    'global'                   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	'default'				   => '0',
));
 
$installer->endSetup();
