<?php
use CRM_Webshoptools_ExtensionUtil as E;

return [
  [
    'name' => 'OptionValue_Webshop_Order',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'activity_type',
        'label' => E::ts('Webshop Order'),
        'name' => 'Webshop Order',
      ],
      'match' => [
        'option_group_id',
        'name',
      ],
    ],
  ],
];