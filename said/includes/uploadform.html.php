<div id="uploader" class="w3-padding-left w3-yellow">
	<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
</div>
	
	Show Download if $f['canview'] is set<p><?php //if (isset($usertype)) {htmlout($usertype);}; ?></p>
	<div>
		<div class="w3-card-8 w3-third w3-margin-right w3-margin-left">
			<header class="w3-blue w3-padding-left"> Upload Data</header>

			<form action="" method="post" enctype="multipart/form-data" class="w3-form">
				<div>
					<label for="upload">Upload a zipped file?:
					<input class="w3-input w3-blue w3-marign" type="file" multiple="multiple" id="upload" name="upload"></label>
				</div>
				<div>
					<label for="desc">Description of upload:
					<input class="w3-input w3-border" type="text" id="desc" name="desc" maxlength="255"></label>
				</div>
				<div>
					<input type="hidden" name="action" value="upload">
					<input class="w3-right w3-btn w3-blue  w3-padding-2 w3-section" type="submit" value="Upload">
				</div>
				<br />
				<pre id="console"></pre>
			</form>
		</div>
	</div>

<div id="container">
	<a id="pickfiles" href="javascript:;">[Select files]</a>
	<a id="uploadfiles" href="javascript:;">[Upload files]</a>
</div>

