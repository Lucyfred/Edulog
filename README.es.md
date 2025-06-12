<h1 align="center">Edulog</h1>

🌐 Available languages: [English](README.md) | [Español](README.es.md)

<p>
  Edulog es una app de gestión de fichas para los alumnos en prácticas en empresas.
</p>

## 🚀 Sobre el Proyecto

Este proyecto tiene como objetivo facilitar el seguimiento de las prácticas profesionales mediante una plataforma web que centraliza la gestión y el envío de fichas semanales de los alumnos en prácticas.
<br>

## 🎯 Funcionalidad principal
Solo el usuario administrador (super root) podrá crear o dar de baja a otros usuarios, así como otorgar permisos de administrador a otros.

Cada usuario registrado podrá generar y rellenar su propia ficha de prácticas semanal (u otro período), basada en una plantilla estándar utilizada por institutos públicos.

El sistema permitirá, en el futuro, que los usuarios puedan subir sus propias plantillas. Se contempla una funcionalidad experimental para detectar automáticamente los campos rellenables o permitir al usuario seleccionar visualmente los campos directamente sobre el documento (futura implementación).
<br>
## ☁️ Ventajas del sistema
Los alumnos podrán guardar, editar o eliminar sus fichas desde la plataforma sin necesidad de enviarlas por email.

Los tutores o encargados de prácticas tendrán acceso a todas las fichas de sus alumnos en un solo lugar, siempre actualizadas.
<br>

## 💡 Origen de la idea
La idea nació en el primer año del curso, al detectar un problema común en la empresa donde realicé mis primeras prácticas: los alumnos no entregaban sus fichas a tiempo, y el responsable no podía remitirlas al profesor adecuadamente. Esta herramienta busca solucionar ese problema real, permitiendo llevar un seguimiento más ágil y organizado de las prácticas.

## 🐳 Instalación con Docker

Este proyecto incluye una configuración con Docker para facilitar la instalación y despliegue.

### 📋 Requisitos

- Tener instalado [Docker](https://www.docker.com/) y [Docker Compose](https://docs.docker.com/compose/)

### ⚙️ Pasos para levantar el entorno

1. Crea el fichero Dockerfile con este contenido:

```bash
FROM php:8.2-apache

RUN apt-get update && apt-get install -y git \
    && docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

RUN rm -rf /var/www/html/* && git clone https://github.com/Lucyfred/Edulog.git \
/var/www/html/ && chown -R www-data:www-data /var/www/html
```

2. Crea el fichero docker-compose.yaml con este contenido:<br>
⚠️ **IMPORTANTE:** No olvides modificar los datos a tus necesidades, puertos y demás.

```bash
services:
  web:
    build: 
      context: .
    image: edulog
    container_name: edulog_web
    ports:
      - "8080:80"
    depends_on:
      - db
    restart: always
    volumes:
      - edulog_data:/var/www/html

  db:
    image: mariadb:10.5
    container_name: edulog_db
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: edulog
      MYSQL_USER: edulog
      MYSQL_PASSWORD: edulog
    ports:
      - "3306:3306"
    restart: always
    volumes:
      - ./mysql_data:/var/lib/mysql
      - edulog_data:/docker-entrypoint-initdb.d

  phpmyadmin:
    image: phpmyadmin
    container_name: edulog_phpmyadmin
    restart: always
    ports:
      - "8081:80"
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
      MYSQL_ROOT_PASSWORD: root

volumes:
  edulog_data:
```

3. Dentro de la carpeta con estos ficheros, ejecuta los siguientes comandos:

Crear la imagen:
```bash
docker compose build --no-cache
```

Crear el contenedor:
```bash
docker compose -p edulog up -d
```

✅ Ya estaría el servidor levantado<br>
Ahora podrás acceder a él con tú dirección IP (donde se localice Docker) y el puerto configurado, en el caso por defecto :8080.

## 🔐 Credenciales por defecto

Estas son las credenciales configuradas por defecto en los contenedores:

### 📦 Base de datos (MariaDB)
- **Host**: `db`
- **Puerto**: `3306`
- **Usuario**: `edulog`
- **Contraseña**: `edulog`
- **Base de datos**: `edulog`
- **Usuario root**: `root`
- **Contraseña root**: `root`

### 🧭 phpMyAdmin
- **URL**: [http://localhost:8081](http://localhost:8081)
- **Servidor (host)**: `db`
- **Usuario**: `root`
- **Contraseña**: `root`

### 🌐 Aplicación web
- **URL**: [http://localhost:8080](http://localhost:8080)

> ⚠️ **Importante**: Cambia estas credenciales en producción para mejorar la seguridad.
