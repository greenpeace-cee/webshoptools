<?php

namespace Civi\Webshoptools;

class HandleWebShopActivity {

  /**
   * @param $operation
   * @param $objectName
   * @param $id
   * @param $params
   * @return void
   */
  public static function run($operation, $objectName, $id, &$params) {
    if (empty($params['custom']) || !($objectName == 'Activity' && ($operation == 'create' || $operation == 'edit'))) {
      return;
    }

    $currentActivity = $operation == 'edit' ? civicrm_api3('Activity', 'getsingle', ['id' => $params['id']]) : null;
    $activityTypeId = $operation == 'edit' ? $currentActivity['activity_type_id'] : $params['activity_type_id'];

    if (self::getWebShopActivityTypeId() != $activityTypeId) {
      return;
    }

    $customFieldsData = self::getWebShopCustomFieldsData($params, $currentActivity);
    $params['subject'] = self::generateSubject($customFieldsData);

    if (self::isNeedToUpdateOrderExportedField($currentActivity, $params, $operation)) {
      self::setCustomValue('order_exported', '1', $customFieldsData, $params);
    }

    if (self::isNeedToUpdateOrderExportedDateField($currentActivity, $params, $operation, $customFieldsData)) {
      self::setCustomValue('order_exported_date', \CRM_Utils_Date::currentDBDate(), $customFieldsData, $params);
    }
  }

  /**
   * Gets 'Webshop Order' activity type id
   *
   * @return int
   */
  private static function getWebShopActivityTypeId() {
    return (int) civicrm_api3('OptionValue', 'getvalue', [
      'sequential' => 1,
      'return' => 'value',
      'option_group_id' => 'activity_type',
      'name' => 'Webshop Order',
    ]);
  }

  /**
   * Gets 'webshop_information' custom fields data
   *
   * @return array
   */
  private static function getWebShopCustomFieldsData($params, $currentActivity) {
    $preparedCustomFields = [];
    $fieldRowId = '-1';
    $customFields = civicrm_api3('CustomField', 'get', [
      'sequential' => 1,
      'custom_group_id' => 'webshop_information',
    ]);

    foreach ($customFields['values'] as $customField) {
      $data = [];
      $data['custom_field_data'] = $customField;
      $data['custom_field_id'] = $customField['id'];
      $data['entity_field_name'] = 'custom_' . $customField['id'];
      $data['old_value'] = empty($currentActivity[$data['entity_field_name']]) ? '' : $currentActivity[$data['entity_field_name']];

      if (empty($params['custom'][$customField['id']])) {
        $data['new_value'] = '';
        $data['new_value_label'] = '';
      } else {
        foreach ($params['custom'][$customField['id']] as $field) {
          if (!empty($field['id'])) {
            $fieldRowId = $field['id'];
          }
          $data['new_value'] = $field['value'];

          if (!empty($customField['option_group_id']) && !empty($data['new_value'])) {
            $data['new_value_label'] = civicrm_api3('OptionValue', 'getvalue', [
              'return' => 'label',
              'option_group_id' => $customField['option_group_id'],
              'value' => $data['new_value'],
            ]);
          } else {
            $data['new_value_label'] = $field['value'];
          }
        }
      }

      $preparedCustomFields[$customField['name']] = $data;
    }

    foreach ($customFields['values'] as $customField) {
      $preparedCustomFields[$customField['name']]['params_key'] = $preparedCustomFields[$customField['name']]['entity_field_name'] . '_' . $fieldRowId;
      $preparedCustomFields[$customField['name']]['field_row_id'] = (int) $fieldRowId;
    }

    return $preparedCustomFields;
  }

  /**
   * @return string
   */
  private static function generateSubject($customFieldsData) {
    $orderType = $shirtType = $shirtSize = $orderCount = '';

    if (!empty($customFieldsData['order_type']['new_value_label'])) {
      $orderType = $customFieldsData['order_type']['new_value_label'] . ' ';
    }

    if (!empty($customFieldsData['shirt_type']['new_value_label']) && !empty($customFieldsData['shirt_size']['new_value_label'])) {
      $shirtType = $customFieldsData['shirt_type']['new_value_label'] . '/';
    } elseif (!empty($customFieldsData['shirt_type']['new_value_label'])) {
      $shirtType = $customFieldsData['shirt_type']['new_value_label'] . ' ';
    }

    if (!empty($customFieldsData['shirt_size']['new_value_label'])) {
      $shirtSize = $customFieldsData['shirt_size']['new_value_label'] . ' ';
    }

    if (!empty($customFieldsData['order_count']['new_value_label'])) {
      $orderCount = $customFieldsData['order_count']['new_value_label'] . 'x';
    }

    return trim($orderType . $shirtType . $shirtSize . $orderCount);
  }

  /**
   * @param $currentActivity
   * @param $params
   * @param $operation
   * @return bool
   */
  private static function isNeedToUpdateOrderExportedField($currentActivity, $params, $operation) {
    if (!in_array($operation, ['edit', 'create'])) {
      return false;
    }

    $completedStatusId = \CRM_Core_PseudoConstant::getKey('CRM_Activity_BAO_Activity', 'activity_status_id', 'Completed');

    if ($operation == 'create') {
      // while creating activity CiviCRM sets 'Completed' status as default if status is empty
      if (empty($params['status_id'])) {
        return true;
      }

      if ($params['status_id'] == $completedStatusId) {
        return true;
      }
    }

    if ($operation == 'edit') {
      $currentStatusId = $currentActivity['status_id'];
      $newStatusId = $params['status_id'];

      return $currentStatusId != $newStatusId && $newStatusId == $completedStatusId;
    }

    return false;
  }

  /**
   * @param $currentActivity
   * @param $params
   * @param $operation
   * @param $customFieldsData
   * @return bool
   */
  private static function isNeedToUpdateOrderExportedDateField($currentActivity, $params, $operation, $customFieldsData) {
    if (!self::isNeedToUpdateOrderExportedField($currentActivity, $params, $operation)) {
      return false;
    }

    if (empty($customFieldsData['order_exported_date']['old_value']) && empty($customFieldsData['order_exported_date']['new_value'])) {
      return true;
    }

    return false;
  }

  /**
   * Set new custom filed value to params
   *
   * @param $name
   * @param $value
   * @param $customFieldsData
   * @param $params
   * @return void
   */
  private static function setCustomValue($name, $value, $customFieldsData, &$params) {
    if (empty($params['custom'][$customFieldsData[$name]['custom_field_id']])) {
      return;
    }

    $params[$customFieldsData[$name]['params_key']] = $value;
    $params['custom'][$customFieldsData[$name]['custom_field_id']][$customFieldsData[$name]['field_row_id']]['value'] = $value;
  }

}
