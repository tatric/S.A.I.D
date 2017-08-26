<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=.8">
	    <!--<link rel="stylesheet" href="/includes/w3.css">-->
	    <link rel="stylesheet" href="/includes/w3r.css">
	    <link rel="icon" href="favicon.png" sizes="any" type="image/png">
	    <script type="application/javascript" src="/plupload/js/plupload.dev.js"></script>
	    <style>
			.box {
				display: inline-block;
				width: 100%;
				height: 120px;
				background-color: white;
				border: 4px dashed #B5B5B5;
				color: #B5B5B5;
				font-size: 50px;
				text-align: center;
				padding: 10px;
				margin 50px;
			}
	    </style> 
	    <title>SAID File Repository</title>
	</head>
	<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>  
	<header class="w3-container w3-blue">
		<ul class="w3-navbar ">
			<li class="w3-text-shadow"><a href="?" class="w3-btn w3-light-blue w3-xlarge w3-padding-tiny w3-text-white" >S.A.I.D.</a></li>
			<li class="w3-navitem w3-padding-top">Simple Archive of Important Data</li>
			<?php if(!isset($showlogin)): ?>	
				<li >
					<form action=" " method="get">
					<input type="hidden" name="out" value="true"/>
					<input class="w3-btn w3-navitem w3-green" type="submit"  value="Logout"/>
					</form>
				</li>
			<?php endif; ?>
			<?php if(isset($_SESSION['Admin'])): ?>
				<li >
					<form action=" " method="get">
					<input type="hidden" name="showadmin" value="true"/>
					<input class="w3-btn w3-navitem w3-red" type="submit"  value="Admin"/>
					</form>
				</li>
			<?php endif; ?>
			<?php if(isset($_SESSION['user'])): ?>	
				<li>
					<!-- Trigger/Open the Modal -->
					<button onclick="document.getElementById('id01').style.display='block'"	class="w3-btn w3-light-blue w3-navitem">Upload</button>
				</li>
				<?php endif; ?>
				<!-- The Upload Modal -->
				<div id="id01" class="w3-modal">
					<div class="w3-modal-content">
					<span onclick="document.getElementById('id01').style.display='none'" class="w3-closebtn" >&times;</span>
					<!-- <div class="w3-container">
				     The Modal
				      <div class="w3-card-8">class="w3-input w3-blue"-->
						<header class="w3-blue w3-padding-left">
							<h2>Upload Data</h2>
							<p class="">many files? Zip them into a folder then upload that!</p>
						</header>
					
						<form id="myForm"  class="w3-modal-content" action=" " method="post" enctype="multipart/form-data">
							<div class=" w3-container">	
								<label for="upload"><div class="box">+</div></label>
								<input type="file" multiple="multiple" id="upload" name="upload" name="file" style="display: none;">
								<input class="w3-input w3-border w3-margin-top" placeholder="Description.." type="text" id="desc" name="desc" maxlength="255">
								<input type="hidden" name="action" value="upload" name="<?php echo ini_get("session.upload_progress.name"); ?>">
								<input class="w3-right w3-btn w3-blue w3-margin-top w3-margin-bottom" type="submit" value="Upload">
							</div>
						</form>
						<div id="progressBar"></div>
						<footer class=" w3-container">
							<div id="bar_blank" class="w3-progress-container">
								  <div id="bar_color" class="w3-progressbar w3-green">
								    <div id="status" class="w3-center w3-text-white"></div>
								  </div>
							</div><!---->
							
						</footer>
					
					</div>
				</div>			
				
		</ul>
	</header>
	<body>
	<?php if(isset($error)) 	include $_SERVER['DOCUMENT_ROOT'] . '/includes/error.html.php'; ?>
	<?php if(isset($showlogin)) include $_SERVER['DOCUMENT_ROOT'] . '/includes/loginpage.html.php'; ?>
	<?php if(isset($files)) 	include $_SERVER['DOCUMENT_ROOT'] . '/includes/files.html.php'; ?>
	<?php if(isset($showadmin)) include $_SERVER['DOCUMENT_ROOT'] . '/includes/showadmin.html.php'; ?>
	</body>
	<!--Footer-->
		<footer class="w3-container w3-bottom w3-blue w3-tiny w3-margin-top">
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
