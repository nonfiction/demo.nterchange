nterchange demo
===============

To develop locally:

    # Clone this repo and the database
    cp ./.env.sample ./.env   #then adjust to suit your environment
    ./bin/composer install
    mkdir -p ./var/{logs,ntercache,smarty_cache,templates_c}
    cd public_html && php -S localhost:8000
