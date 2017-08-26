<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
	<p class="w3-info w3-yellow"><?php @ifexistsecho($_SESSION['info']) ?></p>
   
	<?php if (count($showadmin) > 0): ?>
	<div class="w3-container w3-center w3-margin">
	<p>Hello <?php @ifexistsecho($_SESSION['user']);?>. There are <?php echo count($showadmin);?> said AD groups in the database.</p>
   	 <div class="w3-progress-container">
	  <div id="myBar" class="w3-progressbar w3-green" style="width:<?php @ifexistsecho($percentdiskused);?>%">
	    <div class="w3-center w3-text-white"> Storage1: <?php @ifexistsecho($percentdiskused);?>% Storage2: <?php @ifexistsecho($percentdiskused2);?>0%</div>
	  </div>
	</div>
   	
   	<p><?php @ifexistsecho($percentdiskused);?>% Disk free = <?php @ifexistsecho(formatBytes($dfs));?> Free space, 
		<?php @ifexistsecho(formatBytes($dts-$dfs));?> Disk used and <?php @ifexistsecho(formatBytes($dus));?> 
			S.A.I.D data stored, from a total of <?php @ifexistsecho(formatBytes($dts));?> Disk.</p>
   	</div>
    <table class="w3-table-all w3-tiny w3-margin-bottom">
      <thead>
        <tr class="w3-light-grey">
          <th>Id</th>
          <th>AD said groups</th>
          <th>Can View </th>
          <th>Can Download </th>
          <th>Can Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($showadmin as $f): ?>
        <tr>
			<td><?php htmlout($f['id']); ?></td>
			<td><?php htmlout($f['saidgroup']); ?></td>
			<td><?php htmlout($f['canview']); ?></td>
			<td><?php htmlout($f['candownload']); ?></td>
			<td><?php htmlout($f['candelete']); ?></td> 
		</tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p class="w3-container w3-center w3-margin"> Recyle bin </p>
    <table class="w3-table-all w3-small w3-margin-bottom">
      <thead>
        <tr class="w3-light-grey">
          <th>Date Added</th>
          <th>Date Deleted</th>
          <th>AD said group</th>
          <th  class="w3-right-align" >Size</th>
          <th>Filename </th>
          <th>Description</th>
          <th>Hash</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
		<?php if (isset($showdeleted)){ ?>   
	        <?php foreach($showdeleted as $f): ?>
	        <tr>
				<td><?php htmlout($f['date']); ?></td>
				<td><?php htmlout($f['dated']); ?></td>
				<td><?php htmlout($f['adgroup']); ?></td>
				<td  class="w3-right-align" ><?php htmlout($f['size']); ?></td>
				<td><?php htmlout($f['filename']); ?></td>
				<td><?php htmlout($f['description']); ?></td>
				<td><?php htmlout($f['hash']); ?></td> 
				<td>
				<!--restore button form-->
					<form action="?" method="post" >
		              <div>
		                <input type="hidden" name="action" value="restore"/>
		                <input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
		                <input class="w3-btn w3-blue w3-small w3-padding-tiny" type="submit" value="Restore"/>
		              </div>
		            </form>
	            </td>
	            <td>
					<!--Show Download if $f['delete'] is set
					<?php //if ($f['candelete']=='true'): ?><?php //endif ?>-->
					<form action="?" method="post">
						<div>
							<input type="hidden" name="action" value="delete"/>
							<input type="hidden" name="id" value="<?php htmlout($f['id']); ?>"/>
							<input class="w3-btn w3-red w3-small w3-padding-tiny" type="submit" value="Delete"/>
						</div>
					</form>
					
					</td>          
	        </tr>
	        <?php endforeach; ?>
	    <?php } ?>
      </tbody>
    </table>
    
    
    
    <?php endif; ?>

