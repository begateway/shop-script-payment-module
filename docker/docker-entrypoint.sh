#!/bin/bash

set -e

if [ -d "/var/www/html/wa-plugins/payment/" ]; then
  ln -s /begateway /var/www/html/wa-plugins/payment/begateway
fi

/usr/local/bin/apache2-foreground

exec "$@"
