<?php
$titel = "Support";
$Support = 'active';
include('include/hader.php');
include("conn/connection.php") ;

date_default_timezone_set('Etc/GMT-6');
$dateAndTime = date('Y-m-d G:i:s', time());

$status = $_GET['id'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Support' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$query1="SELECT dept_id, dept_name FROM department_info ORDER BY dept_id ASC";
$result1=mysql_query($query1);
$query = mysql_query("SELECT l.e_id, c.c_name, c.c_id, l.user_name FROM login AS l
						LEFT JOIN clients AS c
						ON c.c_id = l.e_id
						WHERE l.e_id = '$e_id'");
$row5 = mysql_fetch_assoc($query);
$c_name = $row5['c_name'];
$c_id = $row5['c_id'];

if ($user_type == 'admin'){
$queryr = mysql_query("SELECT c.c_id, c.c_name, c.com_id, z.z_name, c.cell, c.address, p.p_name FROM clients AS c 
									LEFT JOIN zone AS z
									ON z.z_id = c.z_id
									LEFT JOIN package AS p
									ON p.p_id = c.p_id
									ORDER BY c.c_name ASC");
}
else{
	$queryr = mysql_query("SELECT c.c_id, c.c_name, c.com_id, z.z_name, c.cell, c.address, p.p_name FROM clients AS c 
									LEFT JOIN zone AS z
									ON z.z_id = c.z_id
									LEFT JOIN package AS p
									ON p.p_id = c.p_id
									WHERE c_id = '$e_id'");
}


//------------------------

							if($user_type == 'admin') {
								if($status == ''){
								$sql = mysql_query("SELECT m.ticket_no, m.c_id, c.c_name, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, m.entry_date_time, m.sts, m.close_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id ORDER BY m.ticket_no DESC");
								$sqls = mysql_query("SELECT id FROM complain_master WHERE sts = '0'");
								$tot = mysql_num_rows($sql);
								$pending = mysql_num_rows($sqls);
								$closed = $tot - $pending;
								$tit = "<div class='box-header'>
											<div class='hil'> Total Tickets:  <i style='color: #317EAC'>{$tot}</i></div> 
											<div class='hil'> Pending:  <i style='color: #e3052e'>{$pending}</i></div> 
											<div class='hil'> Closed: <i style='color: #317EAC'>{$closed}</i></div> 
										</div>";
								}
								if($status == 'pending'){
								$sql = mysql_query("SELECT m.ticket_no, m.c_id, c.c_name, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, m.entry_date_time, m.sts, m.close_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id WHERE m.sts = '0' ORDER BY m.ticket_no DESC");
								$sqls = mysql_query("SELECT id FROM complain_master WHERE sts = '0'");
								$pending = mysql_num_rows($sqls);
								$tit = "<div class='box-header'>
											<div class='hil'> Pending:  <i style='color: #317EAC'>{$pending}</i></div> 
										</div>";
								}
								if($status == 'closed'){
								$sql = mysql_query("SELECT m.ticket_no, m.c_id, c.c_name, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, m.entry_date_time, m.sts, m.close_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id WHERE m.sts = '1' ORDER BY m.ticket_no DESC");
								$tot = mysql_num_rows($sql);
								$tit = "<div class='box-header'>
											<div class='hil'> Total Ticket:  <i style='color: #317EAC'>{$tot}</i></div> 
										</div>";
								}
							}
							if($user_type == 'client') {
								$sql = mysql_query("SELECT m.ticket_no, m.c_id, c.com_id, c.c_name, m.dept_id, d.dept_name, m.sub, m.massage, m.entry_date_time, m.sts, m.close_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id
												WHERE m.c_id = '$e_id' ORDER BY m.ticket_no DESC");
							}
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="SupportQuery">
	<input type="hidden" name="way" value="internal" />
	<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="entry_date_time" value="<?php echo $dateAndTime; ?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Complain</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client:</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="c_id" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row2=mysql_fetch_array($queryr)) { ?>
								<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> || <?php echo $row2['c_id']; ?> || <?php echo $row2['com_id']; ?> || <?php echo $row2['z_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Complain To</div>
						<div class="col-2"> 
							<select data-placeholder="Department" name="dept_id" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row1=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row1['dept_id']?>"><?php echo $row1['dept_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Subject</div>
						<div class="col-2"> 
							<input type="text" name="sub" id="" required="" style="width:268px;" />
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Complain</div>
						<div class="col-2"> 
							<textarea type="text" name="massage" placeholder="Write your Massege Here" required="" id="" style="width:270px;" /></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn">Reset</button>
				<button class="btn btn-primary" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
		<?php if($user_type == 'admin') {?>
			<a class="btn" href="Support"><i class="iconfa-comments-alt"></i> Clients Support</a>
			<a class="btn btn-neveblue" href="Support?id=pending"><i class="iconfa-check-empty"></i> Pending </a>
			<a class="btn btn-neveblue" href="Support?id=closed"><i class="iconfa-check"></i> Closed </a>
		<?php }?>
		<button class="btn btn-primary" href="#myModal" data-toggle="modal">Add Complain</button>
        </div>
        <div class="pageicon"><i class="iconfa-comments"></i></div>
        <div class="pagetitle">
            <h1>Internal Clients Support</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
	
		<div class="box-header">
			<h5><?php if($user_type == 'admin'){echo $tit;} ?></h5>
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
                            <th class="head1">Ticket No</th>
							<th class="head0">Claint ID</th>
							<th class="head1">ISP Claint ID</th>
                            <th class="head0">Claint Name</th>
							<th class="head1">To</th>
							<th class="head0">Subject</th>
							<th class="head1">Open Time</th>
							<th class="head0">Status</th>
							<th class="head1">Close Time</th>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['sts'] == 0){
										$stss = 'Open';
									}
									if($row['sts'] == 1){
										$stss = 'Close';
									}
									if($row['close_date_time'] == '0000-00-00 00:00:00'){
										$close_date_times = '';
									}
									else{
										$close_date_times = $row['close_date_time'];
									}
									echo
										"<tr class='gradeX'>
											<td>{$row['ticket_no']}</td>
											<td>{$row['c_id']}</td>
											<td>{$row['com_id']}</td>
											<td>{$row['c_name']}</td>
											<td>{$row['dept_name']}</td>
											<td>{$row['sub']}</td>
											<td>{$row['entry_date_time']}</td>
											<td>{$stss}</td>
											<td>{$close_date_times}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='SupportMassageInternal?id=",$id,"{$row['ticket_no']}' data-original-title='View Massege' class='btn col1'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
								}  
							?>
					</tbody>
				</table>
			</div>			
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