<?php

function dumpandexit($var, $name='var'){
	echo "<h2>Dump all data in $name</h2><pre>";
	print_r($var);   
	echo '</pre>';
	//exit;
	}
 
function authenticate($user, $password) {
	if(empty($user) || empty($password)) return false;
	if (!include CONFIG ){
		$_SESSION['info'] = 'Error Missing configfile';
		//header('Location: .');
		return false;
	}
	$testing = false; //true;

	// connect to active directory
	$ldap= ldap_connect($adserver); // sudo apt-get install php7.0-ldap if error unfound function.
	
	$access = false;
	
	// verify user and password
	if($bind = @ldap_bind($ldap, $user.$ldap_usr_dom, $password)) {
		// valid
		// check presence in groups
		//$filter = "(sAMAccountName=".$user.")";
		$filter = "(sAMAccountName=".$user.")";
		$attr = array("memberof");
		$result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server Error:1");
		$AllADGroupsForUser = ldap_get_entries($ldap, $result)or exit("ldap setting wrong");;
		//ldap_unbind($ldap);
		//dumpandexit($AllADGroupsForUser);
		if(!isset ($AllADGroupsForUser)){
			$error = "Unable to search LDAP server"; 
			exit;
		}
		
		if(!isset ($AllADGroupsForUser[0]['memberof'])){
			//$error = "You have not been granted access to this !!";
			//echo "not in SAID AD group!!"; 
			$_SESSION['info'] = "You are not in the SAID AD group";
			return false;
			//goto output;
			//exit;
			
		}
		// get all groups in saidgroup OU
		//$filter = "(OU=Saidgroup)";
		//$attr = array("OU");, $filter, $attr CN=rhyss,OU=saidgroup,DC=tatric,DC=co,DC=uk
		$result2 = ldap_search($ldap, $saidgroupDN, "(cn=*)") or exit("Unable to search LDAP server Error:2");
		$data = ldap_get_entries($ldap, $result2)or exit("ldap setting wrong");
		
		if(!isset ($data)){
			echo"Unable to search LDAP server"; 
			exit;
		}
		for ($i=0; $i<$data["count"]; $i++) {
            //echo "dn is: ". $data[$i]["dn"] ."<br />";
            $saidgroups[] = $data[$i]["cn"][0];
        }
		//dumpandexit($saidgroups);
		ldap_unbind($ldap);
		// check groups
		$numberofgroups=array();
		
		//cross check that users goups are in the said goups 
		foreach($AllADGroupsForUser[0]['memberof'] as $k => $grps) {
			for ($i=0; $i<$data["count"]; $i++) {
				//echo " saidgroups[i] = $saidgroups[$i] grps = $grps k = $k"; //exit; //testing
				//$str=$saidgroups[$i];
				$str="$saidgroups[$i],OU=Saidgroups";
				if(strpos($grps, $str)) { 
					//echo $str; //test 
					$numberofgroups[]=$saidgroups[$i]; 
					//break;
				}
			}
		}
		if ($numberofgroups==null) {$_SESSION['info'] = "You have not been granted permission to use this!";
			return false;
		}	
			
		// check for more then one group error. 
		foreach($numberofgroups as $group){
			if ($group=='SaidAdmin'){//else admin group!!
				$_SESSION['Admin']=true;
				#break;
			}
			$access[]=$group;
			if(isset($access[1])){
				$_SESSION['info'] = 'Error you are in two SAID groups, Please advise system administrators';
				ECHO "MORE THAN ONE SAIDGROUP";
				return false;	
			}
		}
		
		if (!isset($access)){$_SESSION['info'] = "You have not been granted permission to use this!";
			return false;
		}
		
		if ($testing == true){
			echo "\n Access = $access[0]"; //exit;
			//dumpandexit($_SESSION['ADgroups'], '$_SESSION[ADgroups]');
			dumpandexit($saidgroups, '$saidgroups');
			dumpandexit($AllADGroupsForUser[0]['memberof'],'$AllADGroupsForUser' );
			//dumpandexit($grps,'$grps');
			dumpandexit($access, '$access');
			dumpandexit($numberofgroups,'$numberofgroups');
			dumpandexit($_SESSION, '$_SESSION');
			
			exit;
		}
		
			
		if($access[0] != false) {
			// establish session variables
			$_SESSION['user'] = $user;
			/*foreach ($access as $team){
			*	$_SESSION['ADgroupfound'][] = $team;
			*}
			*/
			$_SESSION['ADgroupfound'] = $access[0];
			#dumpandexit($_SESSION, '$_SESSION');EXIT;
			
			return true;
		} else {
			// user has no rights
			$_SESSION['info'] = "You dont have permission!";
			return false;
		}
 
	} else {
		// invalid name or password
		$_SESSION['info'] = "Incorrect username and password";
		return false;
	}
}
?>
