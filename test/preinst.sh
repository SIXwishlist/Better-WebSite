#!/bin/bash
mysqladmin -u root password test
# database should be installed now run the installer
cd test
php install.php
#End of installation
echo "Successfully installed the database files"
