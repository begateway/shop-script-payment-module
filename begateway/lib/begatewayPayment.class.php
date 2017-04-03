<?php
require_once __DIR__ . '/begateway-api-php/lib/beGateway.php';

class begatewayPayment extends waPayment implements waIPayment, waIPaymentCancel, waIPaymentRefund
{
  public function allowedCurrency()
  {
    return true;
  }

  public function payment($payment_form_data, $order_data, $auto_submit = false)
  {
    if(!isset($_GET['type'])) {

      $order = waOrder::factory($order_data);
      $contact = new waContact($order_data->contact_id);

      $inv_desc = preg_replace('/[^\.\?,\[]\(\):;"@\\%\s\w\d]+/', ' ', $order->description);
      $inv_desc = preg_replace('/[\s]{2,}/', ' ', $inv_desc);

      $url = $this->getRelayUrl();

      $wa = '?wa_app_id=' . $this->app_id . '&wa_merchant_id=' . $this->merchant_id . '&wa_order_id=' . $order_data['order_id'];

      $url = $url . $wa;

      $url_success = $url.'&transaction_result=success';
      $url_fail = $url.'&transaction_result=fail';
      $url_notification = $url.'&transaction_result=notification';

      $url_notification = str_replace('carts.local', 'webhook.begateway.com:8443', $url_notification);

      $description = preg_replace('/[^\.\?,\[]\(\):;"@\\%\s\w\d]+/', ' ', $order->description);
      $description = preg_replace('/[\s]{2,}/', ' ', $description);

      $transaction = new \beGateway\GetPaymentToken();

      if ($this->PAYMENT_TYPE == waPayment::OPERATION_AUTH_ONLY) {
        $transaction->setAuthorizationTransactionType();
      } else {
        $transaction->setPaymentTransactionType();
      }

      $transaction->money->setAmount(number_format($order_data['amount'], 2, '.', ''));
      $transaction->money->setCurrency($order_data['currency_id']);
      $transaction->setDescription(mb_substr($description, 0, 100, "UTF-8"));
      $transaction->setTrackingId($this->app_id.'_'.$this->merchant_id.'_'.$order_data['order_id']);
      $transaction->setLanguage(substr($order->getContact()->getLocale(), 0, 2));
      $transaction->setNotificationUrl($url_notification);
      $transaction->setSuccessUrl($url_success);
      $transaction->setFailUrl($url_fail);
      $transaction->setDeclineUrl($url_fail);
      $transaction->setCancelUrl(wa()->getRootUrl(true));
      $transaction->setAddressHidden();

      $firstname = $contact->get('firstname', 'default');
      $lastname = $contact->get('lastname', 'default');
      $address = $contact->get('address:street', 'default');
      $city = $contact->get('address:city', 'default');
      $zip = $contact->get('address:zip', 'default');

      if (strlen($firstname) > 0)
        $transaction->customer->setFirstName($firstname);
      if (strlen($lastname) > 0)
        $transaction->customer->setLastName($lastname);
      if (strlen($address) > 0)
        $transaction->customer->setAddress($address);
      if (strlen($city) > 0)
        $transaction->customer->setCity($city);
      if (strlen($zip) > 0)
        $transaction->customer->setZip($zip);

      $transaction->customer->setEmail($contact->get('email', 'default'));

      $countries_map = $this->_countries_mapper();

      $country = $contact->get('address:country', 'default');
      if(isset($countries_map[$country])) {
        $transaction->customer->setCountry($countries_map[$country]);

        if ($countries_map[$country] == 'US' || $countries_map[$country] == 'CA') {
          $transaction->customer->setState($contact->get('address:region', 'default'));
        }

        $transaction->setAddressHidden();
      }

      if ($this->ENABLE_BANKCARD) {
        $cc = new \beGateway\PaymentMethod\CreditCard;
        $transaction->addPaymentMethod($cc);
      }

      if ($this->ENABLE_BANKCARD_HALVA) {
        $halva = new \beGateway\PaymentMethod\CreditCardHalva;
        $transaction->addPaymentMethod($halva);
      }

      if ($this->ENABLE_ERIP && strlen($this->ERIP_SERVICE_CODE)>0) {
        $erip = new \beGateway\PaymentMethod\Erip(array(
          'order_id' => $order_data['order_id'],
          'account_number' => $order->id_str,
          'service_no' => $this->ERIP_SERVICE_CODE
        ));
        $transaction->addPaymentMethod($erip);
      }

      $response = $transaction->submit();

      $view = wa()->getView();

      if(!$response->isSuccess()) {
        $view->assign('error', '1');
        $view->assign('message', $response->getMessage());
      } else {
        $view->assign('redirect_url', $response->getRedirectUrl());
        $view->assign('css', $this->CSS);

        if ($this->PAYMENT_PAGE_TYPE == waPayment::OPERATION_INTERNAL_PAYMENT) {
          $view->assign('message', $this->_w('Pay by bankcard'));
          $view->assign('iframe', '1');
          $view->assign('message_button', $this->_w('Proceed to payment'));
        } else {
          $view->assign('iframe', '0');
          $view->assign('message', $this->_w('Redirection to payment system page to complete payment...'));
          $view->assign('token', $response->getToken());
          $view->assign('message_button', $this->_w('Proceed to payment system'));
        }
      }
      return $view->fetch($this->path.'/templates/payment.html');
    }
	}

  public function refund($transaction_raw_data)
  {

  }

  public function cancel($transaction_raw_data)
  {

  }

  protected function callbackInit($request)
	{
    $pattern = "@^([a-z]+)_(\\d+)_(.+)$@";
    $this->request = $request;
    $this->post = file_get_contents('php://input');

    $this->merchant_id = ifempty($request['wa_merchant_id']);
    $this->app_id = ifempty($request['wa_app_id']);
    $this->order_id = ifempty($request['wa_order_id']);

    if ($this->post && empty($request['token'])) {
      $this->init();
      $this->webhook = new \beGateway\Webhook();

      if ($this->webhook->getResponse()) {
        $tracking_id = $this->webhook->getResponse()->transaction->tracking_id;

        if ($this->webhook->isAuthorized() &&
            !empty($tracking_id) &&
            preg_match($pattern, $tracking_id, $match)) {

          $this->app_id = $match[1];
          $this->merchant_id = $match[2];
          $this->order_id = $match[3];
        }
      }
    }

		return parent::callbackInit($request);
	}

  protected function callbackHandler($request)
  {
    if (!$this->order_id || !$this->app_id || !$this->merchant_id) {
            throw new waPaymentException('invalid invoice number');
    }

    $pattern = "@^([a-z]+)_(\\d+)_(.+)$@";

    $transaction_result = ifempty($request['transaction_result'], 'success');

    $url = null;
    $app_payment_method = null;
    $order_id = null;

    switch ($transaction_result) {
      case 'notification':

        $transaction_data = $this->formalizeData($request);

        if($this->webhook->isSuccess()) {
          $money = new \beGateway\Money;
          $money->setCurrency($this->webhook->getResponse()->transaction->currency);
          $money->setCents($this->webhook->getResponse()->transaction->amount);

          $app_payment_method = self::CALLBACK_PAYMENT;
          $transaction_data = $this->formalizeData($request);
					$transaction_data['native_id'] = $this->webhook->getUid();
					$transaction_data['order_id'] = $this->order_id;
					$transaction_data['amount'] = $money->getAmount();
					$transaction_data['currency_id'] = $money->getCurrency();

          $threeds = ifempty($this->webhook->getResponse()->transaction->three_d_secure_verification->pa_status);
          if ($threeds) {
            $threeds = '3-D Secure: '.$threeds;
          }
          $transaction_data['view_data'] = implode(' ', array(
            'UID: '.$this->webhook->getUid(),
            $threeds));
        } else {
          die('ERROR');
        }
        break;
      case 'success':
        $url = $this->getAdapter()->getBackUrl(waAppPayment::URL_SUCCESS, $transaction_data).'?type=success';
        break;
      case 'fail':
        $url = $this->getAdapter()->getBackUrl(waAppPayment::URL_FAIL, $transaction_data).'?type=fail';
        break;
      default:
        $url = $this->getAdapter()->getBackUrl(waAppPayment::URL_FAIL, $transaction_data).'?type=fail';
        break;
    }

    if ($app_payment_method) {
      $transaction_data = $this->saveTransaction($transaction_data, $request);
      $this->execAppCallback($app_payment_method, $transaction_data);
    }

    if ($transaction_result == 'result') {
      return array(
        'template' => false,
      );
    } else {
      if ($url) {
        return array(
          'redirect' => $url,
        );
      } else {
        die('OK');
      }
    }
  }

  protected function formalizeData($transaction_raw_data)
  {
    $transaction_data = parent::formalizeData($transaction_raw_data);

    if ($this->webhook) {
      if ($this->webhook->isFailed()) {
        $state = waPayment::STATE_DECLINED;
      }

      if ($this->webhook->getResponse()->transaction->type == 'authorization') {
        $type = waPayment::OPERATION_AUTH_ONLY;
        if ($this->webhook->isSuccess()) {
          $state = waPayment::STATE_AUTH;
        }
      } elseif ($this->webhook->getResponse()->transaction->type == 'payment') {
        $type = waPayment::OPERATION_AUTH_CAPTURE;
        if ($this->webhook->isSuccess()) {
          $state = waPayment::STATE_CAPTURED;
        }
      }

      $transaction_data = array_merge($transaction_data, array(
        'type'        => $type,
        'state'       => $state
      ));
    }

    return $transaction_data;
  }

  protected function _countries_mapper() {
    $countries_map = '{"atg":"AG","bih":"BA","civ":"CI","fji":"FJ","vat":"VA","blr":"BY","lao":"LA","usa":"US","pcn":"PN","reu":"RE","shn":"SH","kna":"KN","spm":"PM","stp":"ST","sjm":"SJ","syr":"SY","tto":"TT","mex":"MX","mmr":"MM","wlf":"WF","alb":"AL","dza":"DZ","asm":"AS","vut":"VU","yem":"YE","and":"AD","ago":"AO","aia":"AI","arg":"AR","arm":"AM","abw":"AW","aus":"AU","aut":"AT","aze":"AZ","bhs":"BS","bhr":"BH","bgd":"BD","brb":"BB","bel":"BE","ben":"BJ","bmu":"BM","btn":"BT","bol":"BO","bwa":"BW","bra":"BR","brn":"BN","bgr":"BG","bfa":"BF","bdi":"BI","khm":"KH","cmr":"CM","can":"CA","cpv":"CV","mlt":"MT","cym":"KY","tcd":"TD","chl":"CL","chn":"CN","col":"CO","com":"KM","cok":"CK","cri":"CR","hrv":"HR","cub":"CU","cyp":"CY","cze":"CZ","dnk":"DK","dji":"DJ","dma":"DM","dom":"DO","ecu":"EC","egy":"EG","gnq":"GQ","eri":"ER","est":"EE","eth":"ET","fro":"FO","fin":"FI","fra":"FR","guf":"GF","pyf":"PF","gab":"GA","gmb":"GM","geo":"GE","deu":"DE","gha":"GH","gib":"GI","grc":"GR","grl":"GL","grd":"GD","glp":"GP","gum":"GU","gtm":"GT","gin":"GN","gnb":"GW","guy":"GY","hti":"HT","hnd":"HN","hkg":"HK","hun":"HU","isl":"IS","ind":"IN","idn":"ID","irq":"IQ","isr":"IL","ita":"IT","jam":"JM","jpn":"JP","jor":"JO","kaz":"KZ","ken":"KE","kir":"KI","kwt":"KW","kgz":"KG","lva":"LV","lso":"LS","lbr":"LR","lby":"LY","ltu":"LT","lux":"LU","mac":"MO","mdg":"MG","mwi":"MW","mys":"MY","mdv":"MV","mli":"ML","mhl":"MH","mtq":"MQ","mus":"MU","mco":"MC","mng":"MN","msr":"MS","mar":"MA","moz":"MZ","nam":"NA","nru":"NR","npl":"NP","nld":"NL","ncl":"NC","nzl":"NZ","nic":"NI","ner":"NE","nga":"NG","niu":"NU","nfk":"NF","mnp":"MP","nor":"NO","omn":"OM","pak":"PK","plw":"PW","pan":"PA","pry":"PY","per":"PE","phl":"PH","pol":"PL","prt":"PT","pri":"PR","qat":"QA","rom":"RO","rus":"RU","rwa":"RW","lca":"LC","vct":"VC","wsm":"WS","smr":"SM","sen":"SN","syc":"SC","sle":"SL","sgp":"SG","svk":"SK","svn":"SI","slb":"SB","som":"SO","zaf":"ZA","esp":"ES","lka":"LK","sdn":"SD","sur":"SR","swz":"SZ","swe":"SE","che":"CH","tha":"TH","tgo":"TG","tkl":"TK","ton":"TO","tun":"TN","tur":"TR","tkm":"TM","tca":"TC","tuv":"TV","uga":"UG","ukr":"UA","gbr":"GB","ury":"UY","uzb":"UZ","ven":"VE","vnm":"VN","esh":"EH","zmb":"ZM","zwe":"ZW","blz":"BZ","caf":"CF","slv":"SV","irl":"IE","lbn":"LB","lie":"LI","mrt":"MR","afg":"AF","flk":"FK","ant":"AN","cog":"CG","png":"PG","sau":"SA","tjk":"TJ","are":"AE"}';
    return json_decode($countries_map, true);
  }

  protected function init() {
    parent::init();
    \beGateway\Settings::$gatewayBase = 'https://' . $this->DOMAIN_GATEWAY;
    \beGateway\Settings::$checkoutBase = 'https://' . $this->DOMAIN_PAYMENTPAGE;
    \beGateway\Settings::$shopId = $this->SHOP_ID;
    \beGateway\Settings::$shopKey = $this->SHOP_KEY;
    return parent::init();
  }
}
