<?php

namespace Civi\Webshoptools;

class HandleWebShopActivityTest {

  private $customFieldsKeys;
  private $customFields;

  /**
   * Tests webshop activity logic
   *
   * @return void
   */
  public function run() {
    $customFieldsData = $this->getCustomFieldsData();
    $this->customFieldsKeys = $customFieldsData['keys'];
    $this->customFields = $customFieldsData['data'];
    echo '<pre>';
    var_dump('Test by api v3:');
    echo '</pre>';

    $result = civicrm_api3('Activity', 'create', [
      'status_id' => "Scheduled", // test statuses: "Completed" , "Scheduled"
      'source_contact_id' => 2,
      'activity_type_id' => 'Webshop Order',
      $this->customFieldsKeys['shirt_size']['v3'] => "M",
      $this->customFieldsKeys['shirt_type']['v3'] => "W",
      $this->customFieldsKeys['order_type']['v3'] => "2",
      $this->customFieldsKeys['order_count']['v3'] => "55",
      $this->customFieldsKeys['order_exported']['v3'] => "0",
      $this->customFieldsKeys['order_exported_date']['v3'] => "2011-10-10",
    ]);

    $activity = $this->getActivity($result['id']);
    echo '<pre>';
    var_dump('Activity after creation:');
    var_dump($activity);
    echo '</pre>';

    // update Activity status
    $result = civicrm_api3('Activity', 'create', [
      'id' => $result['id'],
      'status_id' => "Completed",
    ]);

    $activity = $this->getActivity($result['id']);

    echo '<pre>';
    var_dump('Activity after updating:');
    var_dump($activity);
    echo '</pre>';

    echo '<pre>';
    var_dump('Test by api v4:');
    echo '</pre>';

    $result = \Civi\Api4\Activity::create()
      ->addValue('activity_type_id:name', 'Webshop Order')
      ->addValue('source_contact_id', 2)
      ->addValue('status_id:name', 'Scheduled')// Test statuses: "Completed" , "Scheduled"
      ->addValue($this->customFieldsKeys['shirt_size']['v4'], "M")
      ->addValue($this->customFieldsKeys['shirt_type']['v4'], "W")
      ->addValue($this->customFieldsKeys['order_type']['v4'], "2")
      ->addValue($this->customFieldsKeys['order_count']['v4'], "55")
      ->addValue($this->customFieldsKeys['order_exported']['v4'], "0")
      ->addValue($this->customFieldsKeys['order_exported_date']['v4'], "2011-10-10")
      ->execute();

    $activity = $this->getActivity($result->first()['id']);
    echo '<pre>';
    var_dump('Activity after creation:');
    var_dump($activity);
    echo '</pre>';

    $results = \Civi\Api4\Activity::update()
      ->addValue('id', $result->first()['id'])
      ->addValue('status_id:name', 'Completed')
      ->execute();

    $activity = $this->getActivity($results->first()['id']);

    echo '<pre>';
    var_dump('Activity after updating:');
    var_dump($activity);
    echo '</pre>';

    echo '<pre>';
    var_dump('End tests');
    echo '</pre>';
    exit();
  }

  /**
   * @param $activityId
   * @return array
   */
  private function getActivity($activityId) {
    $returnFields = [
      'id',
      'subject',
      'status_id',
    ];

    foreach ($this->customFieldsKeys as $customFieldKeys) {
      $returnFields[] = $customFieldKeys['v3'];
    }

    $activity =  civicrm_api3('Activity', 'getsingle', [
      'sequential' => 1,
      'return' => $returnFields,
      'id' => $activityId,
    ]);

    $activityPrepared = [];
    foreach ($activity as $activityFiledName => $activityFiledValue) {
      if ($activityFiledName == 'id') {
        $activityPrepared['id'] = $activityFiledValue;
      }
      if ($activityFiledName == 'subject') {
        $activityPrepared['subject'] = $activityFiledValue;
      }
      if ($activityFiledName == 'status_id') {
        $activityPrepared['status_id'] = $activityFiledValue;
        $activityPrepared['status'] = civicrm_api3('OptionValue', 'getvalue', [
          'sequential' => 1,
          'return' => 'name',
          'option_group_id' => 'activity_status',
          'value' => $activityFiledValue,
        ]);
      }

      if (isset($this->customFields[$activityFiledName])) {
        $activityPrepared[$this->customFields[$activityFiledName]['name']] = $activityFiledValue;
      }
    }

    return $activityPrepared;
  }

  /**
   * @return array[]
   */
  private function getCustomFieldsData() {
    $customFieldsResult = civicrm_api3('CustomField', 'get', [
      'sequential' => 1,
      'custom_group_id' => "webshop_information",
      'name' => [
        'IN' => [
          "shirt_size",
          "shirt_type",
          "order_type",
          "order_count",
          "order_exported",
          "order_exported_date",
        ]
      ],
      'options' => ['limit' => 0],
    ]);

    $data = [];
    foreach ($customFieldsResult['values'] as $customField) {
      $data['custom_' . $customField['id']] = $customField;
    }

    $keys = [];
    foreach ($customFieldsResult['values'] as $customField) {
      $keys[$customField['name']] = [
        'v3' => 'custom_' . $customField['id'],
        'v4' => 'webshop_information.' . $customField['name'],
      ];
    }

    return [
      'keys' => $keys,
      'data' => $data,
    ];
  }

}
