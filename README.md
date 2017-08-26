# S.A.I.D -Simple Archiver of Important Data.
(Once said never forgotten)
https://said.domainname.some.name

**Aim**

Simple Webbased file upload and storage of files upto 8Gb.
Store large important data file that wont change and needs to be kept securely for a long time.
Store the file in two disk arrays at the same time(networked to different rooms.)(one location atm)
Reduce duplications of stored data; data is checksummed and only added once.
LDAP authentication and only show data that you have permission to see, depending on which (team) OU group you are in within the SAIDgroup OU. For example with in the SAIDgroup OU we can create a SaidServers group for the server team to store data like ISO files then the Desktop team could have there own group in the SAIDgroup OU any one in the servers team can see all the servers team files but not the Desktop teams. (Unless you are in the SAIDAdmin OU).
SaidAdmin can recover files that others have deleted to how they were. Disk space info is reported here. 

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
* Cannot delete. (creaeted: change the values on the data base for that team.)
* Cannot view contents – only upload data and list contents.(creaeted: change the values on the data base for that team.)
* Access loging. (Todo)
* Admin interface to control the above settings.(created; can view permissions, undelete deleted files, disk usage.)


*Created by Rhys Stevens.*
