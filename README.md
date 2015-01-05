nterchange demo
===============

Setup:

    # Clone this repo and the database
    cp ./.env.sample ./.env   #then adjust to suit your environment
    ./bin/composer install
    mkdir -p ./var/{logs,ntercache,smarty_cache,templates_c} ./public_html/upload
    cd public_html && php -S localhost:8000

Remote server setup is the same, with the following additions:

    # Create an apache conf if necessary...
    # chown some stuff
    sudo chown -R www-data:www-data ./var/{logs,ntercache,smarty_cache,templates_c} ./public_html/upload
    
