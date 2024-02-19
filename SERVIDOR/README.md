# Docker Composer con servidores phyton y php conjunto a mysql y phpmyadmin.

## Descripción

Este script automatiza la creacion de dos servidores: php y phyton, la conexión a una base de datos en mysql y el acceso mediante phpmyadmin.

1. Ejecuta docker-compose build para construir tus imágenes personalizadas basadas en los Dockerfiles.
2. Luego, usa docker-compose up para iniciar todos los servicios definidos en tu docker-compose.yml.
3. Verifica que todos los servicios estén funcionando como se espera accediendo a ellos a través de los puertos expuestos.