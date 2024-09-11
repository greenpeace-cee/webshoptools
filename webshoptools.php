<?php

require_once 'webshoptools.civix.php';

use Civi\Webshoptools\HandleWebShopActivity;
use CRM_Webshoptools_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/ 
 */
function webshoptools_civicrm_config(&$config) {
  _webshoptools_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function webshoptools_civicrm_install() {
  _webshoptools_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function webshoptools_civicrm_enable() {
  _webshoptools_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_pre()
 *
 * @param $op
 * @param $objectName
 * @param $id
 * @param $params
 */
function webshoptools_civicrm_pre($op, $objectName, $id, &$params) {
  HandleWebShopActivity::run($op, $objectName, $id,$params);
}
