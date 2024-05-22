<?php
$titel = "Upcoming";
$Upcoming = 'active';
include('include/hader.php');
$sts = $_GET['ids'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Upcoming' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------


?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="Upcoming"> All</a>
			<a class="btn btn-neveblue" href="Upcoming?ids=done"> Done</a>
			<!-- <a class="btn btn-primary" href="Upcoming?ids=today"> Today's Work</a> -->
			<a class="btn btn-primary" href="UpcomingAdd"><i class="iconfa-plus"></i> New Schedule</a>
			
        </div>
        <div class="pageicon"><i class="iconfa-signin"></i></div>
        <div class="pagetitle">
            <h1>Upcoming Clients</h1>
        </div>
    </div><!--pageheader-->

		<div class="box box-primary">
			<div class="box-header">
				Upcoming List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive" />
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
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Name</th>
							<th class="head1">Zone</th>
							<th class="head0">Address</th>
							<th class="head1">Cell</th>
							<th class="head0">Package</th>
							<th class="head1">OTC</th>
							<th class="head0">Set-Up</th>
							<th class="head1">Status</th>
							<th class="head0">Line-Up</th>
							<th class="head1">Note</th>
							<th class="head0">Received</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						if($sts == 'done'){
							$sql = mysql_query("SELECT u.id, u.schedule_id, e.e_name, u.rcv_date_time, z.z_name, u.c_name, u.address, u.cell, p.p_name, u.otc, u.setup_date, u.previous_isp, u.note, u.current_status, u.sts, u.line_up_date FROM upcoming AS u
													LEFT JOIN emp_info AS e
													ON e.e_id = u.rcv_by
													LEFT JOIN zone AS z
													ON z.z_id = u.z_id
													LEFT JOIN package AS p
													ON p.p_id = u.p_id
													WHERE u.current_status = 'done' ORDER BY u.setup_date DESC");
							
						}
						else{
							$sql = mysql_query("SELECT u.id, u.schedule_id, e.e_name, u.rcv_date_time, z.z_name, u.c_name, u.address, u.cell, p.p_name, u.otc, u.setup_date, u.previous_isp, u.note, u.current_status, u.sts, u.line_up_date FROM upcoming AS u
													LEFT JOIN emp_info AS e
													ON e.e_id = u.rcv_by
													LEFT JOIN zone AS z
													ON z.z_id = u.z_id
													LEFT JOIN package AS p
													ON p.p_id = u.p_id
													WHERE u.current_status != 'done'
													ORDER BY u.setup_date DESC");
						}
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td>{$row['c_name']}</td>
											<td>{$row['z_name']}</td>
											<td>{$row['address']}</td>
											<td>{$row['cell']}</td>
											<td>{$row['p_name']}</td>
											<td>{$row['otc']}</td>
											<td>{$row['setup_date']}</td>
											<td>{$row['current_status']}</td>
											<td>{$row['line_up_date']}</td>
											<td>{$row['note']}</td>
											<td>{$row['e_name']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='UpcomingEdit?id=",$id,"{$row['id']}' data-original-title='Edit' class='btn col1'><i class='iconfa-edit'></i></a></li>
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
			"iDisplayLength": 100,
            "sPaginationType": "full_numbers",
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