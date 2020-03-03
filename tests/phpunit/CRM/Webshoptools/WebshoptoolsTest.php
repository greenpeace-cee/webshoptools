<?php

use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * Test activity subject handling
 *
 * @group headless
 */
class CRM_Webshoptools_WebshoptoolsTest extends \PHPUnit\Framework\TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

  use \Civi\Test\Api3TestTrait;

  public function setUpHeadless() {
    return \Civi\Test::headless()
      ->installMe(__DIR__)
      ->apply();
  }

  /**
   * Test that activity subject is correct
   */
  public function testActivitySubjectIsCorrect() {
    $webshopOrder = $this->callAPISuccess('OptionValue', 'create', [
      'option_group_id' => 'activity_type',
      'name' => 'Webshop Order',
      'is_active' => 1,
    ]);

    $customGroup = $this->callAPISuccess('CustomGroup', 'create', [
      'title' => 'Webshop Information',
      'extends' => 'Activity',
      'extends_entity_column_value' => 'Webshop Order',
      'table_name' => 'civicrm_value_webshop_information',
      'is_active' => 1,
      'style' => 'Inline',
      'collapse_display' => 0,
      'collapse_adv_display' => 1,
    ]);

    $customParams = [
      'order_type' => ['data_type' => 'String', 'html_type' => 'Select', 'label' => 'Order Type'],
      'shirt_type' => ['data_type' => 'String', 'html_type' => 'Select', 'label' => 'T-Shirt-Type'],
      'shirt_size' => ['data_type' => 'String', 'html_type' => 'Select', 'label' => 'T-Shirt-Size'],
      'order_count' => ['data_type' => 'Int', 'html_type' => 'Text', 'label' => 'Number of Items'],
    ];
    $customFields = [];

    foreach ($customParams as $key => $param) {
      $apiParams = [
        'custom_group_id' => $customGroup['id'],
        'label' => $param['label'],
        'name' => $key,
        'column_name' => $key,
        'data_type' => $param['data_type'],
        'html_type' => $param['html_type'],
        'is_active' => 1,
        'is_searchable' => 1,
      ];

      if ($key == 'order_type') {
        $apiParams['option_label'] = ['Banner Bag - Urban Activist'];
        $apiParams['option_value'] = ['1'];
        $apiParams['option_weight'] = [1];
        $apiParams['option_status'] = [1];
      }

      $result = $this->callAPISuccess('CustomField', 'create', $apiParams);

      $customFields[$key] = $result['id'];

      if (isset(\Civi::$statics['CRM_Core_BAO_OptionGroup'])) {
        unset(\Civi::$statics['CRM_Core_BAO_OptionGroup']);
      }
    }

    $contact = $this->callAPISuccess('Contact', 'create', [
      'contact_type' => 'Individual',
      'email'        => 'webshoptools@example.com',
    ]);

    $activity = $this->callAPISuccess('Activity', 'create', [
      'source_contact_id' => $contact['id'],
      'activity_type_id' => $webshopOrder['values'][$webshopOrder['id']]['value'],
      'custom_' . $customFields['order_type'] => 1,
      'custom_' . $customFields['order_count'] => 1,
    ]);

    $this->assertEquals('Banner Bag - Urban Activist 1x', $activity['values'][$activity['id']]['subject']);

    $activity = $this->callAPISuccess('Activity', 'create', [
      'id' => $activity['id'],
      'custom_' . $customFields['order_count'] => 2,
    ]);

    $this->assertEquals('Banner Bag - Urban Activist 2x', $activity['values'][$activity['id']]['subject']);
  }

}
