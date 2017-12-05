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
  'DOMAIN_GATEWAY'     => array(
         'value'        => '',
         'title'        => /*_wp*/('Payment gateway domain'),
         'description'  => /*_wp*/('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   ),
  'DOMAIN_PAYMENTPAGE' => array(
         'value'        => '',
         'title'        => /*_wp*/('Payment page domain'),
         'description'  => /*_wp*/('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   ),
	'PAYMENT_PAGE_TYPE'  => array(
        'value'        => '',
        'title'        => /*_wp*/('Payment page type'),
        'description'  => '',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            waPayment::OPERATION_HOSTED_PAYMENT_PRIOR_ORDER => /*_wp*/('Redirect'),
            waPayment::OPERATION_INTERNAL_PAYMENT => /*_wp*/('iFrame')
        ),
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
  'ERIP_SERVICE_CODE' => array(
         'value'        => '99999999',
         'title'        => /*_wp*/('ERIP service code'),
         'description'  => /*_wp*/('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   ),
  'CSS' => array(
         'value'        => '',
         'title'        => /*_wp*/('iFrame CSS'),
         'description'  => '',
         'control_type' => waHtmlControl::INPUT,
   )
);
