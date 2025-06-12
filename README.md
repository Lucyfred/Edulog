<h1 align="center">Edulog</h1>

🌐 Available languages: [English](README.md) | [Español](README.es.md)

<p>
  Edulog is a card management app for students on internships in companies.
</p>

## 🚀 About the Project

The objective of this project is to facilitate the monitoring of internships through a web platform that centralizes the management and sending of weekly records of interns.
<br>

## 🎯 Main functionality
Only the administrator user (super root) will be able to create or delete other users, as well as grant administrator permissions to others.

Each registered user will be able to generate and fill in his or her own weekly (or other period) internship form, based on a standard template used by public institutes.

In the future, the system will allow users to upload their own templates. An experimental functionality is envisaged to automatically detect fillable fields or to allow the user to visually select the fields directly on the document (future implementation).
<br>

## ☁️ System advantages
- Students will be able to save, edit or delete their cards from the platform without having to send them by email.

- Tutors or internship managers will have access to all their students' records in one place, always up to date.

## 💡 Origin of the idea
The idea was born in the first year of the course, when I detected a common problem in the company where I did my first internship: the students did not hand in their files on time, and the person in charge could not send them to the teacher properly. This tool aims to solve this real problem, allowing a more agile and organized follow-up of the internships.

## 🐳 Installation with Docker

This project includes a Docker configuration for easy installation and deployment.

### 📋 Requirements

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### ⚙️ Steps to raise the environment

1. Create the Dockerfile with this content:

```bash
FROM php:8.2-apache

RUN apt-get update && apt-get install -y git \
    && docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite

RUN rm -rf /var/www/html/* && git clone https://github.com/Lucyfred/Edulog.git \
/var/www/html/ && chown -R www-data:www-data /var/www/html
```

2. Create the file docker-compose.yaml with this content:<br>
⚠️ **IMPORTANT:** Do not forget to modify the data to your needs, ports and others.

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

3. Inside the folder with these files, execute the following commands:

Create the image:
```bash
docker compose build --no-cache
```

Create container:
```bash
docker compose -p edulog up -d
```

✅ The server would already be up<br>
Now you will be able to access it with your IP address (where Docker is located) and the configured port, in the default case: 8080..

## 🔐 Default credentials

These are the credentials configured by default in the containers:

### 📦 Database (MariaDB)
- **Host**: `db`
- **Port**: `3306`
- **User**: `edulog`
- **Password**: `edulog`
- **Database**: `edulog`
- **User root**: `root`
- **Root password**: `root`

### 🧭 phpMyAdmin
- **URL**: [http://localhost:8081](http://localhost:8081)
- **Server (host)**: `db`
- **User**: `root`
- **Password**: `root`

### 🌐 Web application
- **URL**: [http://localhost:8080](http://localhost:8080)

> ⚠️ **Important**: Change these credentials in production to improve security.
