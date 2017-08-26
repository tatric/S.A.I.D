
<?php include_once $_SERVER['DOCUMENT_ROOT'] .'/includes/helpers.inc.php'; ?>

<div class="w3-card-8 w3-third w3-border w3-margin">
	<header class="w3-header w3-blue w3-large w3-padding">Please login</header>
	<div class="w3-container w3-yellow"><?php if (isset($info)) {htmlout($info);}; ?></div>
	<form action="." method="post" class="w3-form">
		<div>Username: <input class="w3-input w3-border" type="text" name="userLogin" autofocus /><br /></div>
		<div>Password: <input class="w3-input w3-border" type="password" name="userPassword" /></div>
		<input class="w3-section w3-btn w3-right w3-blue" type="submit" name="submit" value="Submit" />
	</form>
</div>
