#!/bin/bash
sudo apt-get install -qq -y apache2 php5 mysql-server
mysqladmin -u root password test
