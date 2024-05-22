<?php
$titel = "Store Out Details";
$Store = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="ProductOut"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn" href="Store"> Store Summary</a>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Store Out Details</h1>
        </div>
    </div><!--pageheader-->
		<?php if($sts == 'main') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Edite Success!!</strong>
		</div><!--alert-->
		<?php } ?>
		<div class="box box-primary">
			<div class="box-header">
				Purchase Details
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">S/L</th>
							<th class="head1">Product</th>
							<th class="head0">Quntity</th>
							<th class="head1">Out by</th>
							<th class="head0">Receive by</th>
							<th class="head1">Note</th>
							<th class="head0">Out Date</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
							$sql = mysql_query("SELECT o.id, o.st_id, i.p_id, p.pro_name, o.qty, e.e_name AS out_by, e.e_name AS receive_by, o.note, o.out_date_time FROM store_out AS o
													LEFT JOIN emp_info AS e
													ON e.e_id = o.out_by
													LEFT JOIN emp_info AS f
													ON e.e_id = o.receive_by
													LEFT JOIN store_in AS i
													ON i.id = o.st_id
													LEFT JOIN product AS p
													ON p.id = i.p_id
													ORDER BY o.out_date_time DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['st_id']}</td>
											<td>{$row['pro_name']}</td>
											<td>{$row['qty']}</td>
											<td>{$row['out_by']}</td>
											<td>{$row['receive_by']}</td>
											<td>{$row['note']}</td>
											<td>{$row['out_date_time']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='ProductOutEdite?id=",$id,"{$row['id']}' data-original-title='Edit' class='btn col1'><i class='iconfa-edit'></i></a></li>
													<li><a data-placement='top' data-rel='tooltip' href='' data-original-title='Delete' class='btn col5'><i class='iconfa-trash'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>			
		</div>
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
<style>
#dyntable_length{display: none;}
</style>