# INSTRUCCIONES DE FUNCIONAMIENTO

Este proyecto ha sido creado con el framework de php Laravel. Para funcionar necesita un entorno LAMP (preferiblemente) o XAMP. Las instrucciones para instalar composer y laravel mediante composer pueden ser facilmente encontradas en internet (si fuera necesario) junto con la documentación de los comandos necesarios.

Se facilita un fichero de ejemplo para crear el "VirtualHost".

Las variables de entorno se almacenan en un fichero llamado .env en la raíz del proyecto, dicho fichero se ignora por defecto en laravel por lo que ha de ser generado, puede ser descargado de internet o usar este de prueba:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:IhsyVj4vSL8G2rszQlw/FwkwRBMl0UjYosdzHw4zBYs=
APP_DEBUG=true
APP_URL=http://localhost
APP_ENVIRONMENT=dev

LOG_CHANNEL=papertrail

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

PAPERTRAIL_URL=logs.papertrailapp.com

PAPERTRAIL_PORT_GENERAL=XXXXX

La api trabaja con tokens JWT para la autenticación de los usuarios en el front, por ello ha de ser generado mediante el comando de "php artisan jwt:secret" (en raros casos no se introduce en el fichero .env).

El sistema gestor de base de datos utilizado es MySQL (si se dispone de otro ha de ser configurado), se ha de crear una base de datos para el proyecto e introducirla en el fichero de entorno. Una vez que el proyecto cuente con acceso a ella se podrá popular la base de datos con las semillas proporcionadas, las cuales crearán 50 productos aleatorios y 6 usuarios (usuario por defecto es "drg809@gmail.es" y contraseña "secret").

Puedes probar el funcionamiento de la api mediante curl.

Se utiliza un sistema de logs llamado "PAPERTRAIL" el cual una vez configurado puede informar de los errores ocurridos mediante email, mensajería instantánea, etc.