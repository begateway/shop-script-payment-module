## Shop-Script payment module

[Русская версия](#Модуль-оплаты-shop-script)

### Install plugin

  * Backup your webstore and database
  * Download [begateway.zip](https://github.com/BeGateway/shop-script-payment-module/raw/master/begateway.zip)
  * Unpack the archive _begateway.zip_ and upload the _begateway_ directory to the _wa-plugins/payment_ directory of your Shop-Script installation

### Add payment method

  * Open shop settings in your Webasyst backend: _Shop_ &#8594; _Settings_ &#8594; _Payment_
  * Select __beGateway__ in the drop-down menu _Add payment option__

![Add payment option](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/add-payment-option.png)

### Module configuration

At the payment module configuration:

  * Enter a name of the payment method e.g. __Pay by credit or debit card__
  * Optionally enter a description of the payment e.g. __Visa,
    Mastercard__
  * Select a default transaction type: __Payment__ or __Authorization__
  * Enter in fields _Shop Id_, _Shop secret key_ and _Payment page domain_ values received from your payment processor.

![Module configuration](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/module-configuration.png)

### You are done!

### Notes

Tested and developed with Shop-Script 6/7/8

### Demo credentials

You are free to use the settings to configure the module to process
payments with a demo gateway.

  * Shop Id __361__
  * Shop secret key __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__
  * Payment page domain __checkout.begateway.com__


### Test card details

  * Card ```4200000000000000``` to get succesful payment
  * Card ```4005550000000019``` to get failed payment
  * Card name ```JOHN DOE```
  * Card expiry date ```01/30```
  * CVC ```123```

### ERIP test service code

  * Use `99999999` to emulate test ERIP payments

### Contributing

Issue pull requests or send feature requests.

## Модуль оплаты Shop-Script

[English version](#shop-script-payment-module)

### Установка плагина

  * Создайте резервную копию вашего магазина и базы данных
  * Скачайте архив плагина [begateway.zip](https://github.com/BeGateway/shop-script-payment-module/raw/master/begateway.zip)
  * Распакуйте архив _begateway.zip_ и закачайте директорию _begateway_ из архива в директорию _wa-plugins/payment_ вашего Shop-Script

### Добавить способ оплаты

  * Откройте настройки магазина в бэкенде Вебасиста: _Магазин_ &#8594; _Настройки_ &#8594; _Оплата_
  * Выберите __beGateway__ в выпадающем списке _Добавить способ оплаты__

![Добавить способ оплаты](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/add-payment-option-ru.png)

### Настройка

На странице настройки способа оплаты:

  * Введите имя способа оплаты. Например, __Оплата банковской картой__
  * Можете добавить необязательное описание способа оплаты. Например, __Visa,
    Mastercard__
  * Выберите тип платежа: __Payment__ or __Authorization__
  * В полях _Идентификационный номер магазина_, _Секретный ключ магазина_ и _Домен платежной страницы_ введите значения, полученные от вашей платежной компании.

![Настройка способа оплаты](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/module-configuration-ru.png)

### Готово!

### Примечания

Разработанно и протестировано с Shop-Script 6/7/8

### Тестовые данные

Вы можете использовать следующие данные, чтобы настроить способ оплаты в
тестовом режиме:

  * Идентификационный номер магазина __361__
  * Секретный ключ магазина __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__
  * Домен платежной страницы __checkout.begateway.com__

#### Тестовые карты

  * Карта ```4200000000000000``` для успешной оплаты
  * Карта ```4005550000000019``` для неуспешной оплаты
  * Имя на карте ```JOHN DOE```
  * Срок действия карты ```01/30```
  * CVC ```123```

#### Тестовый код услуги ЕРИП

  * `99999999`, чтобы получить уведомление о успешной оплате через ЕРИП
