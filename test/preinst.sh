#!/bin/bash
if [ -f /etc/init.d/mysql* ]; then
    echo "Warning MySQL not present. This is still OK!"
    sudo apt-get purge apache2 php5 mysql-server 
else 
     echo "Good MySQL not present. This is OK!"
fi

sudo apt-get install -qq -y apache2 php5 mysql-server
mysqladmin -u root password test
mysql -u root -p 'test' -e 'CREATE DATABASE test'
# database should be installed now run the installer
php install.php
#End of installation
echo "Successfully installed the database files"
