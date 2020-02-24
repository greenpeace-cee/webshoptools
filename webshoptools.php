<?php

require_once 'webshoptools.civix.php';
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
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function webshoptools_civicrm_xmlMenu(&$files) {
  _webshoptools_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function webshoptools_civicrm_postInstall() {
  _webshoptools_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function webshoptools_civicrm_uninstall() {
  _webshoptools_civix_civicrm_uninstall();
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
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function webshoptools_civicrm_disable() {
  _webshoptools_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function webshoptools_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _webshoptools_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function webshoptools_civicrm_managed(&$entities) {
  _webshoptools_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function webshoptools_civicrm_caseTypes(&$caseTypes) {
  _webshoptools_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function webshoptools_civicrm_angularModules(&$angularModules) {
  _webshoptools_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function webshoptools_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _webshoptools_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function webshoptools_civicrm_entityTypes(&$entityTypes) {
  _webshoptools_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function webshoptools_civicrm_themes(&$themes) {
  _webshoptools_civix_civicrm_themes($themes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function webshoptools_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function webshoptools_civicrm_navigationMenu(&$menu) {
  _webshoptools_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _webshoptools_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_pre()
 *
 * @param $op
 * @param $objectName
 * @param $id
 * @param $params
 *
 * @throws \CiviCRM_API3_Exception
 */
function webshoptools_civicrm_pre($op, $objectName, $id, &$params) {
  if ($objectName == 'Activity' && ($op == 'create' || $op == 'edit')) {
    $webshopOrderId = (int) civicrm_api3('OptionValue', 'getvalue', [
      'sequential' => 1,
      'return' => 'value',
      'option_group_id' => 'activity_type',
      'name' => 'Webshop Order',
    ]);

    if ($webshopOrderId == $params['activity_type_id']) {
      $customFields = civicrm_api3('CustomField', 'get', [
        'sequential' => 1,
        'custom_group_id' => 'webshop_information',
        'name' => ['IN' => ['order_type', 'shirt_type', 'shirt_size', 'order_count']],
      ]);

      $webshopInfo = [];

      foreach ($customFields['values'] as $value) {
        $customValue = reset($params['custom'][$value['id']])['value'];

        if (!empty($value['option_group_id']) && !empty($customValue)) {
          $webshopInfo[$value['name']] = civicrm_api3('OptionValue', 'getvalue', [
            'return' => 'label',
            'option_group_id' => $value['option_group_id'],
            'value' => $customValue,
          ]);
        } else {
          $webshopInfo[$value['name']] = $customValue;
        }
      }

      $orderType = $shirtType = $shirtSize = $orderCount = '';

      if (!empty($webshopInfo['order_type'])) {
        $orderType = $webshopInfo['order_type'] . ' ';
      }

      if (!empty($webshopInfo['shirt_type']) && !empty($webshopInfo['shirt_size'])) {
        $shirtType = $webshopInfo['shirt_type'] . '/';
      } elseif (!empty($webshopInfo['shirt_type'])) {
        $shirtType = $webshopInfo['shirt_type'] . ' ';
      }

      if (!empty($webshopInfo['shirt_size'])) {
        $shirtSize = $webshopInfo['shirt_size'] . ' ';
      }

      if (!empty($webshopInfo['order_count'])) {
        $orderCount = $webshopInfo['order_count'] . 'x';
      }

      $params['subject'] = trim($orderType . $shirtType . $shirtSize . $orderCount);
    }
  }
}
