mbbs (mobile micro bbs)
=======================

What is it?
-----------
This web application is a tiny messaging platform, focussed on private mail and
closed forum functions. The intention was to build up a local and temporary
communication platform for closed groups, e.g. for small exhibitions or 
congresses.

It's user interface is optimised for access via mobile devices and the program 
code is lightweight enough to run on cheap and tiny devices, like the Raspberry Pi.


Installation
------------
I apologize for not finishing a setup routine until now. There is some work to
do by hand. Assuming your application root is /var/www/mbbs and your webroot 
points to /var/www/mbbs/htdocs.

To install mbbs, type in the following commands:

    cd /var/www/mbbs
    git clone https://github.com/dollmetzer/mbbs.git ./
    curl -sS https://getcomposer.org/installer | php
    php composer.phar install

To setup your configuration, go to app/ and type

  mv config_dist.php config.php

Now, edit the config.php file and change the Database settings in $config->db->slave
and $config->core->name.

Make the following  directories writeable for the web server:
* ~/data/
* ~/logs/
* ~/tmp/


**Database**

To install the database go into install/ and type

    mysql -uusername -ppassword
  
    create database mbbs;
    exit;

    mysql -uusername -ppassword mbbs < schema.sql

Now you should have a working enviroment. Enter the application, and login with
the following credentials:

    name : admin
    password : admin

The first thing you should do ist change your password under "settings".
