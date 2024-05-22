<?php
$titel = "BReseller";
$BReseller = 'active';
include('include/hader.php');
include("conn/connection.php") ;
$type = $_GET['id'];
extract($_POST); 

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'BReseller' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

							if($cid != ''){
							$que = mysql_query("SELECT r.id, c.c_id, c.c_name, c.ip, c.cell, c.address, r.raw_download, r.raw_upload , r.youtube_bandwidth, r.total_bandwidth, r.bandwidth_price, r.youtube_price, r.discount, r.bill_amount, r.day FROM breseller AS c LEFT JOIN breseller_billing AS r ON r.c_id = c.c_id WHERE c.c_id = '$cid' ORDER BY r.id DESC LIMIT 1");
							$rows = mysql_fetch_assoc($que);
							}

							if($type == '' || $type == 'all'){
							$sql = mysql_query("SELECT t1.c_id, t1.ip, t2.raw_download, t2.raw_upload, t2.youtube_bandwidth, t2.total_bandwidth, t2.bandwidth_price, t2.youtube_price, t2.discount, t1.c_name, t1.c_id, t1.address, t1.cell, t1.note, t1.join_date, t1.con_sts, t1.log_sts, t2.bill_amount FROM
												(SELECT c.c_name, c.ip, c.c_id, c.address, c.cell, c.note, c.join_date, c.con_sts, l.log_sts FROM breseller AS c
												LEFT JOIN login AS l ON l.e_id = c.c_id	WHERE c.sts = '0' ORDER BY c.id DESC)t1
												LEFT JOIN
												(SELECT r.c_id, r.raw_download, r.raw_upload , r.youtube_bandwidth, r.total_bandwidth, r.bandwidth_price, r.youtube_price, r.discount, r.bill_amount, r.day FROM breseller_billing AS r WHERE r.sts = '0'
												GROUP BY r.id )t2
												ON t1.c_id = t2.c_id");
												
							$sqlqq = mysql_query("SELECT * FROM breseller WHERE sts = '0' AND con_sts = 'Active' ORDER BY id DESC");
							$sqls = mysql_query("SELECT c_id FROM breseller WHERE sts = '0' AND con_sts = 'Active'");
							$sqlss = mysql_query("SELECT c_id FROM breseller AS c LEFT JOIN login AS l ON l.e_id = c.c_id WHERE c.sts = '0' AND l.log_sts = '1'");
							$tot = mysql_num_rows($sql);
							$act = mysql_num_rows($sqls);
							$loc = mysql_num_rows($sqlss);
							$inact = $tot - $act;
							
							$tit = "<div class='box-header'>
										<div class='hil'> Total:  <i style='color: #317EAC'>{$tot}</i></div> 
										<div class='hil'> Active:  <i style='color: #30ad23'>{$act}</i></div> 
										<div class='hil'> Inactive: <i style='color: #e3052e'>{$inact}</i></div> 
										<div class='hil'> Lock: <i style='color: #f66305'>{$loc}</i></div>
									</div>";
							}
							
							
							if($type == 'active'){
							$sql = mysql_query("SELECT t1.c_id, t1.ip, t2.raw_download, t2.raw_upload, t2.youtube_bandwidth, t2.total_bandwidth, t2.bandwidth_price, t2.youtube_price, t2.discount, t1.c_name, t1.c_id, t1.address, t1.cell, t1.note, t1.join_date, t1.con_sts, t1.log_sts, t2.bill_amount FROM
												(SELECT c.c_name, c.ip, c.c_id, c.address, c.cell, c.note, c.join_date, c.con_sts, l.log_sts FROM breseller AS c
												LEFT JOIN login AS l ON l.e_id = c.c_id	WHERE c.sts = '0' AND c.con_sts = 'Active' ORDER BY c.id DESC)t1
												LEFT JOIN
												(SELECT r.c_id, r.raw_download, r.raw_upload , r.youtube_bandwidth, r.total_bandwidth, r.bandwidth_price, r.youtube_price, r.discount, r.bill_amount, r.day FROM breseller_billing AS r WHERE r.sts = '0'
												GROUP BY r.id )t2
												ON t1.c_id = t2.c_id");
							$tot = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Active Clints:  <i style='color: #30ad23'>{$tot}</i></div>
									</div>";
							}
							
							
							if($type == 'inactive'){
							$sql = mysql_query("SELECT t1.c_id, t1.ip, t2.raw_download, t2.raw_upload, t2.youtube_bandwidth, t2.total_bandwidth, t2.bandwidth_price, t2.youtube_price, t2.discount, t1.c_name, t1.c_id, t1.address, t1.cell, t1.note, t1.join_date, t1.con_sts, t1.log_sts, t2.bill_amount FROM
												(SELECT c.c_name, c.ip, c.c_id, c.address, c.cell, c.note, c.join_date, c.con_sts, l.log_sts FROM breseller AS c
												LEFT JOIN login AS l ON l.e_id = c.c_id	WHERE c.sts = '0' AND c.con_sts = 'Inactive' ORDER BY c.id DESC)t1
												LEFT JOIN
												(SELECT r.c_id, r.raw_download, r.raw_upload , r.youtube_bandwidth, r.total_bandwidth, r.bandwidth_price, r.youtube_price, r.discount, r.bill_amount, r.day FROM breseller_billing AS r WHERE r.sts = '0'
												GROUP BY r.id )t2
												ON t1.c_id = t2.c_id");
							$inact = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Inactive Clints: <i style='color: #e3052e'>{$inact}</i></div> 
									</div>";
							}
							if($type == 'lock'){
							$sql = mysql_query("SELECT t1.c_id, t1.ip, t2.raw_download, t2.raw_upload, t2.youtube_bandwidth, t2.total_bandwidth, t2.bandwidth_price, t2.youtube_price, t2.discount, t1.c_name, t1.c_id, t1.address, t1.cell, t1.note, t1.join_date, t1.con_sts, t1.log_sts, t2.bill_amount FROM
												(SELECT c.c_name, c.ip, c.c_id, c.address, c.cell, c.note, c.join_date, c.con_sts, l.log_sts FROM breseller AS c
												LEFT JOIN login AS l ON l.e_id = c.c_id	WHERE c.sts = '0' AND l.log_sts = '1' ORDER BY c.id DESC)t1
												LEFT JOIN
												(SELECT r.c_id, r.raw_download, r.raw_upload , r.youtube_bandwidth, r.total_bandwidth, r.bandwidth_price, r.youtube_price, r.discount, r.bill_amount, r.day FROM breseller_billing AS r WHERE r.sts = '0'
												GROUP BY r.id )t2
												ON t1.c_id = t2.c_id");
							$locks = mysql_num_rows($sql);
							$tit = "<div class='box-header'>
										<div class='hil'> Total Lock Clints: <i style='color: #f66305'>{$locks}</i></div>
									</div>";
							}
?>

<script type="text/javascript">
function updatesum() {
document.form.total_bandwidth.value = (document.form.raw_download.value -0) + (document.form.raw_upload.value -0) + (document.form.youtube_bandwidth.value -0);
document.form.bill_amount.value = (document.form.bandwidth_price.value -0) + (document.form.youtube_price.value -0);
}
</script>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Update Reseller Rate</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<div class="popdiv">
							<div class="col-1">Reseller </div>
							<div class="col-2"> 
								<select data-placeholder="Choose Reseller" name="cid" class="chzn-select"  style="width:280px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row2=mysql_fetch_array($sqlqq)) { ?>
									<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['cell']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
		<div class="searchbar">
			<a class="btn btn-primary" href="BResellerAdd"><i class="iconfa-plus"></i> Add</a>
			<a class="btn btn-neveblue" href="#myModal" data-toggle="modal"> Change Bandwidth</a>
			<a class="btn btn-green" href="BReseller?id=active"><i class="iconfa-ok"></i> Active</a>
			<a class="btn btn-red" href="BReseller?id=inactive"><i class="iconfa-warning-sign"></i> Inactive</a>
			<a class="btn btn-danger" href="BReseller?id=lock"><i class="iconfa-lock"></i> Lock</a>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Bandwidth Reseller</h1>
        </div>
    </div><!--pageheader-->
			<?php if($sts == 'Update') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Updated in Your System. <?php if($sentsms=='Yes'){?> One SMS Has Been Sent Too.<?php } ?>
			</div><!--alert-->
		<?php } if($sts == 'add') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.
			</div><!--alert-->
		<?php } if($sts == 'Lock0') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Locked in Your System.
			</div><!--alert-->
		<?php } if($sts == 'Lock1') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Unlocked in Your System.
			</div><!--alert-->
		<?php } if($sts == 'StatusActive') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Inactive in Your System.
			</div><!--alert-->
		<?php } if($sts == 'StatusInactive') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Active in Your System.
			</div><!--alert-->
		<?php } if($sts == 'smssent') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Send The SMS.
			</div><!--alert-->
		<?php } if($sts == 'edit') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.
			</div><!--alert-->
		<?php } ?>
		
	<div class="box box-primary">
		<?php if($cid == ''){?>
		<div class="box-header">
			<h5><?php echo $tit; ?></h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
                        <col class="con1" />
						<col class="con0" />
						<col class="con1" />												
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">ID</th>
                            <th class="head0">ID/Name/Cell</th>
							<th class="head1">Address/IP</th>
							<th class="head0 center">Joining</th>
							<th class="head1 center">Note</th>
							<th class="head0 center">Bandwidth</th>
							<th class="head1 center">Price</th>
							<th class="head0 center">Status</th>
                            <th class="head1 center">Action</th>
							
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['con_sts'] == 'Active'){
										$clss = 'act';
										$dd = 'Inactive';
										$ee = 'Active';
									}
									if($row['con_sts'] == 'Inactive'){
										$clss = 'inact';
										$dd = 'Active';
										$ee = 'Inactive';
									}
									if($row['log_sts'] == '0'){
										$aa = 'btn col2';
										$bb = "<i class='iconfa-unlock'></i>";
										$cc = 'Lock';
									}
									if($row['log_sts'] == '1'){
										$aa = 'btn col3';
										$bb = "<i class='iconfa-lock pad4'></i>";
										$cc = 'Unlock';
									}
									echo
										"<tr class='gradeX'>
											<td class='center'>$x</td>
											<td><b>{$row['c_id']}</b><br>{$row['c_name']}<br>{$row['cell']}</td>
											<td>{$row['address']}<br><b>[{$row['ip']}]</b></td>
											<td class='center'>{$row['join_date']}</td>
											<td class='center'>{$row['note']}</td>
											<td class='center'>D: {$row['raw_download']} + U: {$row['raw_upload']} + Y: {$row['youtube_bandwidth']} = <b>{$row['total_bandwidth']}mb</b></td>
											<td class='center'>R: {$row['bandwidth_price']} + Y: {$row['youtube_price']} = <b>{$row['bill_amount']}tk</b></td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='ResellerStatus?id=",$id,"{$row['c_id']}' data-original-title='{$dd}' class='btn {$clss}' onclick='return checksts()'>{$ee}</a></li>
												</ul>
											</td>	
											<td class='center' style='width: 210px !important;'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='BResellerView?id=",$id,"{$row['c_id']}' data-original-title='View Client' class='btn col1'><i class='fa iconfa-eye-open'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='BResellerSMS?id=",$id,"{$row['c_id']}' data-original-title='Send SMS' class='btn col1'><i class='iconfa-comment'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='BResellerLock?id=",$id,"{$row['c_id']}' data-original-title='{$cc}' class='{$aa}' onclick='return checkLock()'>{$bb}</a></li>
													<li><a data-placement='top' data-rel='tooltip' href='BResellerEdit?id=",$id,"{$row['c_id']}' data-original-title='Edit' class='btn col1'><i class='iconfa-edit'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='BResellerDelete?id=",$id,"{$row['c_id']}' data-original-title='Delete' class='btn col5' onclick='return checkDelete()'><i class='iconfa-trash'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>	
<?php }else{
$dayy = date('d');?>
					<div class="box-header">
					<?php if($dayy != 31){?>
						<div class="modal-content">
							<div class="modal-header">
								<h5>Update Reseller Rate</h5>
							</div>
								<form id="form" class="stdform" method="POST" name="form" action="BResellerPriceChangeSave" enctype="multipart/form-data">
									<input type="hidden" name="bill_id" value="<?php echo $rows['id'];?>" />
									<input type="hidden" name="celll" value="<?php echo $rows['cell'];?>" />
									<input type="hidden" name="ent_by" value="<?php echo $e_id; ?>" />
									<input type="hidden" name="day" value="<?php echo $rows['day'];?>" />
									<input type="hidden" name="adjustment" value="<?php echo $rows['bill_amount'];?>" />
									<input type="hidden" name="ent_date" value="<?php echo date('Y-m-d', time());?>" />
				
										<div class="modal-body">
											<p>	
												<label>Reseller ID</label>
												<span class="field"><input type="text" name="c_id" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['c_id'];?>" /></span>
											</p>
											<p>	
												<label>Reseller Name</label>
												<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['c_name'];?>" /></span>
											</p>
											<p>
												<label>Address</label>
												<span class="field"><textarea type="text" name="address" id="" class="input-xxlarge" readonly /><?php echo $rows['address'];?></textarea></span>
											</p>
											<p>
												<label>Contact</label>
												<span class="field"><input type="text" name="cont" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['cell'];?>" /></span>
											</p>
											
											<p>
												<label>Current Bandwidth</label>
												<span class="field"><input type="text" readonly name="old_raw_download" style="width: 135px;" placeholder="Download" class="input-large" value="<?php echo $rows['raw_download'];?>" />&nbsp;&nbsp;<input type="text" readonly name="old_raw_upload" style="width: 135px;" placeholder="Upload" class="input-large" value="<?php echo $rows['raw_upload'];?>"/>&nbsp;&nbsp;<input type="text" name="old_youtube_bandwidth" style="width: 135px;" readonly placeholder="" class="input-large" value="<?php echo $rows['youtube_bandwidth'];?>" />&nbsp;<input type="text" name="old_total_bandwidth" readonly placeholder="Total" style="width: 60px;" value="<?php echo $rows['total_bandwidth'];?>" /> <b>mb</b></span>
											</p>
											<p>
												<label>Current Price</label>
												<span class="field"><input type="text" readonly name="old_bandwidth_price" placeholder="Raw Price" id="" class="input-large" value="<?php echo $rows['bandwidth_price'];?>" />&nbsp;&nbsp;<input type="text" name="old_youtube_price" readonly id="" class="input-large" value="<?php echo $rows['youtube_price'];?>" />&nbsp;<input type="text" name="old_bill_amount" readonly placeholder="Total" id="" style="width: 60px;" value="<?php echo $rows['bill_amount'];?>"> <b>TK</b></span>
											</p>
											<p>
												<label>New Bandwidth</label>
												<span class="field"><input type="text" name="raw_download" style="width: 135px;" placeholder="Download" required="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="raw_upload" style="width: 135px;" required="" placeholder="Upload" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_bandwidth" style="width: 135px;" required="" placeholder="YouTube Bandwidth" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="total_bandwidth" readonly placeholder="Total" style="width: 60px;" onChange="updatesum()" /> <b>mb</b></span>
											</p>
											<p>
												<label>New Price</label>
												<span class="field"><input type="text" required="" name="bandwidth_price" placeholder="Raw Price" id="" class="input-large" onChange="updatesum()" />&nbsp;&nbsp;<input type="text" name="youtube_price" required="" placeholder="YouTube Price" id="" class="input-large" onChange="updatesum()" />&nbsp;<input type="text" name="bill_amount" readonly placeholder="Total" id="" style="width: 60px;" onChange="updatesum()" /> <b>TK</b></span>
											</p>
											<p>
												<label>This Month Bill Calculation</label>
												<span class="formwrapper">
												   <input type="radio" name="calculation" value="Auto"> Auto &nbsp; &nbsp;
												   <input type="radio" name="calculation" value="Manual" checked="checked"> Manual &nbsp; &nbsp;
												</span>
											</p>
											<p>
												<label>Send Update SMS</label>
												<span class="formwrapper">
													<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
													<input type="radio" name="sentsms" value="No" checked="checked"> No &nbsp; &nbsp;
												</span>
											</p>
											<p>
												<label>Date</label>
												<span class="field"><input type="text" name="up_date" id="" required="" readonly class="input-xxlarge" value="<?php echo date("Y-m-d");?>" /></span>
											</p>
											<p>
												<label>Note</label>
												<span class="field"><textarea type="text" name="note" placeholder="Note........" id="" class="input-xxlarge" /></textarea></span>
											</p>
										</div>
										<div class="modal-footer">
											<button type="reset" class="btn">Reset</button>
											<button class="btn btn-primary" type="submit">Submit</button>
										</div>
								</form>		
							</div>
									<?php } else{?>
									<h3> </h3><br />
									
									<div class="alert alert-block">
									  <button data-dismiss="alert" class="close" type="button">&times;</button>
									  <h4>Warning!!!</h4><br />
									  <p>Sorry today is the last day of this month. Today you are not able to Update Reseller Rate.</p><br />
									  <strong>Please Try Tomorrow.</strong>
									</div><!--alert-->
									<?php } ?>	
						
					</div>
		<?php } ?>			
	</div>

<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
                                    
        //Replaces data-rel attribute to rel.
        //We use data-rel because of w3c validation issue
        jQuery('a[data-rel]').each(function() {
            jQuery(this).attr('rel', jQuery(this).data('rel'));
        });
        
        // tooltip sample
	if(jQuery('.tooltipsample').length > 0)
		jQuery('.tooltipsample').tooltip({selector: "a[rel=tooltip]"});
		
	jQuery('.popoversample').popover({selector: 'a[rel=popover]', trigger: 'hover'});
        
    });
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}

function checksts(){
    return confirm('Change connection status!!  Are you sure?');
}

function checkLock(){
    return confirm('Are you sure?  Do u know what are you doing?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>