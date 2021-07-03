# Tsama
This is still a work in progress (WIP)

Tsama is a lightweight php framework/cms in the early stages of development.

The name tsama comes from the tsama melon of the Namib and Kalahari deserts from my country, Namibia. Tsama signify the life that is available for free to those that roam these deserts. In the same way, Tsama code is available for free to all that roam the internet.

# Intro
The idea is to have multiple services running within a lightweight framework. As an example a page is ran as a service with a pageworker handling certain things such as keeping a catalogs of articles.

# PHP8 Compatibility
Even though Tsama was written in the time of PHP6/7; Tsama works in PHP8

# Example Apache2 vhosts Config
```
<VirtualHost *:80>
        ServerName tsama.dev.local
        ServerAdmin webmaster@localhost
        DocumentRoot /var/www/html/tsama.dev.local/Tsama/src/php

        ErrorLog ${APACHE_LOG_DIR}/tsama.dev.local-error.log
        CustomLog ${APACHE_LOG_DIR}/tsama.dev.local-access.log combined
        <Directory /var/www/html/tsama.dev.local/Tsama/src/php>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
        </Directory>
</VirtualHost>
```
