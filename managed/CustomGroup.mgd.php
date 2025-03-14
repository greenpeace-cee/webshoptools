<?php
use CRM_Webshoptools_ExtensionUtil as E;

return [
  [
    'name' => 'CustomGroup_webshop_information',
    'entity' => 'CustomGroup',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'webshop_information',
        'title' => E::ts('Webshop Information'),
        'extends' => 'Activity',
        'extends_entity_column_value:name' => [
          'Webshop Order',
        ],
        'style' => 'Inline',
        'help_pre' => '',
        'help_post' => '',
        'weight' => 38,
        'collapse_adv_display' => TRUE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_order_exported_date',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'order_exported_date',
        'label' => E::ts('Order exported date'),
        'data_type' => 'Date',
        'html_type' => 'Select Date',
        'is_searchable' => TRUE,
        'is_search_range' => TRUE,
        'text_length' => 255,
        'date_format' => 'dd.mm.yy',
        'time_format' => 2,
        'note_columns' => 60,
        'note_rows' => 4,
        'column_name' => 'order_exported_date_59',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_order_type',
    'entity' => 'OptionGroup',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'order_type',
        'title' => E::ts('Order Type'),
        'is_reserved' => FALSE,
        'option_value_fields' => [
          'name',
          'label',
          'description',
        ],
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_order_type',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'order_type',
        'label' => E::ts('Order Type'),
        'html_type' => 'Select',
        'is_searchable' => TRUE,
        'column_name' => 'order_type',
        'option_group_id.name' => 'order_type',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_type',
    'entity' => 'OptionGroup',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'shirt_type',
        'title' => E::ts('T-Shirt Type Options'),
        'is_reserved' => FALSE,
        'option_value_fields' => [
          'name',
          'label',
          'description',
        ],
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_type_OptionValue_Herren',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_type',
        'label' => E::ts('Herren'),
        'value' => 'M',
        'name' => 'Herren',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_type_OptionValue_Damen',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_type',
        'label' => E::ts('Damen'),
        'value' => 'W',
        'name' => 'Damen',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_type_OptionValue_Kinder',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_type',
        'label' => E::ts('Kinder'),
        'value' => 'C',
        'name' => 'Kinder',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_shirt_type',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'shirt_type',
        'label' => E::ts('T-Shirt-Type'),
        'html_type' => 'Select',
        'is_searchable' => TRUE,
        'column_name' => 'shirt_type',
        'option_group_id.name' => 'shirt_type',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size',
    'entity' => 'OptionGroup',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'shirt_size',
        'title' => E::ts('T-Shirt Size Options'),
        'is_reserved' => FALSE,
        'option_value_fields' => [
          'name',
          'label',
          'description',
        ],
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_S',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('S'),
        'value' => 'S',
        'name' => 'S',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_M',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('M'),
        'value' => 'M',
        'name' => 'M',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_L',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('L'),
        'value' => 'L',
        'name' => 'L',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_XL',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('XL'),
        'value' => 'XL',
        'name' => 'XL',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_104',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('3-4 (98-104cm)'),
        'value' => '3-4 (98-104cm)',
        'name' => '104',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_110',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('5-6 (110-116cm)'),
        'value' => '5-6 (110-116cm)',
        'name' => '110',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_116',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('7-8 (122-128cm)'),
        'value' => '7-8 (122-128cm)',
        'name' => '116',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_122',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('9-11 (134-146cm)'),
        'value' => '9-11 (134-146cm)',
        'name' => '122',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'OptionGroup_shirt_size_OptionValue_128',
    'entity' => 'OptionValue',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'option_group_id.name' => 'shirt_size',
        'label' => E::ts('12-14 (152-164cm)'),
        'value' => '12-14 (152-164cm)',
        'name' => '128',
        'filter' => NULL,
        'is_active' => FALSE,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_shirt_size',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'shirt_size',
        'label' => E::ts('T-Shirt-Size'),
        'html_type' => 'Select',
        'is_searchable' => TRUE,
        'column_name' => 'shirt_size',
        'option_group_id.name' => 'shirt_size',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_order_count',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'order_count',
        'label' => E::ts('Number of Items'),
        'data_type' => 'Int',
        'html_type' => 'Text',
        'default_value' => '1',
        'is_searchable' => TRUE,
        'column_name' => 'order_count',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_approval_date',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'approval_date',
        'label' => E::ts('Approval Date'),
        'data_type' => 'Date',
        'html_type' => 'Select Date',
        'is_searchable' => TRUE,
        'is_view' => TRUE,
        'date_format' => 'dd.mm.yy',
        'column_name' => 'approval_date',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_payment_received',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'payment_received',
        'label' => E::ts('Payment received?'),
        'data_type' => 'Boolean',
        'html_type' => 'Radio',
        'default_value' => '0',
        'is_searchable' => TRUE,
        'column_name' => 'payment_received',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_free_order',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'free_order',
        'label' => E::ts('Free Order?'),
        'data_type' => 'Boolean',
        'html_type' => 'Radio',
        'default_value' => '0',
        'is_searchable' => TRUE,
        'column_name' => 'free_order',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_order_exported',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'order_exported',
        'label' => E::ts('Order exported?'),
        'data_type' => 'Boolean',
        'html_type' => 'Radio',
        'default_value' => '0',
        'is_searchable' => TRUE,
        'column_name' => 'order_exported',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_linked_contribution',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'linked_contribution',
        'label' => E::ts('Linked Contribution'),
        'data_type' => 'Int',
        'html_type' => 'Text',
        'is_searchable' => TRUE,
        'help_post' => E::ts('Hier bitte die CONTRIBUTION_ID eingeben, die für die Bezahlung der Webshoporder verwendet werden soll!'),
        'column_name' => 'linked_contribution',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_linked_membership',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'linked_membership',
        'label' => E::ts('Linked Membership'),
        'data_type' => 'Int',
        'html_type' => 'Text',
        'is_searchable' => TRUE,
        'help_post' => E::ts('Hier bitte die MEMBERSHIP_ID eingeben, die für die Bezahlung der Webshoporder verwendet werden soll!'),
        'column_name' => 'linked_membership',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_webshop_information_CustomField_multi_purpose',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'webshop_information',
        'name' => 'multi_purpose',
        'label' => E::ts('Multi Purpose Field'),
        'data_type' => 'Memo',
        'html_type' => 'TextArea',
        'is_searchable' => TRUE,
        'attributes' => 'rows=4, cols=60',
        'is_view' => TRUE,
        'text_length' => 512,
        'note_columns' => 60,
        'note_rows' => 4,
        'column_name' => 'multi_purpose',
      ],
      'match' => [
        'name',
      ],
    ],
  ],
];