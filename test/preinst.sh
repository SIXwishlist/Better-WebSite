#!/bin/bash
sudo apt-get install -qq -y apache2 php5 mysql-server
mysqladmin -u root password test
mysql -u root -p 'test' -e 'CREATE DATABASE test'
# database should be installed now run the installer
curl localhost/install/database.php?test
