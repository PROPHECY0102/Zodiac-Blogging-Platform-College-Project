# Zodiac Blogging Platform

## A Dynamic Web Application for Publishing Blogs

### Preliminary Requirements to Launch Zodiac Locally on Your Working Environment

### 1. Setting up XAMPP and Virtual Host

Run Notepad as Administrator
Open File From this Path

> C:\Windows\System32\Drivers\etc\hosts  
> (hosts file is not a .txt file enable view all files bottom right)

Paste This Text into the hosts file and save

```
127.0.0.1 localhost
127.0.0.1 zodiac.test
```

Open this File with your editor of choice

> C:/xampp/apache/conf/extra/httpd-vhosts.conf

Paste This Text into httpd-vhosts.conf

```
#ZODIAC
<VirtualHost *:80>
    ServerName zodiac.test
    DocumentRoot "C:/xampp/htdocs/zodiac/public"
    <Directory "C:/xampp/htdocs/zodiac/public">
        Options Indexes FollowSymLinks Includes execCGI
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Open XAMPP as administration and restart the Apache Server and MySQL

### 2. Setting up MySQL Environment for Zodiac

Go to PhpMyAdmin's User Account  
Create New User Account

Username:

> Zodiac

Password:

> password123

Database name use same name as Username

If DB name has a lower case "z" like "zodiac" instead of "Zodiac" then go to working directory find a file called ".env"

> zodiac/.env

and find and change this entry

```
DB_DATABASE=zodiac
```

Go to the working directory in CMD

> C:/xampp/htdocs/zodiac

Type the following to migrate and seed database schema

```
php artisan migrate:refresh --seed
```
