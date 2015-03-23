<div id="dd_cpanel" style="padding:0px 0px 25px 0px;">
<p>To export member registration data, please select a member group from the list below and any available options you wish to include.</p>
<p>It may take a few seconds up to several minutes to process the data depending on the size of your member list.</p>
</div>

<?php echo form_open('C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=dd_exportmembers'.AMP.'method=index'); ?>
<input type="hidden" name="XID" value="<?php echo XID_SECURE_HASH; ?>" />

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Select Member Groups</strong></legend>
	<p style="color:red;"><?php echo @$errmsg;?></p>
	<input type="checkbox" id="dd_all_members" name="gid" value="Yes" /> <strong>All Members</strong><br/><br/><hr/><br/>
	<p style="width:200px; float:left;">
	<?php
	$counter = 0;
	foreach($groups as $group){
	$gid = $group["group_id"];
	$glbl = $group["group_title"];
	$sel = "";
	if( in_array($gid,$groups_post) ) $sel = "checked=\"checked\"";
	?>
	<input type="checkbox" name="members[]" value="<?php echo $gid;?>" <?php echo $sel;?>/> <?php echo $glbl;?><br/><br/>
	<?php 
	$counter++;
	if($counter == 3) {
		$counter = 0;
		echo "</p><p style=\"width:200px; float:left\">";
	}} ?>
	</p>
</fieldset>

<br/><br/>

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Select Member Range</strong></legend>
	<p>Please enter positive, numeric values only.  Leave the values at zero for complete member lists.</p>
	<p style="color:red;"><?php echo @$errmsg1;?></p>
	Members Per Export<br/>
	<input type="input" id="dd_limit" name="dd_limit" value="<?php echo $limit_post;?>" size="30" /><br/><br/>

	Starting From Record #<br/>
	<input type="input" id="dd_offset" name="dd_offset" value="<?php echo $offset_post;?>" size="30" />
</fieldset>

<br/><br/>

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Select Member Fields</strong></legend>
	<p style="color:red;"><?php echo @$errmsg2;?></p>
	<input type="checkbox" id="dd_all_fields" name="all_fields" value="Yes" /> <strong>All Member Fields</strong><br/><br/><hr/><br/>
	<p style="width:200px; float:left;">
	<?php
	$counter = 0;
	foreach($fields as $field){
	$flbl = ucwords(str_replace("_"," ",$field));
	$sel = "";
	if( in_array($field,$fields_post) ) $sel = "checked=\"checked\"";
	?>
	<input type="checkbox" name="fields[]" value="<?php echo $field;?>" <?php echo $sel;?>/> <?php echo $flbl;?><br/><br/>
	<?php 
	$counter++;
	if($counter == 10) {
		$counter = 0;
		echo "</p><p style=\"width:200px; float:left\">";
	}} ?>
	</p>
</fieldset>

<br/><br/>

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Select Custom Fields</strong></legend>
	<input type="checkbox" id="dd_all_customs" name="all_custom" value="Yes" /> <strong>All Custom Fields</strong><br/><br/><hr/><br/>
	<p style="width:200px; float:left;">
	<?php
	$counter = 0;
	foreach($cfields as $field){
	$fid = $field["m_field_id"];
	$flbl = ucwords(str_replace("_"," ",$field["m_field_label"]));
	$sel = "";
	if( in_array($fid,$cfields_post) ) $sel = "checked=\"checked\"";
	?>
	<input type="checkbox" name="customs[]" value="<?php echo $fid;?>" <?php echo $sel;?>/> <?php echo $flbl;?><br/><br/>
	<?php 
	$counter++;
	if($counter == 5) {
		$counter = 0;
		echo "</p><p style=\"width:200px; float:left\">";
	}} ?>
	</p>
</fieldset>

<br/><br/>

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Select Export Format</strong></legend>
	<input type="radio" name="format" value="excel" <?php if($format == "excel"):?>checked="checked"<?php endif;?> /> Excel Spreadsheet (.xls)<br/><br/>
	<input type="radio" name="format" value="csv" <?php if($format == "csv"):?>checked="checked"<?php endif;?> /> Comma Separated Values (.csv) - Recommended for large data sets
</fieldset>

<br/><br/>

<fieldset style="padding:20px; border:#D0D7DF 2px solid;">
	<legend><strong>Save Export</strong></legend>
	<p>To save your current selections, enter an export name and select 'Save Selections and Export' below.</p>
	<p style="color:red;"><?php echo @$errmsg3;?></p>
	<strong>Export Name:</strong> <input type="text" id="dd_save_export" name="save_export" value="" style="width:300px;" />
	<input type="submit" name="save_submit" value="Save Selections and Export" class="submit" />
</fieldset>

<br/><br/><hr/><br/>

<input type="submit" name="submit" value="Export Current Selections" class="submit" />

</form>