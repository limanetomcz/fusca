#!/bin/bash

chown -R 1000:sail /var/www/html/storage
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/database
chmod -R 775 /var/www/html/public
supervisord -c /etc/supervisor/supervisord.conf

