<?php

return array(
	'SHOP_ID'    => array(
        'value'        => '',
        'title'        => $this->_w('Идентификационный номер магазина'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
  'SHOP_KEY'    => array(
        'value'        => '',
        'title'        => $this->_w('Секретный ключ магазина'),
        'description'  => '',
        'control_type' => waHtmlControl::INPUT,
    ),
	'PAYMENT_TYPE'    => array(
        'value'        => '',
        'title'        => $this->_w('Тип платежа'),
        'description'  => '',
        'control_type' => waHtmlControl::SELECT,
        'options'      => array(
            waPayment::OPERATION_AUTH_CAPTURE => 'Payment',
            waPayment::OPERATION_AUTH_ONLY => 'Authorization'
        ),
   ),
   'DOMAIN_GATEWAY'     => array(
         'value'        => '',
         'title'        => $this->_w('Домен платежного шлюза'),
         'description'  => $this->_w('Узнайте значениe этого параметра у вашей платежной компании'),
         'control_type' => waHtmlControl::INPUT,
   ),
   'DOMAIN_PAYMENTPAGE' => array(
         'value'        => '',
         'title'        => $this->_w('Домен платежной страницы'),
         'description'  => $this->_w('Узнайте значениe этого параметра у вашей платежной компании'),
         'control_type' => waHtmlControl::INPUT,
   )
);
