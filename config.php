<?php

// Active Directory server
$adserver = 'ad.server.domain.uk';  // '10.181.8.11'; #10.181.8.12 10.181.8.13';

// Active Directory DN
$ldap_dn = 'OU=Users,DC=server,DC=domain,DC=uk';

// Domain, for purposes of constructing $user
$ldap_usr_dom = '@ad.server.domain.uk';

// Said goup DN 
$saidgroupDN ='OU=Saidgroups,OU=Application Groups,OU=Groups,DC=server,DC=domain,DC=uk';

// DATABASE settings
$database='mysql:host=localhost;dbname=saiddb';
$databaseuser='dbusername';
$databasepass='dbpassword';


?>
