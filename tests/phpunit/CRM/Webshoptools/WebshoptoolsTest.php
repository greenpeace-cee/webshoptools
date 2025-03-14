<?php

use Civi\Api4\CustomField;
use Civi\Api4\OptionValue;
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
    OptionValue::create(FALSE)
      ->addValue('option_group_id:name', 'order_type')
      ->addValue('label', 'Banner Bag - Urban Activist')
      ->addValue('value', '1')
      ->execute();
    $customFieldNames = [
      'order_type',
      'shirt_type',
      'shirt_size',
      'order_count',
      'order_exported',
      'order_exported_date',
    ];
    $customFields = [];
    foreach ($customFieldNames as $field) {
      $result = CustomField::get(FALSE)
        ->addSelect('id')
        ->addWhere('name', '=', $field)
        ->addWhere('custom_group_id:name', '=', 'webshop_information')
        ->execute()
        ->first();
      $customFields[$field] = $result['id'];
    }

    $contact = $this->callAPISuccess('Contact', 'create', [
      'contact_type' => 'Individual',
      'email'        => 'webshoptools@example.com',
    ]);

    $activity = $this->callAPISuccess('Activity', 'create', [
      'source_contact_id' => $contact['id'],
      'activity_type_id' => 'Webshop Order',
      'custom_' . $customFields['order_type'] => 1,
      'custom_' . $customFields['order_count'] => 1,
      'custom_' . $customFields['shirt_type'] => 'M',
      'custom_' . $customFields['shirt_size'] => 'S',
    ]);

    $this->assertEquals('Banner Bag - Urban Activist Herren/S 1x', $activity['values'][$activity['id']]['subject']);

    $activity = $this->callAPISuccess('Activity', 'create', [
      'id' => $activity['id'],
      'custom_' . $customFields['order_count'] => 2,
    ]);

    $this->assertEquals('Banner Bag - Urban Activist Herren/S 2x', $activity['values'][$activity['id']]['subject']);
  }

}
