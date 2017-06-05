# TwitterClone
A twitter clone, written in PHP7 + MariaDB/MySQL 

## Overview
This app is a simple twitter clone using PHP7, jQuery, and MariaDB/MySQL.

## Login
As per the project specifications, only a single user is implemented. However, based on the structure
of the app, more users could be easily added manually in the database, or through a future interface.

To log in, use the following credentials:

 * User: user1
 * Password: user1password

## DB Credentials
DB credentials are provided by environment variables. Example database content can be found in db.sql for 
instantiating your own database server.

To configure the app, set the following environment variables:
  * DB_HOST
  * DB_NAME
  * DB_USER
  * DB_PASS

## DB Permissions
Minimally, the only database permissions which are required are `SELECT`, and `INSERT`. However, for future 
expandability, I suggest providing `UPDATE` and `DELETE` as well.