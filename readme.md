Nginx config
----------
```$xslt
server {
    listen [::]:80;
    server_name  tester.local;
    root   /www/tester/public;

    access_log /www/tester/logs/server/access.log;
    error_log /www/tester/logs/server/error.log;

    charset utf-8;

    location / {
        index index.html index.php;
        try_files $uri $uri/ /$is_args?$args;
        #try_files $uri /index.php$is_args$args;
    }

    location ~ ^/assets/.*\.php {
        deny all;
    }

    location ~ \.php {
        include fastcgi_params;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_index  index.php;
        try_files $uri = 404;
    }
}
```

App configuration (DB connection)
/app/config/config.php

DB dump
/resources/sql/testerdb.sql

php.ini short_tags: On;

npm and gulp is not necessary. It was used for scss compiling

Vendor files are included, not necessary to do composer update. 