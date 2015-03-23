<div id="dd_cpanel" style="padding:0px 0px 10px 0px;">
<p>To execute a saved export, click the title from the list below.</p>
</div>

<p style="color:red;"><?php echo @$errmsg;?></p>

<table class="mainTable" border="0" cellpadding="0" cellspacing="0">
	<thead><tr><th>ID</th><th>Export Name</th><th>Date</th><th>Limit / Offset</th><th>Columns</th><th>Type</th><th></th></tr></thead>
	<?php if( count($exports) > 0 ): ?>
	<?php foreach($exports as $export): 
	$link = $base_path.AMP.'method=load_export'.AMP.'export_id='.$export["export_id"];
	$del_link = $base_path.AMP.'method=delete_export'.AMP.'export_id='.$export["export_id"];
	?>
	<tr>
		<td><?php echo $export["export_id"];?></td>
		<td><a href="<?php echo $link;?>"><?php echo $export["export_name"];?></a></td>
		<td>Created on: <?php echo date("m/d/Y - g:i a",$export["export_date"]);?></td>
		<td><?php echo $export["export_limit"];?></td>
		<td><?php echo $export["export_columns"];?></td>
		<td><?php echo $export["export_type"];?></td>
		<td><a href="<?php echo $del_link;?>" onclick="return confirm('Are you sure?  This cannot be undone!')">Delete Export</a></td>
	</tr>
	<?php endforeach; ?>
	<?php else: ?>
	<tr>
		<td>0</td>
		<td>No saved exports were found</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php endif; ?>
</table>