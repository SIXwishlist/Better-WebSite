#!/bin/bash
if [ -f /etc/init.d/mysql* ]; then
    echo "Warning MySQL not present. This is still OK!"
else 
     echo "Good MySQL not present. This is OK!"
fi

mysqladmin -u root password test
mysql -u root -p 'test' -e 'CREATE DATABASE test'
# database should be installed now run the installer
php install.php
#End of installation
echo "Successfully installed the database files"
