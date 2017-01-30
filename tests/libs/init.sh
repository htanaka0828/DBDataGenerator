#!/bin/bash
yum -y install http://dev.mysql.com/get/mysql-community-release-el7-5.noarch.rpm
yum -y install mysql-community-server mysql mysql-devel mysql-server mysql-utilities
systemctl start mysqld.service
mysql < init.sql
