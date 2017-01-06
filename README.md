# S.A.I.D -Simple Archiver of Important Data.
(Once said never forgotten)
https://said.domainname.some.name

**Aim**

Store large important data file that wont change and needs to be kept securely for a long time.
Store the file in two disk arrays at the same time(networked to different rooms.)
Reduce duplications of stored data. 
LDAP authentication and only show data that you have permission to see, depending on which (team) OU group you are in within the SAIDgroup OU.

**Usage**

Login with LDAP credentials.
Upload large file (zipped file of smaller files) ISO images to website interface or browse previously uploaded data. Download if required. 

**Implementation**

Virtual machine appliance containing open source software LAMP stack:

Ubuntu OS Auto update security patches.
Apache web-server Https
Mysql/maria database (daily cron dump to file for backup.)
PHP7.0 with LDAP library large upload limit.
Phpmyadmin 

**Configuration**

Open settings file and update the LDAP tree for the SAIDgroup OU and the usersOU.
Mount and set symbolic links to the storage arrays.
Upload logo.

**Additional possibilities**

* Ageing – when a file is created an age could be added of the time that the file should be deleted. E.g. Delete in 10years time.
* Cannot delete 
* Cannot view contents – only upload data and list contents.


*Created by Rhys Stevens.*
