# WORKFLOW APROBACION DE CONTENIDO

# Instalar contenido del workflow
- composer install
- php artisan migrate --seed

# Si es de preferencia utilizar docker correr el siguiente comando

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

Una vez descargado los archivos de instalacion

cp .env.example a .env

./vendor/bin/sail up
