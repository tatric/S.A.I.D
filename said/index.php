<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//Initialize session
session_start();

define('TEMPLATE', '/includes/templatemodel.html.php');
define('DATAPATH', $_SERVER['DOCUMENT_ROOT'] . '/datafolder1');
define('CONFIG', $_SERVER['DOCUMENT_ROOT'] . '/config.php');

$datapath = (DATAPATH);
if (!file_exists("$datapath")) {mkdir("$datapath", 0777);}

// check to see if user is logging out
if(isset($_GET['out'])) {
	// destroy session
	session_unset();
	$_SESSION = array();
	unset($_SESSION['user'],$_SESSION['access'],$_SESSION['ADgroups']);
	session_destroy();
}

// if user not logged in
if (!isset($_SESSION['user'])) {
	$showlogin=true;
	include("authenticate.php");
	
	//?action=view&id=17
	if(isset($_GET['action']) and ($_GET['action'] === 'view') and (isset($_GET['id']))){
		$_SESSION['filepath'] = "/?action={$_GET['action']}&id={$_GET['id']}";
	}
	
	// check to see if login form has been submitted
	if(isset($_POST['userLogin'])){
		// run information through authenticator
		if(authenticate($_POST['userLogin'],$_POST['userPassword']))
		{
			// authentication passed
			if(isset($_SESSION['filepath'])){
				echo $filepath;
				header("Location:{$_SESSION['filepath']}");
				//unset($_SESSION['filepath']);
				die();
			}
			header('Location: .');
			die();
		} else {
			// authentication failed
			if($feedback = $_SESSION['info']) {
				$info ="Login error $feedback";
				unset ($_SESSION['info']);
			}else{
				$info ="Please check your username and password.";
			}
		}
	}
	 
	// output error to user
	//if(isset($error)) $info = "Login failed: Incorrect user name, password, or rights";
	// if(isset($error)) $info = $_SESSION['info'];
	 
	//if(isset($error) and $error===1){ $error = null;}
	
	// output logout success
	if(isset($_GET['out'])) {
		
		// destroy session
		session_unset();
		$_SESSION = array();
		unset($_SESSION['user'],$_SESSION['access'],$_SESSION['ADgroups']);
		//session_destroy();
		$info ="Logout successful";
	}
	//include 'includes/template.html.php';
	include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	exit();
}

// Admin view
if(isset($_GET['showadmin']) and (isset($_SESSION['Admin']))) {
	//echo "Admin!";
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/formatbytes.inc.php';
	//show settings table (said.adgroup)
	try
	{
	  $s = $pdo->prepare("SELECT * FROM `adgroup` ORDER BY `adgroup`.`adgroup` ASC");
		$s->execute();
	}
	//print_r($row);
	catch (PDOException $e)
	{
	  $error = 'Database error fetching stored rows from the adgroup table.';
	  include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	  exit();
	}
	foreach ($s as $row){
		if (!$row){
			$error = ' Not found in the database!';
		    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    exit();
		}
		//echo "<pre>".echo($row)."</pre>";
		//echo $row;
		$showadmin[] = array(
	      'id' => $row['id'],
	      'saidgroup' => $row['adgroup'],
	      'canview' => $row['canview'],
	      'candelete' => $row['candelete'],
	      'candownload' => $row['candownload']);
	      
	}
	try
	{
	  $s = $pdo->prepare("SELECT deleteddata.id, date, dated, size, hash, filename, description, adgroup 
							FROM `deleteddata` 
							JOIN adgroup ON adgroup_id = adgroup.id
							ORDER BY `deleteddata`.`dated` ASC"
							);
      //);
		$s->execute();
	}
	//print_r($row);
	catch (PDOException $e)
	{
	  $error = 'Database error fetching stored rows from the deleted data table.';
	  include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	  exit();
	}
	foreach ($s as $row){
		if (!$row){
			$error = ' not found in the database!';
		    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    exit();
		}
		//echo "<pre>".echo($row)."</pre>";
		//echo $row;
		
		
		 $showdeleted[] = array(
	      'date' => $row['date'],
	      'dated' => $row['dated'],
	      'filename' => $row['filename'],
	      'description' => $row['description'],
	      'size' => formatBytes($row['size']),
	      'adgroup' => $row['adgroup'],
	      'hash' => $row['hash'],
	      'id' => $row['id'],
	     );
	      
	}
	$dfs=disk_free_space(DATAPATH);
	$dts=disk_total_space(DATAPATH);
	$dus=get_dir_size(DATAPATH);
	$percentdiskused=(floor(100 * $dfs / $dts));
	//show deleted files table
	include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	exit();
}

//Restore
if (isset($_POST['action']) and ($_POST['action'] == 'restore') and (isset($_POST['id'])) ){
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	  try
	  {
	    $sql = 'INSERT INTO data 
	    SELECT `id`, `hash`, `adgroup_id`, `mimetypeid`, `filename`, `description`, `size`, `date` 
	    FROM deleteddata 
	    WHERE id = :id';
	    //SELECT idmimetype FROM `mimetypedb` WHERE mimetype = idmimetype
	    $s = $pdo->prepare($sql);
	    $s->bindValue(':id', $_POST['id']);
	    //$s->bindValue(':adgroup', $adgroup);
	    $s->execute();
	    //echo"sql";
		if ($s->errorInfo) {
		    //$_SESSION['info'] = 
		    print_r($s->errorInfo());
		    //include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    //header('Location: .');
		    exit();
			}
	    
	  }
	  catch (PDOException $e)
	  {
		  if ($e->errorInfo) { //echo implode(" ",$arr);
			  
			//$arrlength = count($e->errorInfo);
			//for($x = 0; $x < $arrlength; $x++) {
			//	echo $e->errorInfo[$x];
			//	echo "<br>";
			//}
			//print_r($e->errorInfo);
		    //$error = implode (" ", $e->errorInfo);
		    //$error = $e->errorInfo[2];
		    $infof = json_encode($e->errorInfo);
		    $_SESSION['info'] = "The data has NOT been restored to the said database as this already exists for this group.";
		    $error = "      Database error updating table. ==> $infof";
		    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    header('Location: .');
		    exit();
			}
		//$_SESSION['info'] = 'The data has NOT been restored to the said database 2.';
	    $error = 'Database error updating log file.';
	    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	    exit();
	  }
	  try
	  {
	    $sql = 'DELETE FROM deleteddata WHERE id = :id';
	    $s = $pdo->prepare($sql);
	    $s->bindValue(':id', $_POST['id']);
	    //$s->bindValue(':adgroup', $adgroup);
	    $s->execute();
	  }
	  catch (PDOException $e)
	  {
	    $error = 'Database error restoring requested file.';
	    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	    exit();
	  }
	  
	  $_SESSION['info'] = 'The data has been restored to the said database.';
	  
	  header('Location: .');
	  exit();
}

$adgroup =$_SESSION['ADgroupfound'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/magicquotes.inc.php';

// Upload data
if (isset($_POST['action']) and $_POST['action'] == 'upload')
{
  	// do this for each of the mulit selected files then zip them and md5 the total.
	//foreach 
	
  // Bail out if the file isn't really an upload
  if (!is_uploaded_file($_FILES['upload']['tmp_name']))
  {
    $error = 'There was no file uploaded!';
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
  }
  $uploadfile = $_FILES['upload']['tmp_name'];
  $uploadname = $_FILES['upload']['name'];
  $uploadtype = $_FILES['upload']['type'];
  $uploaddesc = $_POST['desc'];
  
  $uploaddata = file_get_contents($uploadfile);
  $hash = md5($uploaddata);//$hash = md5(file_get_contents("$newpath"));
  
   
  #(file_get_contents("$uploadfile"))
  
  //if (file_put_contents("$datapath/$hash", $uploaddata)){
  if (move_uploaded_file( $uploadfile , "$datapath/$hash")){
	$size = filesize($uploadfile);
	include_once $_SERVER['DOCUMENT_ROOT'] .'/includes/db.inc.php';
   
  //Insert the mime type into the mimetypedb if it is not in it already
	try
	{
		$sql = 'INSERT INTO saiddb.mimetypedb SET
		mimetype = :mimetype
		ON DUPLICATE KEY UPDATE mimetype = :mimetype';
		$s = $pdo->prepare($sql);
		$s->bindValue(':mimetype', $uploadtype);
		$s->execute();
		
	}
	catch (PDOException $e)
	{
		$error = "Database error storing mimetype ERROR = " . $e->getMessage();
		include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php';
		exit();
	}
	
	//$file = $s->fetch();
	//$mimeid = $file['idmimetype'];
	//echo 'mime= '.$mimeid;
	//exit();
	
	
  try //inserting the data 
  {
    $sql = 'INSERT INTO saiddb.data SET
        adgroup_id = (SELECT id FROM saiddb.adgroup where adgroup.adgroup = :adgroup),
        date = CURTIME(),
        filename = :filename,
        mimetypeid = (SELECT idmimetype FROM saiddb.mimetypedb where mimetype = :mimetypeid),
        description = :description,
        size = :size,
        hash = :hash';        
        //ON DUPLICATE KEY UPDATE hash = :hash
        //INSERT IGNORE
    $s = $pdo->prepare($sql);
    $s->bindValue(':filename', $uploadname);
    $s->bindValue(':adgroup', $adgroup);
    $s->bindValue(':mimetypeid', $uploadtype);
    $s->bindValue(':description', $uploaddesc);
    $s->bindValue(':size', $size);
    $s->bindValue(':hash', $hash);
    $s->execute();
    
	//$lastId = $pdo->lastInsertId();#lastid = $pdo->lastInsertId()
  }
  catch (PDOException $e)
  {
	$err = $e->getMessage();
    if (isset($e->errorInfo[1]))
    {
		if ($e->errorInfo[1] == 1062) {
			
			//pull duplicate named file form its hash 
			try
			{
			  $s = $pdo->prepare(
			  // 'SELECT id, filename, mimetype, description JOIN ON mimetypeid = idmimetypedb FROM saiddb.data');
			      "SELECT filename
			       FROM saiddb.data
				   WHERE hash = :hash");
			      $s->bindValue(':hash', $hash);
			    //$s->bindValue(':adgroup', $adgroup);
				  $s->execute();
			}
			//print_r($row);
			catch (PDOException $e)
			{
			  $error = 'Database error fetching stored files duplicate name.';
			  //include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
			  //exit();
			}
			$orgfilename=$s->fetch();
			//print_r($orgfilename);
			$_SESSION['info'] = "Duplicate!  This file '$uploadname' is already in the archive as '$orgfilename[0]'.";
		    //include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    header('Location: .');
		    exit();
		}
	}
  
  //echo '<pre>';
  //print_r($e->errorInfo[1]);
  //echo '</pre>';
    $error = 'Database error storing file!  ' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
    
  }
  $_SESSION['success'] = 'The data has been loaded into the database.';
}
  
  
	
  header('Location: .');
  exit();
}

// Download or View data
if (isset($_GET['action']) and
    ($_GET['action'] == 'view' or $_GET['action'] == 'download') and
    isset($_GET['id']))
{
	
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';

  try
  {
    $sql = "SELECT hash, mimetype, filename 
			FROM saiddb.data
			JOIN mimetypedb ON data.mimetypeid = idmimetype 
			JOIN adgroup ON data.adgroup_id = adgroup.id
			WHERE adgroup_id = (SELECT id FROM saiddb.adgroup where adgroup.adgroup = :adgroup) 
			AND saiddb.data.id =:id";
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_GET['id']);
    $s->bindValue(':adgroup', $_SESSION['ADgroupfound']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Database error fetching requested file.';
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
  }

  $file = $s->fetch();
  //echo $file;
  if (!$file)
  {
    $error = 'File with specified ID not found in the database!';
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
  }

  $hash = $file['hash'];
  $mimetype = $file['mimetype'];
  $filename = $file['filename'];
  $disposition = 'inline';


  if ($_GET['action'] == 'download')
  {
    $mimetype = 'application/octet-stream';
    $disposition = 'attachment';
  }
  //check if file exists if not show warning. 
	if (!file_exists("$datapath/$hash")){
		$error = 'File with specified hash not found in the data store!';
		include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		exit();
	}
  

  // Content-type must come before Content-disposition
  header('Content-length: ' . filesize("$datapath/$hash"));
  header("Content-type: $mimetype");
  header("Content-disposition: $disposition; filename=$filename");
  readfile("$datapath/$hash");
  //include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
  //header('Location: . ');
  exit();
}

//Remove data
if (isset($_POST['action']) and $_POST['action'] == 'remove' and
    isset($_POST['id']))
{
	
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
  try
  {
    $sql = 'INSERT INTO deleteddata 
			SELECT `id`, `hash`, `adgroup_id`, `mimetypeid`, `filename`, `description`, `size`, `date`, CURTIME()
			FROM data 
			WHERE id = :id';
			//ON DUPLICATE KEY UPDATE id = :id'; this should not happen.
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    //$s->bindValue(':adgroup', $adgroup);
    $s->execute();
  }
  catch (PDOException $e)
  {
	  if ($e->errorInfo[1] == 1062) {
        $_SERVER['$info'] = "The INSERT query failed due to a key constraint violation.";
		}
	$infof = json_encode($e->errorInfo);
    $error = 'Database error updating log file.'. $infof;
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
  }
  try
  {
    $sql = 'DELETE FROM data WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    //$s->bindValue(':adgroup', $adgroup);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Database error deleting requested file.';
    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
    exit();
  }
  
  $_SESSION['info'] = 'The data has been removed from the database.';
  
  header('Location: .');
  exit();
}

// Delete data
if (isset($_POST['action']) and $_POST['action'] == 'delete' and
    isset($_POST['id']) and (isset($_SESSION['Admin'])))
{
	
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
	
	//1st check that there are no more entries in data table using this hash file before deleting the file. This is
	//to check that there are no more links form duplicates that are referencing this file. 
	try
	{
	  $d = $pdo->prepare("SELECT hash FROM data WHERE id = :id");
	    $d->bindValue(':id', $_POST['id']);
		$d->execute();
	}
	//print_r($row);
	catch (PDOException $e)
	{
	  $error = 'Database error fetching hash values to find multiple links.';
	  include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	  exit();
	}
	
	
	try //check that there is a entry in table
	{
	  $s = $pdo->prepare("SELECT hash FROM deleteddata WHERE id = :id");
	    $s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	//print_r($row);
	catch (PDOException $e)
	{
	  $error = 'Database error fetching hash value to delete.';
	  include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	  exit();
	}
	//print_r($s->fetch());
	$multiplelinks=$d->fetch();
	//$hash=$d['hash'];
	if(!$multiplelinks){ // permantly remove file
		if(unlink (DATAPATH . "/$hash")){ //if it deletes remove entry in table.
		  try
		  {
		    $sql = 'DELETE FROM deleteddata WHERE id = :id';
		    $s = $pdo->prepare($sql);
		    $s->bindValue(':id', $_POST['id']);
		    $s->execute();
		  }
		  catch (PDOException $e)
		  {
		    $error = 'Database error deleting requested file.';
		    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
		    exit();
		  }
		  $_SESSION['info'] = 'The data has been deleted from the store.';
		  header('Location: .');
		  exit();
		}else{
			$_SESSION['info'] = 'The data was NOT deleted.';
		}
	}
	try //remove this link in the recycle bin table only
	  {
	    $sql = 'DELETE FROM deleteddata WHERE id = :id';
	    $s = $pdo->prepare($sql);
	    $s->bindValue(':id', $_POST['id']);
	    $s->execute();
	  }
	  catch (PDOException $e)
	  {
	    $error = 'Database error deleting requested file.';
	    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	    exit();
	  }
	
	$_SESSION['info'] = 'There are multiple links to this file so only this link had been removed';
	//echo DATAPATH . "/$hash";
	header('Location: .');
	exit();
  
}

//show the contents of the archive for the ADgroup.

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/formatbytes.inc.php';

//insert the adgroup if not exist.
try
{
	$sql = 'INSERT INTO saiddb.adgroup SET
	adgroup = :adgroup
	ON DUPLICATE KEY UPDATE adgroup = :adgroup';
	$s = $pdo->prepare($sql);
	$s->bindValue(':adgroup', $adgroup);
	$s->execute();
	
}
catch (PDOException $e)
{
	$error = "Database error storing 'ADgroup' </ br> ERROR = " . $e->getMessage();
	include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	exit();
}



//pull all data to show
try
{
  $s = $pdo->prepare(
  // 'SELECT id, filename, mimetype, description JOIN ON mimetypeid = idmimetypedb FROM saiddb.data');
      "SELECT saiddb.data.id, filename, mimetype, description, size, candownload, candelete, canview from saiddb.data
	 JOIN mimetypedb ON data.mimetypeid = idmimetype
	 JOIN adgroup ON data.adgroup_id = adgroup.id
      WHERE adgroup_id = (SELECT id FROM saiddb.adgroup where adgroup.adgroup = :adgroup)");
      //
    $s->bindValue(':adgroup', $adgroup);
	$s->execute();
}
//print_r($row);
catch (PDOException $e)
{
  $error = 'Database error fetching stored files.';
  include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
  exit();
}

$files = array();

foreach ($s as $row){
	if (!$row){
		$error = ' not found in the database!';
	    include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
	    exit();
	}
		//echo "<pre>".echo($row)."</pre>";
	
	  $files[] = array(
	      'id' => $row['id'],
	      'filename' => $row[1],
	      'mimetype' => $row[2],
	      'description' => $row['description'],
	      'size' => formatBytes($row['size']),
	      'canview' => $row['canview'],
	      'candelete' => $row['candelete'],
	      'candownload' => $row['candownload']);
	      
}
	

include $_SERVER['DOCUMENT_ROOT'] . TEMPLATE;
unset ($_SESSION['info']);
unset ($_SESSION['success']);

