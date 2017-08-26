
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>
<p class="w3-pannel w3-yellow w3-margin"><?php @ifexistsecho($_SESSION['info'])?></p>
<p class="w3-pannel w3-green w3-margin"><?php @ifexistsecho($_SESSION['success'])?></p>
<!--Show user infomation -->
<div class="w3-container w3-center w3-margin">
	<p>Hello <?php @ifexistsecho($_SESSION['user']);?>.
	 There are <?php echo count($files);?> files in the database for team <?php @ifexistsecho($_SESSION['ADgroupfound']);?>.</p>
</div>
<div class="w3-table w3-margin-bottom">
<?php if (count($files) > 0): ?>
	
	<!--Show Search boxes-->
			<input class="w3-half w3-border w3-padding w3-layout-col" type="text" placeholder="Search Filenames.." id="myInput" onkeyup="myFunctionf()">
			<input class="w3-half w3-border w3-padding w3-layout-col" type="text" placeholder="or  Search Descriptions.." id="mydes" onkeyup="myFunction()">
	<!--Show Files table -->
	<div>
	<table class="w3-table-all w3-small w3-margin-bottom" id="myTable">
		<thead>
			<tr class="w3-light-blue">
				<th>Filename</th>
				<th>Type</th>
				<th class="w3-right-align" >Size</th>
				<th>Description</th>
				<th class="w3-right"></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
	        <?php foreach($files as $f): ?>
			<tr>
				<td>
					<!--Show Download if $f['canview'] is set-->
					<?php if ($f['canview']=='true'): ?>
					<a href="?action=view&amp;id=<?php htmlout($f['id']); ?>"><?php htmlout($f['filename']); ?></a>
					<?php else: htmlout($f['filename']);
					endif ?>
				</td>
				<td><?php htmlout($f['mimetype']); ?></td>
				<td class="w3-right-align" ><?php htmlout($f['size']); ?></td>
				<td><?php htmlout($f['description']); ?></td>
				<!-- Download coloumb -->
				<td>
				<!--Show Download if $f['download'] is set-->
				<?php if ($f['candownload']=='true'): ?>
				<form action="" method="get">
					<div>
						<input type="hidden" name="action" value="download"/>
						<input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
						<input class="w3-btn w3-blue w3-right" type="submit" value="Download"/>
					</div>
				</form>
				<?php endif ?>
				</td>
				<!-- Delete coloumb -->
				<td>
				<!--Show Download if $f['delete'] is set-->
				<?php if ($f['candelete']=='true'): ?>
				<form action="" method="post">
					<div>
						<input type="hidden" name="action" value="remove"/>
						<input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
						<input class="w3-btn w3-blue" type="submit" value="Delete"/>
					</div>
				</form>
				<?php endif ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>	
