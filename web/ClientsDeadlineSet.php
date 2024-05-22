<?php
$titel = "Clients Deadline Set";
$Clients = 'active';
include('include/hader.php');
$log_id = isset($_GET['log_id']) ? $_GET['log_id'] : '';
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

if($user_type == 'admin' || $user_type == 'superadmin'){
if($log_id == ''){
$query22="SELECT z_id, z_name, z_bn_name FROM zone WHERE status = '0' AND e_id = '' order by z_name";
$result22=mysql_query($query22);
$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' order by id ASC";
$result1=mysql_query($query1);
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
			<a class="btn ownbtn2" href="Clients">Clients</a>
			<a class="btn ownbtn5" href="ClientsDeadlineSet?log_id=all">Changed Log</a>
        </div>
        <div class="pageicon"><i class="iconfa-cogs"></i></div>
        <div class="pagetitle">
            <h1>Set Clients Deadline</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;font-size: 20px;padding: 10px 0px 9px 25px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);">Where Clients In</div>
					<form id="form" class="stdform" method="post" action="ClientsDeadlineSetQuery">
							<div class="modal-body">
								<p>
									<label>Zone</label>
									<span class="field">
										<select data-placeholder="Choose a Zone" name="z_id" id="z_id" class="chzn-select"  style="width:340px;">
											<option value="all"> All Zone </option>
												<?php while ($rowssss=mysql_fetch_array($result22)) { ?>
											<option value="<?php echo $rowssss['z_id']?>"><?php echo $rowssss['z_name']; ?> (<?php echo $rowssss['z_bn_name'];?>)</option>
												<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label></label>
									<table class="table" style="width: max-content;">
										<tr>
											<td class="" style="font-weight: bold;border-bottom: 1px solid #ddd;text-align: right;color:blue;">Payment<br/>Deadline</td>
											<td class="" style="border-right: 1px solid #ddd;width: 90px;border-bottom: 1px solid #ddd;">
												<select class="chzn-select" name="old_payment_deadline" id="old_payment_deadline" style="width:70%;" />
													<option value="all" style="font-size: 14px;">NO</option>
													<option value="01" style="font-size: 16px;">01</option>
													<option value="02" style="font-size: 16px;">02</option>
													<option value="03" style="font-size: 16px;">03</option>
													<option value="04" style="font-size: 16px;">04</option>
													<option value="05" style="font-size: 16px;">05</option>
													<option value="06" style="font-size: 16px;">06</option>
													<option value="07" style="font-size: 16px;">07</option>
													<option value="08" style="font-size: 16px;">08</option>
													<option value="09" style="font-size: 16px;">09</option>
													<option value="10" style="font-size: 16px;">10</option>
													<option value="11" style="font-size: 16px;">11</option>
													<option value="12" style="font-size: 16px;">12</option>
													<option value="13" style="font-size: 16px;">13</option>
													<option value="14" style="font-size: 16px;">14</option>
													<option value="15" style="font-size: 16px;">15</option>
													<option value="16" style="font-size: 16px;">16</option>
													<option value="17" style="font-size: 16px;">17</option>
													<option value="18" style="font-size: 16px;">18</option>
													<option value="19" style="font-size: 16px;">19</option>
													<option value="20" style="font-size: 16px;">20</option>
													<option value="21" style="font-size: 16px;">21</option>
													<option value="22" style="font-size: 16px;">22</option>
													<option value="23" style="font-size: 16px;">23</option>
													<option value="24" style="font-size: 16px;">24</option>
													<option value="25" style="font-size: 16px;">25</option>
													<option value="26" style="font-size: 16px;">26</option>
													<option value="27" style="font-size: 16px;">27</option>
													<option value="28" style="font-size: 16px;">28</option>
													<option value="29" style="font-size: 16px;">29</option>
													<option value="30" style="font-size: 16px;">30</option>
													<option value="31" style="font-size: 16px;">31</option>
												</select>
											</td>
											<td class="" style="width: 90px;border-bottom: 1px solid #ddd;text-align: right;">
												<select class="chzn-select" name="old_b_date" id="old_b_date" style="width:70%;" />
													<option value="all">NO</option>
													<option value="01" style="font-size: 14px;">01</option>
													<option value="02" style="font-size: 16px;">02</option>
													<option value="03" style="font-size: 16px;">03</option>
													<option value="04" style="font-size: 16px;">04</option>
													<option value="05" style="font-size: 16px;">05</option>
													<option value="06" style="font-size: 16px;">06</option>
													<option value="07" style="font-size: 16px;">07</option>
													<option value="08" style="font-size: 16px;">08</option>
													<option value="09" style="font-size: 16px;">09</option>
													<option value="10" style="font-size: 16px;">10</option>
													<option value="11" style="font-size: 16px;">11</option>
													<option value="12" style="font-size: 16px;">12</option>
													<option value="13" style="font-size: 16px;">13</option>
													<option value="14" style="font-size: 16px;">14</option>
													<option value="15" style="font-size: 16px;">15</option>
													<option value="16" style="font-size: 16px;">16</option>
													<option value="17" style="font-size: 16px;">17</option>
													<option value="18" style="font-size: 16px;">18</option>
													<option value="19" style="font-size: 16px;">19</option>
													<option value="20" style="font-size: 16px;">20</option>
													<option value="21" style="font-size: 16px;">21</option>
													<option value="22" style="font-size: 16px;">22</option>
													<option value="23" style="font-size: 16px;">23</option>
													<option value="24" style="font-size: 16px;">24</option>
													<option value="25" style="font-size: 16px;">25</option>
													<option value="26" style="font-size: 16px;">26</option>
													<option value="27" style="font-size: 16px;">27</option>
													<option value="28" style="font-size: 16px;">28</option>
													<option value="29" style="font-size: 16px;">29</option>
													<option value="30" style="font-size: 16px;">30</option>
													<option value="31" style="font-size: 16px;">31</option>
												</select>
											</td>
											<td class="" style="font-weight: bold;text-align: left;border-bottom: 1px solid #ddd;color:blue;">Billing<br/>Deadline</td>
										</tr>
									</table>
								</p>
								<p>
									<label>Package</label>
									<span class="field">
										<select data-placeholder="Choose a Package" id="p_id" name="p_id" class="chzn-select" style="width:340px;" required="" >
											<option value="all">All Package</option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['p_id']?>"<?php if($row1['p_id'] == $p_id) echo 'selected="selected"';?>><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
												<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>Status</label>
									<span class="formwrapper">
										<input type="radio" name="old_con_sts" id="old_con_sts" value="Active" checked="checked"> Active &nbsp; &nbsp;
										<input type="radio" name="old_con_sts" id="old_con_sts" value="Inactive"> Inactive &nbsp; &nbsp;
										<input type="radio" name="old_con_sts" id="old_con_sts" value="all"> Both &nbsp; &nbsp;
									</span>
								</p>
								<p>	
									<label>Only Due Clients?</label>
									<span class="formwrapper">
										<input type="radio" name="only_due" id="only_due" value="yes"> Yes &nbsp; &nbsp;
										<input type="radio" name="only_due" id="only_due" value="no" checked="checked"> No &nbsp; &nbsp;
									</span>
								</p>
							</div>
				<div class="" style="text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;font-size: 20px;padding: 10px 0px 9px 25px;font-weight: bold;background: none;border-bottom: 1px solid rgba(0, 0, 0, 0.2);border-top: 1px solid rgba(0, 0, 0, 0.2);">Set For <a id="resultpack" style="font-weight: bold;font-size: 30px;"></a> Clients</div>
							<div class="modal-body" id="etheah1">
								<p>
									<label></label>
									<table class="table" style="width: max-content;">
										<tr>
											<td class="" style="font-weight: bold;border-bottom: 1px solid #ddd;text-align: right;color:#ff000087;">Payment<br/>Deadline</td>
											<td class="" style="border-right: 1px solid #ddd;width: 170px;border-bottom: 1px solid #ddd;">
												<select class="chzn-select" name="new_payment_deadline" id="new_payment_deadline" style="width:90%;" />
													<option value="no_change">NO Change</option>
													<option value="">NO</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
													<option value="31">31</option>
												</select>
											</td>
											<td class="" style="width: 170px;border-bottom: 1px solid #ddd;text-align: right;">
												<select class="chzn-select" name="new_b_date" id="new_b_date" style="width:90%;" />
													<option value="no_change">NO Change</option>
													<option value="">NO</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04">04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
													<option value="13">13</option>
													<option value="14">14</option>
													<option value="15">15</option>
													<option value="16">16</option>
													<option value="17">17</option>
													<option value="18">18</option>
													<option value="19">19</option>
													<option value="20">20</option>
													<option value="21">21</option>
													<option value="22">22</option>
													<option value="23">23</option>
													<option value="24">24</option>
													<option value="25">25</option>
													<option value="26">26</option>
													<option value="27">27</option>
													<option value="28">28</option>
													<option value="29">29</option>
													<option value="30">30</option>
													<option value="31">31</option>
												</select>
											</td>
											<td class="" style="font-weight: bold;text-align: left;border-bottom: 1px solid #ddd;color:#ff000087;">Billing<br/>Deadline</td>
										</tr>
									</table>
								</p>
								<span class="field"><div id="charNum"></div></span>
							</div>
							<div class="modal-footer">
								<a style="float: left;font-size: 18px;color: red;font-weight: bold;text-transform: uppercase;margin-top: 5px;">WARNING!! If you submit once. There are no whay to back. Learn first.</a><a id="etheah"></a>
							</div>
					</form>	
			</div>
		</div>
	</div>
<span id="resultpackall"></span>
<?php } else{ 
if($log_id != 'all'){
	$sql = mysql_query("SELECT d.id, d.c_id, d.con_sts, d.update_date_time, d.update_by, d.due_amount, d.old_payment_deadline, d.new_payment_deadline, d.old_b_date, d.new_b_date, e.e_name AS empname FROM deadline_log AS d
						LEFT JOIN emp_info AS e ON e.e_id = d.update_by
						WHERE log_id = '$log_id' ORDER BY d.id DESC");
}
else{
	$sql = mysql_query("SELECT d.id, d.c_id, d.con_sts, d.update_date_time, d.update_by, d.due_amount, d.old_payment_deadline, d.new_payment_deadline, d.old_b_date, d.new_b_date, e.e_name AS empname FROM deadline_log AS d 
						LEFT JOIN emp_info AS e ON e.e_id = d.update_by
						ORDER BY d.id DESC");
}

$tot = mysql_num_rows($sql);
$tit = "<div class='box-header'>
			<div class='hil'> Total Changed:  <i style='color: #317EAC'>{$tot}</i></div> 
		</div>";
?>
		<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn2" href="Clients">Clients</a>
			<a class="btn ownbtn5" href="ClientsDeadlineSet">Set Deadline</a>
        </div>
        <div class="pageicon"><i class="iconfa-cogs"></i></div>
        <div class="pagetitle">
            <h1>Deadline Changed Log</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				<h5><?php echo $tit;?></h5>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center">S/L</th>
							<th class="head0">Date Time</th>
                            <th class="head1">Client ID</th>
							<th class="head0 center">Old PD</th>
							<th class="head1 center">New PD</th>
							<th class="head0 center">OLD BD</th>
							<th class="head1 center">New BD</th>
							<th class="head0 center">Due</th>
							<th class="head1">Update By</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						
						$x = 1;
								while( $row = mysql_fetch_assoc($sql) )
								{
									echo
										"<tr class='gradeX'>
											<td class='center'>{$x}</td>
											<td style='vertical-align: middle;font-size: 14px;font-weight: bold;color: #555;'>{$row['update_date_time']}</td>
											<td>{$row['c_id']}</td>
											<td class='center'>{$row['old_payment_deadline']}</td>
											<td class='center' style='font-weight: bold;'>{$row['new_payment_deadline']}</td>
											<td class='center'>{$row['old_b_date']}</td>
											<td class='center' style='font-weight: bold;'>{$row['new_b_date']}</td>
											<td class='center'>{$row['due_amount']}</td>
											<td>{$row['empname']}</td>
										</tr>\n";
										$x++;
								}
							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php }
}
else{
	echo 'You are not authorised to access this page.';
}
}
else{
	include('include/index');
}
include('include/footer.php');
if($log_id == ''){
?>

<script type="text/javascript">
jQuery(document).ready(function(){  
    $("#resultpack").load("client-sms-cellno-count.php?way=ClientsDeadlineSet&z_id=all&p_id=all&old_payment_deadline=all&old_b_date=all&only_due=no&old_con_sts=Active&dataway=no");
    $("#resultpackall").load("client-sms-cellno-count.php?way=ClientsDeadlineSet&z_id=all&p_id=all&old_payment_deadline=all&old_b_date=all&only_due=no&old_con_sts=Active&dataway=info");
    jQuery('#z_id, #p_id, #old_payment_deadline, #old_b_date, #only_due, #old_con_sts').on('change',function(){ 
        var z_id = jQuery('#z_id').val();
        var p_id = jQuery('#p_id').val();
        var old_payment_deadline = jQuery('#old_payment_deadline').val();
        var old_b_date = jQuery('#old_b_date').val();
		var only_due = jQuery('input[name=only_due]:checked').val();
		var old_con_sts = jQuery('input[name=old_con_sts]:checked').val();
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=ClientsDeadlineSet&dataway=no",
                data:{z_id:z_id,p_id:p_id,old_payment_deadline:old_payment_deadline,old_b_date:old_b_date,only_due:only_due,old_con_sts:old_con_sts},
                success:function(data){
                    jQuery('#resultpack').html(data);
					  if(data > 0){
							jQuery('#etheah').html('<button class="btn ownbtn4" type="submit" onclick="return checksubmit()">SUBMIT</button>');
							jQuery('#etheah1').css('display', 'block');
						}
						else{
							jQuery('#etheah').html('');
							jQuery('#etheah1').css('display', 'none');
						}
                }
        });  
        jQuery.ajax({  
				type: 'GET',
                url: "client-sms-cellno-count.php?way=ClientsDeadlineSet&dataway=info",
                data:{z_id:z_id,p_id:p_id,old_payment_deadline:old_payment_deadline,old_b_date:old_b_date,only_due:only_due,old_con_sts:old_con_sts},
                success:function(data){
                    jQuery('#resultpackall').html(data);
                }
        });  
    });  
});

function checksubmit(){
    return confirm('WARNING!! If you submit once. There are no whay to back. Are you sure?');
}
</script>
<style>
#old_payment_deadline_chzn{font-size: 16px;}
#new_payment_deadline_chzn{font-size: 16px;text-align: center;border: 2px solid #ff000087;}
#old_b_date_chzn{font-size: 16px;text-align: left;}
#new_b_date_chzn{font-size: 16px;text-align: center;border: 2px solid #ff000087;}
</style>
<?php } else{ ?>
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
<style>
#dyntable_length{display: none;}
</style>
<?php } ?>