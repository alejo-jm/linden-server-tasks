linden-server-tasks
=======================

Prueba de tecnología

Este es el servicio backend para la creacion/edicion/eliminada de tareas.
funciona en un servidor que tenga instalado: 
- Apache 2
- PHP5.2+
- MySQl5+

Los modulos mas importantes del apache para el servicio son:
- mod_rewrite

Los archivos para la creacion de la base de datos, se encuetran en al
raiz de proyecto dentro del directorio "sql", el archivo de conexión
con la base de datos /app/Config/database.php


El servicio del backend debe estar en instalado en un virtual host del apache
para que todo funcione bien.

La url donde pueden el servicio funcionando es:
http://servertasks.alejojm.net/