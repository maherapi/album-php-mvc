# album-php-mvc
A simple album web app written in PHP based on TraversyMVC with some improvements 

# Getting Started

### requirements
1. You need some http server running on you machine. You can get XAMPP from [here](https://www.apachefriends.org/download.html "XAMPP Download").

### Run the app
1. clone the repo
```
   git clone https://github.com/maherapi/album-php-mvc.git
```
   
2. move the cloned repo to the htdocs in you server directory
Linux Terminal:
```
   mv album-php-mvc-master /opt/lampp/htdocs/album
```
you may have to add sudo before the command.

3. create the database. For now, two options are supported (sqlite, mysql):
- open app/config/config.php, then modify the DB constant to choose between "MYSQL" or "SQLITE".
##### sqlite
- create new database.
- open app/config/config.php, then modify the DB_PATH constant to you database file path.
##### mysql
- import the database file located in /opt/lampp/htdocs/album/maher_album_mysql.sql to your mysql.
- open app/config/config.php, then modify the database credintials to yours (DB_HOST, DB_USER, DB_PASS, DB_NAME).

4. open xampp manager, and start the mysql db and apache server.
5. go to you borwser, and hit (http://localhost/album).

You can now experiment with the app


