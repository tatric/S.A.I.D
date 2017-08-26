<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
    
<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=.8">
	    <link rel="stylesheet" href="/includes/w3.css">
	    <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	    <link rel="icon" href="favicon.png" sizes="any" type="image/png">
	    <script type="application/javascript" src="/plupload/js/plupload.dev.js"></script>
	    <title>SAID File Repository</title>
	</head>
  
	<body>
	  
	<header class="w3-container w3-blue">
		<ul class="w3-navbar ">
			<li class="w3-text-shadow"><a href="?" class="w3-xlarge w3-padding-0" >S.A.I.D.</a></li>
			<li class="w3-navitem w3-padding-top">Simple Archive of Important Data</li>
			<?php if(!isset($showlogin)): ?>	
				<li >
					<form action=" " method="get">
					<input type="hidden" name="out" value="true"/>
					<input class="w3-input w3-green" type="submit"  value="Logout"/>
					</form>
				</li>
			<?php endif; ?>
			<?php if(isset($_SESSION['Admin'])): ?>
				<li >
					<form action=" " method="get">
					<input type="hidden" name="showadmin" value="true"/>
					<input class="w3-btn w3-input w3-red" type="submit"  value="Admin"/>
					</form>
				</li>
			<?php endif; ?>
			<?php if(isset($_SESSION['user'])): ?>	
				<li class="w3-light-blue w3-padding-tiny w3-small w3-navitem">
					<form action=" " method="post" enctype="multipart/form-data">
					<li class="w3-navitem">Upload a (zipped) file:</li>
					<li><input class="w3-blue w3-padding-small w3-btn" placeholder="Upload.." type="file" multiple="multiple" id="upload" name="upload"></li>
					<li><input class="w3-input w3-blue " placeholder="Description of upload.." type="text" id="desc" name="desc" maxlength="255"></li>
					<input type="hidden" name="action" value="upload">
					<li><input class="w3-input w3-blue" type="submit" value="Upload"></li>
				</form>	</li>
			<?php endif; ?>	
		</ul>
	</header>
	<body>
	<?php if(isset($error)) 	include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php'; ?>
	<?php if(isset($showlogin)) include $_SERVER['DOCUMENT_ROOT'] . '/includes/loginpage.html.php'; ?>
	<?php if(isset($files)) 	include $_SERVER['DOCUMENT_ROOT'] . '/includes/files.html.php'; ?>
	<?php if(isset($showadmin)) include $_SERVER['DOCUMENT_ROOT'] . '/includes/showadmin.html.php'; ?>
	
	</body>
	<!--Footer-->
		<footer class="w3-container w3-bottom w3-blue  w3-tiny">
		  <div class="w3-left"><P>If issues please call the service desk 03005007000</p></div>
		  <div class="w3-right"><P>Created by Rhys stevens</p></div>
		</footer>
	
</html>
	
	<script>
function myFunctionf() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("mydes");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>	
