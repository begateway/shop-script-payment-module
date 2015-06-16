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
  * Optionally enter a description of the payment e.g. __VISA,
    MasterCard__
  * Select a default transaction type: __Payment__ or __Authorization__
  * Enter in fields _Shop Id_, _Shop secret key_, _Payment gateway domain_ and _Payment page domain_ values received from your payment processor.

![Module configuration](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/module-configuration.png)

### You are done!

### Notes

Tested and developed with Shop-Script 6

### Demo credentials

You are free to use the settings to configure the module to process
payments with a demo gateway.

  * Shop Id __361__
  * Shop secret key __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__
  * Payment gateway domain __demo-gateway.begateway.com__
  * Payment page domain __checkout.begateway.com__


Use the test data to make a test payment:

  * card number __4200000000000000__
  * card name __John Doe__
  * card expiry month __01__ to get a success payment
  * card expiry month __10__ to get a failed payment
  * CVC __123__

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
  * Можете добавить необязательное описание способа оплаты. Например, __VISA,
    MasterCard__
  * Выберите тип платежа: __Payment__ or __Authorization__
  * В полях _Идентификационный номер магазина_, _Секретный ключ магазина_, _Домен платежного шлюза_ и _Домен платежной страницы_ введите значения, полученные от вашей платежной компании.

![Настройка способа оплаты](https://github.com/BeGateway/shop-script-payment-module/raw/master/doc/module-configuration-ru.png)

### Готово!

### Примечания

Разработанно и протестированно с Shop-Script 6

### Тестовые данные

Вы можете использовать следующие данные, чтобы настроить способ оплаты в
тестовом режиме:

  * Идентификационный номер магазина __361__
  * Секретный ключ магазина __b8647b68898b084b836474ed8d61ffe117c9a01168d867f24953b776ddcb134d__
  * Домен платежного шлюза __demo-gateway.begateway.com__
  * Домен платежной страницы __checkout.begateway.com__


Используйте следующий тестовый набор для тестового платежа:

  * номер карты __4200000000000000__
  * имя на карте __John Doe__
  * месяц срока действия карты __01__, чтобы получить успешный платеж
  * месяц срока действия карты __10__, чтобы получить неуспешный платеж
  * CVC __123__
