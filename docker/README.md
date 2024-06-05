# Docker-Php-Apache-MariaDB
Setup for Symfony framowork based on php 8.3 and MariaDB 11

## Getting started
Copy the .env.dist file and edit the entries to your needs:
```
cp .env.dist .env
```

Only start docker-compose to start your environment:
```
docker-compose up
```


/app/public/index.php file will bi available at localhost:80


```
After booting the container, you can use composer and the symfony cli insight the php-apache container:
```
docker exec -it -apache-php- bash
winpty docker exec -it -apache-php- bash - for windows gitbash





For install symfony (optional)
```
symfony check:requirements
composer create-project symfony/skeleton ./
```

