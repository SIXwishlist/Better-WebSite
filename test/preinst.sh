#!/bin/bash
sudo apt-get purge mysql-server 
sudo apt-get install mysql-server 
mysqladmin -u root password test
mysql -u root -p 'test' -e 'CREATE DATABASE test'
# database should be installed now run the installer
php install.php
#End of installation
echo "Successfully installed the database files"
