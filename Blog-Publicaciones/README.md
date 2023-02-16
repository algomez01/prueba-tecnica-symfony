# prueba-tecnica-symfony


# INFORMACION DEL PROYECTO:

## Nombre del proyecto:

Sistema web tipo blog para crear publicaciones

## Descripcion del proyecto:

El alcance del sistema sería el de proporcionar una plataforma web tipo blog para la empresa XYZ y sus trabajadores, donde se puedan crear publicaciones y comentarios sobre temas específicos, así como la posibilidad de visualizar publicaciones de usuarios externos a la empresa y comentar en ellas. 
El sistema permitiría a los supervisores del blog dar de baja publicaciones o comentarios que no cumplan con las políticas establecidas. 
El sistema permitiría a los trabajadores de la empresa crear publicaciones de título, cuerpo (descripción) y categoría (seleccionando una de las categorías pre-configuradas). 
El único administrador del sistema tendría la capacidad de crear y modificar las categorías, así como la creación de usuarios para los trabajadores y supervisores de la empresa.
El alcance del sistema se limita a la creación y gestión de un blog interno de la empresa, y no incluye funcionalidades más avanzadas como integración con otros sistemas, seguimiento de estadísticas de uso, integración con redes sociales, entre otras.
Además, el sistema solo permitiría el registro de personas externas para visualizar publicaciones y añadir comentarios, no permitiendo la creación de publicaciones por parte de estas personas externas. 
El sistema estaría diseñado y adaptado específicamente para cumplir con los requisitos y necesidades de la empresa XYZ.



# Requisitos Previos
- Servidor local, APACHE
- PHP
- Composer
- Scoop
- IDE o editor de Texto
> NOTA IMPORTANTE : Asegúrese de estar usando PHP 7, para ello. Para ello la instalación de composer debió realizarse sobre PHP 7.
Si no se realizó así o se duda, desinstalar y reinstalar nuevamente.

## Instalación del Servidor Local
### Apache: el servidor web de código abierto es la aplicación más usada globalmente para la entrega de contenidos web. 
Las aplicaciones del servidor son ofrecidas como software libre por la Apache Software Foundation.

Empezando a instalar un servidor local en XAMPP.
> * Descargamos el instalable desde su página web. Según la versión de vuestro Windows, seleccionaremos una u otra opción.
> * Ejecutamos el instalador. Selecciona la carpeta de instalación (normalmente c:/xampp64/).
> * Para iniciar el XAMPP., podemos hacerlo desde el menú de Inicio -> Todos los programas -> XAMPPcontrolpanel -> Start.
> * Seguramente aparezca un aviso de seguridad. Podéis decir que Sí, y se abrirá el programa.

[![Build Status](https://jarroba.com/wp-content/uploads/2012/02/instalacion-Xampp-para-windows-jarroba-0.gif)](https://jarroba.com/wp-content/uploads/2012/02/instalacion-Xampp-para-windows-jarroba-0.gif)


## Instalación de Composer
### Composer es un sistema de gestión de paquetes para programar en PHP el cual provee los formatos estándar necesarios para manejar dependencias y librerías de PHP.

Para la instalación en Windows descargaremos[Composer](https://getcomposer.org/download/)del enlace y lo instalaremos siguiendo los pasos que se indiquen.

Para comprobar su correcta instalación es mejor que cerreis el terminal si lo tenéis abierto, lo volváis a ejecutar y pongais lo siguiente en el terminal:
```sh
composer -v
```
[![Build Status](https://www.marindelafuente.com.ar/wp-content/uploads/2018/09/phpcomposer.png)](https://www.marindelafuente.com.ar/wp-content/uploads/2018/09/phpcomposer.png)

## Scoop:  
Instala los programas que conoce, desde la línea de comandos con una cantidad mínima de fricción.
### Pasos para la instalacion:
Abrir Powershell y ejecutar:
> * Set-ExecutionPolicy RemoteSigned -scope CurrentUser
> * Invoke-Expression (New-Object System.Net.WebClient).DownloadString('https://get.scoop.sh')
> * scoop install symfony-cli


# Persistencia
###  Doctrine
Una de las tareas más comunes y a la vez más complejas de la programación web consiste en la persistencia de la información en una base de datos. Afortunadamente, Symfony incluye la librería Doctrine, que proporciona herramientas para simplificar el acceso y manejo de la información de la base de datos. En este capítulo aprenderás la filosofía de trabajo de Doctrine y lo fácil que puede ser trabajar con bases de datos. Doctrine no tiene ninguna relación con Symfony y su uso es totalmente opcional. Este capítulo se centra en el ORM, que te permite manejar la información de la base de datos como si fueran objetos de PHP. También puedes realizar consultas SQL directamente, para lo cual tienes que utilizar la librería DBAL de Doctrine en vez del ORM.

## Instalación y Configuración
### Instalación

Para instalar Doctrine usamos el siguiente comando:
```sh
composer require doctrine maker
```

### Configuración
La información de conexión de la base de datos se almacena como una variable de entorno llamada DATABASE_URL. 
Para el desarrollo, podemos modificarlo dentro de .env:
```sh
# .env
###> doctrine/doctrine-bundle ###
# Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
# Configure your db driver and server_version in config/packages/doctrine.yaml
# DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
++ DATABASE_URL=mysql://root:@127.0.0.1:3306/symfony_4_test
++ # db_user: root
++ # db_password: 
++ # db_name: symfony_4_test
# to use sqlite:
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"
###< doctrine/doctrine-bundle ###
```
[![Build Status](https://miro.medium.com/v2/resize:fit:640/format:webp/1*GzS6w9CqENMqRbNEFTeYUQ.png)](https://miro.medium.com/v2/resize:fit:640/format:webp/1*GzS6w9CqENMqRbNEFTeYUQ.png)

## Framework utilizados:
### Symphony
Es un framework diseñado para desarrollar aplicaciones web basado en el patrón Modelo Vista Controlador. Para empezar, separa la lógica de negocio, la lógica de servidor y la presentación de la aplicación web.

[![Build Status](https://avatars.githubusercontent.com/u/143937?s=200&v=4)](https://avatars.githubusercontent.com/u/143937?s=200&v=4)

# Autor ✒️
- Freya Milena Lopez Lopez
