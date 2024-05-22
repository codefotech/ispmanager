<?php
$titel = "Fiber Store Out";
$Store = 'active';
include('include/hader.php');
$st_id = $_GET['pid'];
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(192, $access_arry)){
//---------- Permission -----------
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn ownbtn3" href="Fiber">Fiber Details</a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h2>Fiber Out Details</h1>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'delete') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
			</div><!--alert-->
		<?php } if($sts == 'add') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added from Your System.
			</div><!--alert-->
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header">
				Fiber Out Details
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head1 center">S/L</th>
							<th class="head0">Out Date</th>
							<th class="head1">Product/SL</th>
							<th class="head1 center">Cable Size</th>
							<th class="head0 center">Qty of Out</th>
							<th class="head1">Out by</th>
							<th class="head1">Client</th>
							<th class="head0">Responsible</th>
							<th class="head1">Note</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($st_id == ''){
							$sql = mysql_query("SELECT o.id, o.st_id, i.brand, i.fiber_id, c.c_name, c.c_id, c.cell, i.p_id, f.pro_name, i.p_sl_no, i.fibertotal, o.qty, DATE_FORMAT(o.out_date, '%D %M %Y') AS out_date, e.e_name AS outby, z.e_name AS receiveby, o.note FROM store_out_fiber AS o
													LEFT JOIN store_in_out_fiber AS i
													ON i.id = o.st_id
													LEFT JOIN fiber AS f
													ON f.id = i.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS z
													ON z.e_id = o.receive_by
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													ORDER BY i.id DESC");
						}
						else{
							$sql = mysql_query("SELECT o.id, o.st_id, i.brand, c.c_name, c.c_id, c.cell, i.fiber_id, i.p_id, f.pro_name, i.p_sl_no, i.fibertotal, o.qty, DATE_FORMAT(o.out_date, '%D %M %Y') AS out_date, e.e_name AS outby, z.e_name AS receiveby, o.note FROM store_out_fiber AS o
													LEFT JOIN store_in_out_fiber AS i
													ON i.id = o.st_id
													LEFT JOIN fiber AS f
													ON f.id = i.p_id
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN clients AS c
													ON c.c_id = o.c_id
													LEFT JOIN emp_info AS z
													ON z.e_id = o.receive_by WHERE i.p_id = '$st_id'
													ORDER BY i.id DESC");
						}
								while( $row = mysql_fetch_assoc($sql) )
								{
								 if(in_array(196, $access_arry)){
									echo
										"<tr class='gradeX'>
											<td class='center'>{$row['id']}</td>
											<td><b>{$row['out_date']}</b></td>
											<td><b>{$row['pro_name']}</b> - {$row['fiber_id']}<br>{$row['brand']} - {$row['p_sl_no']}</td>
											<td class='center'>{$row['fibertotal']}</td>
											<td class='center'><b>{$row['qty']}</b></td>
											<td>{$row['outby']}</td>
											<td>{$row['c_id']}<br>{$row['c_name']}</td>
											<td>{$row['receiveby']}</td>
											<td>{$row['note']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>
														<form action='StoreOutDelete' method='post'>
															<input type='hidden' name='id' value='{$row['id']}'/>
															<input type='hidden' name='store_type' value='fiber'/>
															<input type='hidden' name='qty' value='{$row['qty']}'/>
															<input type='hidden' name='st_id' value='{$row['st_id']}'/>
															<button cclass='btn ownbtn4' style='padding: 6px 9px;' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button>
														</form>
													</li>
												</ul>
											</td>
										</tr>\n";
								 }
								 else{
									 echo
										"<tr class='gradeX'>
											<td class='center'>{$row['id']}</td>
											<td><b>{$row['out_date']}</b></td>
											<td><b>{$row['pro_name']}</b> - {$row['fiber_id']}<br>{$row['brand']} - {$row['p_sl_no']}</td>
											<td class='center'>{$row['fibertotal']}</td>
											<td class='center'><b>{$row['qty']}</b></td>
											<td>{$row['outby']}</td>
											<td>{$row['c_id']}<br>{$row['c_name']}</td>
											<td>{$row['receiveby']}</td>
											<td>{$row['note']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
												</ul>
											</td>
										</tr>\n";
								 }
								}  
							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php } else{?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
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
    return confirm('Fiber out Delete!!  Are you sure?');
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