# Slim Framework 3 Skeleton - RestAPI

## Thanks

[akrabat - Project Skeleton Slim Framework 3](https://github.com/akrabat/slim3-skeleton)

### Technologies

* [Slim Framework 3](www.slimframework.com)
* [Monolog](https://github.com/Seldaek/monolog)
* [JWT JOSE](https://github.com/namshi/jose) in development
* [Slim 3 Skeleton](https://github.com/akrabat/slim3-skeleton)

### Database support
* [Doctrine ODM](http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/)
    * [Mongo PHP Adapter](https://github.com/alcaeus/mongo-php-adapter)
* [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html)
* [Eloquent](https://github.com/illuminate/database)
* [Moloquent](https://moloquent.github.io)
* [PDO](http://php.net/manual/pt_BR/book.pdo.php)
	
### Architecture:


sudo ifconfig lo0 alias 10.254.254.254

docker exec -it sigumoodle_webserver_1 php -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_autostart=1 -dxdebug.remote_connect_back=0  -dxdebug.remote_port=9000 -dxdebug.idekey=docker -dxdebug.remote_host=10.254.254.254  /var/www/html/phpunit --testdox --configuration /var/www/html/phpunit.xml