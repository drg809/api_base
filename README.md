# INSTRUCCIONES DE FUNCIONAMIENTO

Este proyecto ha sido creado con el framework de php Laravel. Para funcionar necesita un entorno LAMP (preferiblemente) o XAMP. Las instrucciones para instalar composer y laravel mediante composer pueden ser facilmente encontradas en internet (si fuera necesario) junto con la documentación de los comandos necesarios.

Se facilita un fichero de ejemplo para crear el "VirtualHost".

Las variables de entorno se almacenan en un fichero llamado .env en la raíz del proyecto, dicho fichero se ignora por defecto en laravel por lo que ha de ser generado, puede ser descargado de internet o usar este de prueba:
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:IhsyVj4vSL8G2rszQlw/FwkwRBMl0UjYosdzHw4zBYs=
APP_DEBUG=true
APP_URL=http://localhost
APP_ENVIRONMENT=dev

LOG_CHANNEL=stack

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sqs
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test
DB_USERNAME=test
DB_PASSWORD=XXXXX

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

JWT_SECRET=XXXXXXX

```
La api trabaja con tokens JWT para la autenticación de los usuarios en el front, por ello ha de ser generado mediante el comando de "php artisan jwt:secret" (en raros casos no se introduce en el fichero .env).

SGBD: MySQL. Cuenta con semillas de usuarios con datos cargados mediante la libreria faker.

Puedes probar el funcionamiento de la api mediante curl.