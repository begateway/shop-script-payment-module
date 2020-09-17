<?php

return array(
	'SHOP_ID'    => array(
        'value'        => '',
        'title'        => /*_wp*/('Shop Id'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
  'SHOP_KEY'    => array(
        'value'        => '',
        'title'        => /*_wp*/('Shop secret key'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
	'PAYMENT_TYPE'    => array(
        'value'        => '',
        'title'        => /*_wp*/('Transaction type'),
        'description'  => '',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            waPayment::OPERATION_AUTH_CAPTURE => 'Payment',
            waPayment::OPERATION_AUTH_ONLY => 'Authorization'
        ),
   ),
  'DOMAIN_PAYMENTPAGE' => array(
         'value'        => '',
         'title'        => /*_wp*/('Payment page domain'),
         'description'  => /*_wp*/('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
  ),
  'ENABLE_BANKCARD' => array(
    'value'        => true,
    'control_type' => waHtmlControl::CHECKBOX,
    'title'        => /*_wp*/('Enable bankcard payments'),
  ),
  'ENABLE_BANKCARD_HALVA' => array(
    'value'        => false,
    'control_type' => waHtmlControl::CHECKBOX,
    'title'        => /*_wp*/('Enable Halva bankcard payments'),
  ),
  'ENABLE_ERIP' => array(
    'value'        => false,
    'control_type' => waHtmlControl::CHECKBOX,
    'title'        => /*_wp*/('Enable ERIP payments'),
  ),
  'ENABLE_TEST_MODE' => array(
    'value'        => false,
    'control_type' => waHtmlControl::CHECKBOX,
    'title'        => /*_wp*/('Enable Test mode'),
  ),
  'ERIP_SERVICE_CODE' => array(
         'value'        => '99999999',
         'title'        => /*_wp*/('ERIP service code'),
         'description'  => /*_wp*/('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   )
);
