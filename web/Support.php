<?php
$titel = "Support";
$Support = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);

date_default_timezone_set('Etc/GMT-6');
$dateAndTime = date('Y-m-d G:i:s', time());
$status = isset($_GET['id']) ? $_GET['id']  : '';

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Support' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------
$query1="SELECT dept_id, dept_name FROM department_info ORDER BY dept_id ASC";
$result1 = mysql_query($query1);

$query1ff="SELECT dept_id, dept_name FROM department_info ORDER BY dept_id ASC";
$result1dd = mysql_query($query1ff);

$result2 = mysql_query("SELECT id, subject FROM complain_subject ORDER BY subject ASC");
$query = mysql_query("SELECT l.e_id, c.c_name, c.c_id, l.user_name FROM login AS l
						LEFT JOIN clients AS c
						ON c.c_id = l.e_id
						WHERE l.e_id = '$e_id'");
$row5 = mysql_fetch_assoc($query);
$c_name = $row5['c_name'];
$c_id = $row5['c_id'];

if ($user_type == 'mreseller'){
	$queryr = mysql_query("SELECT c.c_id, c.c_name, c.com_id, z.z_name, c.z_id, c.cell, c.address, p.p_name FROM clients AS c 
									LEFT JOIN zone AS z
									ON z.z_id = c.z_id
									LEFT JOIN package AS p
									ON p.p_id = c.p_id WHERE c.sts = '0' AND c.z_id = '$macz_id'
									WHERE c.sts = '0'
									ORDER BY c.com_id DESC");
}
else{
	if($user_type == 'billing'){
	$queryr = mysql_query("SELECT c.c_id, c.c_name, c.com_id, z.z_name, c.cell, c.address, p.p_name FROM clients AS c 
									LEFT JOIN zone AS z
									ON z.z_id = c.z_id
									LEFT JOIN package AS p
									ON p.p_id = c.p_id
									WHERE c.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0
									ORDER BY c.com_id DESC");
	}
	else{
	$queryr = mysql_query("SELECT c.c_id, c.c_name, c.com_id, z.z_name, c.cell, c.address, p.p_name FROM clients AS c 
									LEFT JOIN zone AS z
									ON z.z_id = c.z_id
									LEFT JOIN package AS p
									ON p.p_id = c.p_id
									WHERE c.sts = '0' ORDER BY c.com_id DESC");
	}	
}


//------------------------

								if($user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'support' || $user_type == 'accounts' || $user_type == 'billing_manager' || $user_type == 'billing' || $user_type == 'support_manager' || $user_type == 'ets' || $user_type == 'support_manager'){
									if($dept_id == ''){
										if($status == 'pending' || $status == ''){
											if($user_type == 'billing'){
												$sqlx = mysql_query("SELECT m.ticket_no, count(l.reply) AS totrep, m.c_id, c.cell, c.c_name, z.z_name, w.e_name AS assignman, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
														LEFT JOIN department_info AS d
														ON d.dept_id = m.dept_id 
														LEFT JOIN emp_info AS w
														ON w.e_id = m.assign
														LEFT JOIN clients AS c
														ON c.c_id = m.c_id 
														LEFT JOIN zone AS z
														ON z.z_id = c.z_id
														LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
														ON l.ticket_no = m.ticket_no
														WHERE m.sts = '0' AND FIND_IN_SET('$e_id', z.emp_id) > 0 GROUP BY m.ticket_no ORDER BY m.ticket_no");
											}
											else{
												$sqlx = mysql_query("SELECT m.ticket_no, count(l.reply) AS totrep, m.c_id, c.cell, c.c_name, z.z_name, w.e_name AS assignman, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
														LEFT JOIN department_info AS d
														ON d.dept_id = m.dept_id 
														LEFT JOIN emp_info AS w
														ON w.e_id = m.assign
														LEFT JOIN clients AS c
														ON c.c_id = m.c_id 
														LEFT JOIN zone AS z
														ON z.z_id = c.z_id
														LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
														ON l.ticket_no = m.ticket_no
														WHERE m.sts = '0' GROUP BY m.ticket_no ORDER BY m.ticket_no");
											}
										$pending = mysql_num_rows($sqlx);
										$tit = "<div class='box-header'>
													<div class='hil'> Total Pending Ticket:  <i style='color: #317EAC'>{$pending}</i></div> 
												</div>";
										}
										if($status == 'closed'){
											if($user_type == 'billing'){
												$sqlx = mysql_query("SELECT m.ticket_no, count(l.reply) AS totrep, m.c_id, c.cell, c.c_name, z.z_name, w.e_name AS assignman, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
														LEFT JOIN department_info AS d
														ON d.dept_id = m.dept_id 
														LEFT JOIN emp_info AS w
														ON w.e_id = m.assign
														LEFT JOIN clients AS c
														ON c.c_id = m.c_id 
														LEFT JOIN zone AS z
														ON z.z_id = c.z_id
														LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
														ON l.ticket_no = m.ticket_no
														WHERE m.sts = '1' AND FIND_IN_SET('$e_id', z.emp_id) > 0 GROUP BY m.ticket_no ORDER BY m.ticket_no");
											}
											else{
												$sqlx = mysql_query("SELECT m.ticket_no, count(l.reply) AS totrep, m.c_id, c.cell, c.c_name, z.z_name, w.e_name AS assignman, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
														LEFT JOIN department_info AS d
														ON d.dept_id = m.dept_id 
														LEFT JOIN emp_info AS w
														ON w.e_id = m.assign
														LEFT JOIN clients AS c
														ON c.c_id = m.c_id 
														LEFT JOIN zone AS z
														ON z.z_id = c.z_id
														LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
														ON l.ticket_no = m.ticket_no
														WHERE m.sts = '1' GROUP BY m.ticket_no ORDER BY m.ticket_no");
											}
										
										$tot = mysql_num_rows($sqlx);
										$tit = "<div class='box-header'>
													<div class='hil'> Total Closed Ticket:  <i style='color: #317EAC'>{$tot}</i></div> 
												</div>";
										}
									}
								else{
									$sqlx = mysql_query("SELECT m.ticket_no, count(l.reply) AS totrep, m.c_id, c.c_name, z.z_name, w.e_name AS assignman, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
													LEFT JOIN department_info AS d
													ON d.dept_id = m.dept_id 
													LEFT JOIN emp_info AS w
													ON w.e_id = m.assign
													LEFT JOIN clients AS c
													ON c.c_id = m.c_id 
													LEFT JOIN zone AS z
													ON z.z_id = c.z_id
													LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
													ON l.ticket_no = m.ticket_no
													WHERE m.dept_id = '$dept_id' GROUP BY m.ticket_no ORDER BY m.ticket_no");
									$sqls = mysql_query("SELECT id FROM complain_master WHERE sts = '0' AND dept_id = '$dept_id'");
									$pending = mysql_num_rows($sqls);
									
									$sqlsyy = mysql_query("SELECT id FROM complain_master WHERE sts = '1' AND dept_id = '$dept_id'");
									$closedddd = mysql_num_rows($sqlsyy);
									$tit = "<div class='box-header'>
												<div class='hil'> Total Pending:  <i style='color: red'>{$pending}</i></div> 
												<div class='hil'> Closed:  <i style='color: #317EAC'>{$closedddd}</i></div> 
											</div>";
								}
							}
							if($user_type == 'mreseller') {
								if($status == 'pending' || $status == ''){
								$sqlx = mysql_query("SELECT m.ticket_no, c.z_id, count(l.reply) AS totrep, c.cell, m.c_id, c.c_name, z.z_name, w.e_name AS assignman, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN emp_info AS w
												ON w.e_id = m.assign
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id 
												LEFT JOIN zone AS z
												ON z.z_id = c.z_id
												LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
												ON l.ticket_no = m.ticket_no
												WHERE m.sts = '0' AND c.z_id = '$macz_id' GROUP BY m.ticket_no ORDER BY m.ticket_no");
								$sqls = mysql_query("SELECT m.id, c.z_id FROM complain_master AS m LEFT JOIN clients AS c ON c.c_id = m.c_id WHERE m.sts = '0' AND c.z_id = '$macz_id'");
								$pending = mysql_num_rows($sqls);
								$tit = "<div class='box-header'>
											<div class='hil'> Total Pending Ticket:  <i style='color: #317EAC'>{$pending}</i></div> 
										</div>";
								}
								if($status == 'closed'){
								$sqlx = mysql_query("SELECT m.ticket_no, m.c_id, c.z_id, count(l.reply) AS totrep, c.cell, z.z_name, w.e_name AS assignman, c.c_name, c.address, c.com_id, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, DATE_FORMAT(m.close_date_time, '%D %M %Y %h:%i%p') AS close_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN emp_info AS w
												ON w.e_id = m.assign
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id 
												LEFT JOIN zone AS z
												ON z.z_id = c.z_id
												LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
												ON l.ticket_no = m.ticket_no
												WHERE m.sts = '1' AND c.z_id = '$macz_id' GROUP BY m.ticket_no ORDER BY m.ticket_no");
								$tot = mysql_num_rows($sqlx);
								$tit = "<div class='box-header'>
											<div class='hil'> Total Closed Ticket:  <i style='color: #317EAC'>{$tot}</i></div> 
										</div>";
								}
							}
							if($user_type == 'client') {
								$sqlx = mysql_query("SELECT m.ticket_no, m.c_id, c.com_id, count(l.reply) AS totrep, c.cell, c.address, z.z_name, w.e_name AS assignman, c.c_name, m.dept_id, d.dept_name, m.sub, m.massage, DATE_FORMAT(m.entry_date_time, '%D %M %Y %h:%i%p') AS entry_date_time, DATE_FORMAT(m.close_date_time, '%D %M %Y %h:%i%p') AS close_date_time, m.sts, l.reply, DATE_FORMAT(l.reply_date_time, '%D %M %Y %h:%i%p') AS reply_date_time FROM complain_master AS m
												LEFT JOIN department_info AS d
												ON d.dept_id = m.dept_id 
												LEFT JOIN emp_info AS w
												ON w.e_id = m.assign
												LEFT JOIN clients AS c
												ON c.c_id = m.c_id 
												LEFT JOIN zone AS z
												ON z.z_id = c.z_id
												LEFT JOIN (SELECT id, ticket_no, reply, reply_date_time FROM complain_detail ORDER BY id DESC) AS l
												ON l.ticket_no = m.ticket_no
												WHERE m.c_id = '$e_id' GROUP BY m.ticket_no ORDER BY m.ticket_no");
							$tit = "<div class='box-header'>
											<div class='hil'> My Complain </div> 
										</div>";					
							}
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="SupportQuery">
	<input type="hidden" name="way" value="client" />
<!--<input type="hidden" name="sentsms" value="No" />--->
	<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="entry_date_time" value="<?php echo $dateAndTime; ?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Complain</h5>
			</div>
			<div class="modal-body">
				<div class="row">
				
					<?php if($user_type == 'client'){ ?>
					<div class="popdiv">
						<div class="col-1">Client</div>
						<div class="col-2"> 
							<input type="hidden" name="c_id" required="" value="<?php echo $c_id; ?>" />
							<input type="text" value="<?php echo $c_name; ?> - <?php echo $c_id; ?>" readonly class="input-xlarge" />
						</div>
					</div>
					<?php } else{ ?>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Client*</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="c_id" class="chzn-select"  style="width:300px;" required="">
								<option value=""></option>
								<?php while ($row2=mysql_fetch_array($queryr)) { ?>
								<option value="<?php echo $row2['c_id']?>"><?php echo $row2['com_id']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['c_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php } ?>
					
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Complain To*</div>
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
						<div class="col-1" style="font-weight: bold;">Subject*</div>
						<div class="col-2">
							<select data-placeholder="Subject" name="sub" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row1=mysql_fetch_array($result2)) { ?>
								<option value="<?php echo $row1['subject']?>"><?php echo $row1['subject']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Complain*</div>
						<div class="col-2"> 
							<textarea type="text" name="massage" placeholder="Write your Massege Here" required="" id="" style="width:270px;" /></textarea>
						</div>
					</div>
					<br /><br />
					<div class="popdiv">
						<div class="col-1">Send SMS?</div>
						<div class="col-2"> 
							<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
							<input type="radio" name="sentsms" value="No" checked="checked"> No
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->


<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModalt">
	<form id="form2" class="stdform" method="post" action="SupportQuery">
	<input type="hidden" name="way" value="task" />
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
						<div class="col-1">Subject</div>
						<div class="col-2">
							<select data-placeholder="Subject" name="sub" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row1=mysql_fetch_array($result2)) { ?>
								<option value="<?php echo $row1['subject']?>"><?php echo $row1['subject']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Department</div>
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
						<div class="col-1">Responsible Person:</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row2=mysql_fetch_array($queryr)) { ?>
								<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> || <?php echo $row2['c_id']; ?> || <?php echo $row2['com_id']; ?> || <?php echo $row2['z_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Team Member:</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row2=mysql_fetch_array($queryr)) { ?>
								<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> || <?php echo $row2['c_id']; ?> || <?php echo $row2['com_id']; ?> || <?php echo $row2['z_name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Priority:</div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="" class="chzn-select"  style="width:280px;" required="">
								<option value="High">High</option>
								<option value="Medium">High</option>
								<option value="Low">High</option>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Start Date:</div>
						<div class="col-2"> 
							<input type="text" name="transfer_amount" placeholder="" id="" class="input-small datepicker" value="<?php echo date("Y-m-d");?>" required="" style="width:30%;" />
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Details</div>
						<div class="col-2"> 
							<textarea type="text" name="massage" placeholder="Write your Massege Here" required="" id="" style="width:270px;" /></textarea>
						</div>
					</div>
					<br /><br />
					<div class="popdiv">
						<div class="col-1">Send SMS?</div>
						<div class="col-2"> 
							<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
							<input type="radio" name="sentsms" value="No" checked="checked"> No
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">Submit</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
		<?php if($user_type == 'admin' || $user_type == 'superadmin') {?>
		<div class="margillll ">
			<form id="form2" class="stdform" method="post" action="<?php echo $PHP_SELF;?>">
				<select name="dept_id" style="height: 30px;" onchange="submit();">
					<option value="all">Choose Department</option>
				<?php while ($row345=mysql_fetch_array($result1dd)) { ?>
					<option value="<?php echo $row345['dept_id']?>"<?php if ($row345['dept_id'] == $dept_id) echo 'selected="selected"';?>><?php echo $row345['dept_name']; ?></option>
				<?php } ?>
				</select>
			</form>
		</div> 
		<?php if($user_type == 'admin' || $user_type == 'superadmin') {?>
			<a class="btn ownbtn10" href="SupportSubject">Subjects</a>
		<?php }} if($user_type == 'mreseller' || $user_type == 'admin' || $user_type == 'superadmin' || $user_type == 'billing') {?>
			<a class="btn ownbtn9" href="Support?id=pending"><i class="iconfa-check-empty"></i> Pending </a>
			<a class="btn ownbtn5" href="Support?id=closed"><i class="iconfa-check"></i> Closed </a>
		<?php }?>
		<button class="btn ownbtn3" href="#myModal" data-toggle="modal">Add Complain</button>
		<!--<button class="btn ownbtn2" href="#myModalt" data-toggle="modal">New Task</button>-->
        </div>
        <div class="pageicon"><i class="iconfa-comments-alt"></i></div>
        <div class="pagetitle">
            <h1>Clients Support</h1>
        </div>
    </div><!--pageheader-->
	<?php if($user_type == 'admin' || $user_type == 'ets' || $user_type == 'billing' || $user_type == 'accounts' || $user_type == 'superadmin') { if($sts == 'smssent') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  You Have Successfully Send The SMS.
			</div><!--alert-->
	<?php } if($sts == 'smsnotsent') {?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Sorry!!</strong> <?php echo $titel;?> Unknown error to sent SMS.
			</div><!--alert-->
	<?php } if($sts == 'newticket') {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong>  New Ticket Successfully Open.
			</div><!--alert-->
	<?php }} ?>
	<div class="box box-primary">
	
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
						<?php if($status == 'closed'){?><col class="con0" /><?php }?>
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
                            <th class="head0">Ticket No</th>
							<th class="head1">ID/Name/Cell</th>
                            <th class="head0">Zone/Address</th>
							<th class="head1">To</th>
							<th class="head0">Subject</th>
							<th class="head1">Open Time</th>
							<th class="head0 center">replied</th>
							<th class="head1">Assigned</th>
							<th class="head0 center">Status</th>
							<?php if($status == 'closed'){?><th class="head1">Close Time</th><?php }?>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								while( $rowx = mysql_fetch_assoc($sqlx) )
								{
									if($rowx['sts'] == 0){
										$stss = 'Open';
									}
									if($rowx['sts'] == 1){
										$stss = 'Close';
									}
									if($rowx['close_date_time'] == '0000-00-00 00:00:00'){
										$close_date_times = '';
									}
									else{
										$close_date_times = $rowx['close_date_time'];
									}
									if($status == 'closed'){
									echo
										"<tr class='gradeX'>
											<td>{$rowx['ticket_no']}</td>
											<td><b>{$rowx['c_id']}</b><br>{$rowx['c_name']}<br>{$rowx['cell']}</td>
											<td>{$rowx['z_name']}<br>{$rowx['address']}</td>
											<td>{$rowx['dept_name']}</td>
											<td>{$rowx['sub']}</td>
											<td>{$rowx['entry_date_time']}</td>
											<td class='center'><ul class='popoversample'>
												<li><a data-content='{$rowx['reply']}' data-placement='top' data-rel='popover' class='btn' href='SupportMassage?id={$rowx['ticket_no']}' data-original-title='{$rowx['reply_date_time']}'>{$rowx['totrep']}</a></li>
											</ul></td>
											<td>{$rowx['assignman']}</td>
											<td class='center'>{$stss}</td>
											<td>{$close_date_times}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='SupportMassage?id={$rowx['ticket_no']}' data-original-title='View' class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
								} else{
									echo
										"<tr class='gradeX'>
											<td>{$rowx['ticket_no']}</td>
											<td><b>{$rowx['c_id']}</b><br>{$rowx['c_name']}<br>{$rowx['cell']}</td>
											<td>{$rowx['z_name']}<br>{$rowx['address']}</td>
											<td>{$rowx['dept_name']}</td>
											<td>{$rowx['sub']}</td>
											<td>{$rowx['entry_date_time']}</td>
											<td class='center'><ul class='popoversample'>
												<li><a data-content='{$rowx['reply']}' data-placement='top' data-rel='popover' class='btn' href='SupportMassage?id={$rowx['ticket_no']}' data-original-title='{$rowx['reply_date_time']}'>{$rowx['totrep']}</a></li>
											</ul></td>
											<td>{$rowx['assignman']}</td>
											<td class='center'>{$stss}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><a data-placement='top' data-rel='tooltip' href='SupportMassage?id={$rowx['ticket_no']}' data-original-title='View' class='btn ownbtn2' style='padding: 6px 9px;'><i class='iconfa-eye-open'></i></a></li>
												</ul>
											</td>
										</tr>\n ";
									
								}


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
			"iDisplayLength": 100,
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