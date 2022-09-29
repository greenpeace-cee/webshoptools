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
      $data['old_value_label'] = self::getValueLabel($customField['option_group_id'], $data['old_value']);
      $data['is_isset_new_value'] = false;

      if (empty($params['custom'][$customField['id']])) {
        $data['new_value'] = '';
        $data['new_value_label'] = '';
      } else {
        foreach ($params['custom'][$customField['id']] as $field) {
          if (!empty($field['id'])) {
            $fieldRowId = $field['id'];
          }
          $data['is_isset_new_value'] = true;
          $data['new_value'] = $field['value'];
          $data['new_value_label'] = self::getValueLabel($customField['option_group_id'], $data['new_value']);
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
   * Gets label of 'optionValue' entity by 'value' field
   *
   * @param $optionGroupId
   * @param $value
   * @return string
   */
  public static function getValueLabel($optionGroupId, $value) {
    if (empty($optionGroupId) || empty($value)) {
      return $value;
    }

    try {
      $label = civicrm_api3('OptionValue', 'getvalue', [
        'return' => 'label',
        'option_group_id' => $optionGroupId,
        'value' => $value,
      ]);
    } catch (CiviCRM_API3_Exception $e) {
      return $value;
    }

    return $label;
  }

  /**
   * @return string
   */
  private static function generateSubject($customFieldsData) {
    $shirtTypeSeparator = ' ';
    if (!empty($customFieldsData['shirt_size']['new_value_label']) || !empty($customFieldsData['shirt_size']['old_value_label']))  {
      $shirtTypeSeparator = '/';
    }

    $shirtSize = self::findCustomFiledValue($customFieldsData, 'shirt_size') . ' ';
    $orderType = self::findCustomFiledValue($customFieldsData, 'order_type') . ' ';
    $shirtType = self::findCustomFiledValue($customFieldsData, 'shirt_type') . $shirtTypeSeparator;
    $orderCount = self::findCustomFiledValue($customFieldsData, 'order_count') . 'x';

    return trim($orderType . $shirtType . $shirtSize . $orderCount);
  }

  /**
   * Finds actual value in custom fields data
   *
   * @param $customFieldsData
   * @param $fieldName
   * @return string
   */
  public static function findCustomFiledValue($customFieldsData, $fieldName) {
    $value = '';

    if (!empty($customFieldsData[$fieldName])) {
      if ($customFieldsData[$fieldName]['is_isset_new_value']) {
        $value = $customFieldsData[$fieldName]['new_value_label'];
      } else {
        $value = $customFieldsData[$fieldName]['old_value_label'];
      }
    }

    return $value;
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
