<?php
$titel = "Package Change";
$PackageChange = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'PackageChange' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$queryr = mysql_query("SELECT c_id, c_name, cell FROM clients ORDER BY c_name");

$que = mysql_query("SELECT c.c_id, c.c_name, c.cell, c.address, c.p_id, p.p_name, p.p_price FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.c_id = '$cid'");
$rows = mysql_fetch_assoc($que);

$que1 = mysql_query("SELECT id, c_id, bill_amount FROM billing WHERE c_id = '$cid' ORDER BY id DESC LIMIT 1");
$rows1 = mysql_fetch_assoc($que1);


$result1=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package order by id ASC");
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Change Client Package</h5>
				</div>
				<div class="modal-body">
					<div class="row" style="height: 300px;">
						<div class="popdiv">
							<div class="col-1">Client </div>
							<div class="col-2"> 
								<select data-placeholder="Choose Client" name="cid" class="chzn-select"  style="width:280px;" onchange="submit();">
									<option value=""></option>
									<?php while ($row2=mysql_fetch_array($queryr)) { ?>
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
			<a class="btn btn-primary" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i> Change Package </a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Package Change</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
	
	<?php if($cid == ''){?>
	
		<div class="box-header">
			<h5>All Package Change</h5>
		</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
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
							<th class="head1">S/L</th>
                            <th class="head0">Received</th>
							<th class="head1">Date</th>
							<th class="head0">User ID</th>
							<th class="head1">Address</th>
							<th class="head0">Contact</th>
							<th class="head1">Previous</th>
							<th class="head0">Upgradation</th>
							<th class="head1">Upgration Date</th>
                            <th class="head0">Note</th>
							
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT p.id, e.e_name, p.ent_date, p.c_id, c.address, c.cell, pc.p_name AS a, pcc.p_name AS b, p.up_date, p.note FROM package_change AS p 
													LEFT JOIN package AS pc ON p.c_package = pc.p_id
													LEFT JOIN package AS pcc ON pcc.p_id = p.new_package
													LEFT JOIN clients AS c ON c.c_id = p.c_id
													LEFT JOIN emp_info AS e ON e.e_id = p.ent_by
													ORDER BY p.id DESC");
								$x = 1;				
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>$x</td>
											<td>{$row['e_name']}</td>
											<td>{$row['ent_date']}</td>
											<td>{$row['c_id']}</td>
											<td>{$row['address']}</td>
											<td>{$row['cell']}</td>
											<td>{$row['a']}</td>
											<td>{$row['b']}</td>
											<td>{$row['up_date']}</td>
											<td>{$row['note']}</td>
										</tr>\n ";
									$x++;	
								}  
							?>
					</tbody>
				</table>
			</div>	
		<?php }else{?>
					<div class="box-header">
						<div class="modal-content">
							<div class="modal-header">
								<h5>Client Package Change</h5>
							</div>
								<form id="form" class="stdform" method="POST" action="PackageChangeSave" enctype="multipart/form-data">
									<input type="hidden" name="c_package" value="<?php echo $rows['p_id']; ?>" />
									<input type="hidden" name="oldprice" value="<?php echo $rows['p_price'];?>" />
									<input type="hidden" name="ent_by" value="<?php echo $e_id; ?>" />
									<input type="hidden" name="ccid" value="<?php echo $cid; ?>" />
									<input type="hidden" name="bill_id" value="<?php echo $rows1['id']; ?>" />
									<input type="hidden" name="ent_date" value="<?php echo date("Y-m-d");?>" />
									<input type="hidden" name="adjustment" value="<?php echo $rows1['bill_amount'];?>" />
										<div class="modal-body">
											<p>	
												<label>Client Id</label>
												<span class="field"><input type="text" name="c_id" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['c_id'];?>" /></span>
											</p>
											<p>	
												<label>Client Name</label>
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
												<label>Current Package</label>
												<span class="field"><input type="text" name="package" id="" required="" class="input-xxlarge" readonly value="<?php echo $rows['p_name'];?> - <?php echo $rows['p_price'];?>" /></span>
											</p>
											<p>
												<label>Update/Downgrad Package</label>
												<span class="field">
													<select data-placeholder="Choose a Package" class="chzn-select" name="new_package" style="width:540px;" required="" >
														<option value=""></option>
															<?php while ($row1=mysql_fetch_array($result1)) { ?>
														<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
															<?php } ?>
													</select>
													<br /><a style= "color:red;"> Note: New bill will automatic adjustment with last month bill. To Learn More Please Call us.</a>
												</span>	
											</p>
											
											<!---<p>
												<label>Bill Adjustment</label>
												<span class="field"><input type="hidden" name="adjustment" id="" required="" class="input-xxlarge" value="<?php echo $rows1['bill_amount'];?>" />
												<br /><a style= "color:red;"> Note: Be Careful to Change This Amount. To Learn Please Call us.</a> <br /><a>If Upgrade Package => Add Extra Amount with Adjustment Amount. <br />If Downgrade Package => Minus Amount with Adjustment Amount</a>
												</span>
												
											</p>--->
											<p>
												<label>Date</label>
												<span class="field"><input type="text" name="up_date" id="" required="" class="input-xxlarge" readonly value="<?php echo date("Y-m-d");?>" /></span>
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
</script>
<style>
#dyntable_length{display: none;}
</style>