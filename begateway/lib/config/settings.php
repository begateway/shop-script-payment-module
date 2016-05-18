<?php

return array(
	'SHOP_ID'    => array(
        'value'        => '',
        'title'        => $this->_w('Shop Id'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
  'SHOP_KEY'    => array(
        'value'        => '',
        'title'        => $this->_w('Shop secret key'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
	'PAYMENT_TYPE'    => array(
        'value'        => '',
        'title'        => $this->_w('Transaction type'),
        'description'  => '',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            waPayment::OPERATION_AUTH_CAPTURE => 'Payment',
            waPayment::OPERATION_AUTH_ONLY => 'Authorization'
        ),
   ),
  'DOMAIN_GATEWAY'     => array(
         'value'        => '',
         'title'        => $this->_w('Payment gateway domain'),
         'description'  => $this->_w('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   ),
  'DOMAIN_PAYMENTPAGE' => array(
         'value'        => '',
         'title'        => $this->_w('Payment page domain'),
         'description'  => $this->_w('Ask your payment processor for these options values'),
         'control_type' => waHtmlControl::INPUT,
   ),
	'PAYMENT_PAGE_TYPE'  => array(
        'value'        => '',
        'title'        => $this->_w('Payment page type'),
        'description'  => '',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            waPayment::OPERATION_INTERNAL_PAYMENT => $this->_w('iFrame'),
            waPayment::OPERATION_HOSTED_PAYMENT_PRIOR_ORDER => $this->_w('Redirect')
        ),
   )
);
