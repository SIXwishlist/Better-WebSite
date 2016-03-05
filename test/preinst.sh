#!/bin/bash
type mysql >/dev/null 2>&1 && sudo apt-get purge apache2 php5 mysql-server || echo "Warning MySQL not present. This is OK!"
sudo apt-get install -qq -y apache2 php5 mysql-server
mysqladmin -u root password test
mysql -u root -p 'test' -e 'CREATE DATABASE test'
# database should be installed now run the installer
php install.php
#End of installation
echo "Successfully installed the database files"
