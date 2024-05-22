<?php
$titel = "Expanse";
$Expanse = 'active';
include('include/hader.php');
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$monmth = date('m', time());
$year = date('Y', time());
$eiddd = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Expanse' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$query222 =mysql_query("SELECT e.id, b.sort_name, e.check_by, q.e_name AS checkby, e.check_date, DATE_FORMAT(e.check_date, '%D %M %Y %h:%i%p') AS checkdate, month(e.check_date) AS checkdate_month,  year(e.check_date) AS checkdate_year, e.check_note, b.bank_name, e.voucher, e.ex_date, a.e_name, e.ex_by, t.ex_type, d.dept_name, a.e_cont_per, e.amount, e.enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN emp_info AS a	ON a.e_id = e.ex_by
													LEFT JOIN bank AS b	ON b.id = e.bank
													LEFT JOIN department_info AS d ON d.dept_id = a.dept_id 
													LEFT JOIN emp_info AS q	ON q.e_id = e.check_by
													WHERE e.id = '$ex_id'");
$row22 = mysql_fetch_assoc($query222);

$yrdatas= strtotime($row22['enty_date']);
$months = date('jS F-y, g:i a', $yrdatas);

?>
	<div class="pageheader">
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Check Expanse</h1>
        </div>
    </div><!--pageheader-->
	
		<?php if('reject' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> <?php echo $titel;?>
			 Successfully Rejected in Your System.
		</div>
		<!--alert-->
		<?php } if('approve' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong>
			<?php echo $titel;?>
			 Successfully Approved in Your System.
		</div>
		<!--alert-->
		<?php } if('edit' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong>
			<?php echo $titel;?>
			 Successfully Edited in Your System.
		</div>
		<!--alert-->
		<?php } ?>
	
		<div class="box box-primary">
			<div class="box-header">
				<p style="float: left;"> <a style="font-size: 15px;font-weight: bold;">Status:</a> <?php if($row22['status'] == '0'){ echo '<a style="color: black; font-size: 13px;font-weight: bold;margin-bottom: 15px">Pending!!!</a>';}if($row22['status'] == '1'){echo '<a style="color: red; font-size: 13px;font-weight: bold;">Rejected at '.$row22['checkdate'].' by '.$row22['checkby'].'.</a>';} if($row22['status'] == '2'){echo '<a style="color: #0866c6; font-size: 13px;font-weight: bold;">Approved at '.$row22['checkdate'].' by '.$row22['checkby'].'.</a>';}?></p>
				<?php if($row22['status'] == '0'){ }?>
				<?php if($row22['status'] == '2'){?>
					<a class="btn ownbtn2" style="float: right;margin-bottom: 15px;padding: 6px 9px;"><span class="iconfa-thumbs-up"></span></a>
				<?php } if($row22['status'] == '1'){?>
					<a class="btn ownbtn4" style="float: right;margin-bottom: 15px;padding: 6px 9px;"><span class="iconfa-thumbs-down"></span></a>
				<?php } ?>
			</div>
			<div class="box-body">
				<div class="row">
						<div style="padding-left: 15px; width: 100%;padding-top: 15px;;">
							<table class="table table-bordered table-invoice" style="width: 97.3%;">
							  <tr>
								<td class="width15">Employee</td>
								<td class="width30"><strong><?php echo $row22['e_name'].' ('.$row22['ex_by'].')'; ?></strong></td>
								<th rowspan="5" style="background: white;width: 0.1%;border-color: #ccc;"></th>
								<td class="width15" style='background-color: #eee;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;text-transform: uppercase;font-size: 11px;color: #555555;'>Expanse Date</td>
								<td class="width30"><strong><?php echo $months; ?></strong></td>
							  </tr>
							  <tr>
								<td>Department</td>
								<td><?php echo $row22['dept_name']; ?></td>
								<td style='background-color: #eee;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;text-transform: uppercase;font-size: 11px;color: #555555;'>Voucher No</td>
								<td><?php echo $row22['voucher']; ?></td>
							  </tr>
							  <tr>
								<td>Contact No</td>
								<td><?php echo $row22['e_cont_per']; ?></td>
								<td style='background-color: #eee;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;text-transform: uppercase;font-size: 11px;color: #555555;'>Purpose</td>
								<td><?php echo $row22['ex_type']; ?></td>
							  </tr>
							  <tr>
								<td>Bank</td>
								<td><strong><?php echo $row22['bank_name']; ?></strong></td>
								<td style='background-color: #eee;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;text-transform: uppercase;font-size: 11px;color: #555555;'>Amount</td>
								<td><strong><?php echo $row22['amount']; ?> ৳</strong></td>
							  </tr>
							   <?php if('1' == (isset($row22['category']) ? $row22['category'] : '')){?>
							   <tr>
								<td>Note</td>
								<td><?php echo $row22['note']; ?></td>
								<td style='background-color: #eee;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;text-transform: uppercase;font-size: 11px;color: #555555;'>Vendor</td>
								<td><?php echo $row22['v_name']; ?></td>
							  </tr>
							  <?php } else{?>
							  <tr>
								<td>Note</td>
								<td colspan="4"><?php echo $row22['note']; ?></td>
							  </tr>
							  <?php } ?>
							</table>
							<br><br><br>
						<?php if($row22['status'] == '0' || 'yes' == (isset($_POST['ex_edit']) ? $_POST['ex_edit'] : '')){if($user_type == 'admin' || $user_type == 'superadmin'){?>
						<form id="form2" class="stdform" method="post" action="ExpanseCheckQuery">
						<input type="hidden" name="ex_id" value="<?php echo $row22['id']; ?>"/>
						<input type="hidden" name="check_by" value="<?php echo $eiddd; ?>"/>
							<table class="table" style="width: 97.3%;">
							  <tr>
							<?php if($row22['checkdate_month'] != $monmth && $row22['checkdate_year'] == $year){ ?>
							  <td><a style="font-size: 15px;font-weight: bold; color: red;">Sorry!! Month has been closed. Not possible to edit.<a></td>
							<?php } if($row22['status'] == '0'){ ?>
								<td colspan="3" style="width: 85%;"><textarea name='check_note' placeholder='Type something here to reply' style="width: 98%;height: 38px;"><?php echo $row22['check_note']; ?></textarea></td>
								<td><button type="submit" name="approve" class="btn ownbtn2" style="text-transform: uppercase;font-weight: bold;"><span class="iconfa-thumbs-up"></span> Approve</button></td>
								<td><button type="submit" name="reject" class="btn ownbtn4" style="text-transform: uppercase;font-weight: bold;"><span class="iconfa-thumbs-down"></span> Reject</button></td>
							<?php } if($row22['checkdate_month'] == $monmth && $row22['checkdate_year'] == $year){ if($row22['status'] == '1'){ ?> 
								<td colspan="3" style="width: 85%;"><textarea name='check_note' placeholder='Type something here to reply' style="width: 98%;height: 38px;"><?php echo $row22['check_note']; ?></textarea></td>
								<td><button type="submit" name="approve" class="btn ownbtn2" style="text-transform: uppercase;font-weight: bold;height: 50px;width: 85px;"><span class="iconfa-thumbs-up"></span> Approve</button></td>
								<td></td>
							<?php } if($row22['status'] == '2'){ ?> 
								<td colspan="3" style="width: 85%;"><textarea name='check_note' placeholder='Type something here to reply' style="width: 98%;height: 38px;"><?php echo $row22['check_note']; ?></textarea></td>
								<td><button type="submit" name="reject" class="btn ownbtn4" style="text-transform: uppercase;font-weight: bold;height: 50px;width: 85px;"><span class="iconfa-thumbs-down"></span> Reject</button></td>
								<td></td>
							<?php } }?>
							 </tr>
							</table>
						</form>
						<?php }}?>
						<table class="table" style="width: 97.3%;">
							 <tr>
							 <?php if($row22['status'] == '1' && 'yes' != (isset($_POST['ex_edit']) ? $_POST['ex_edit'] : '')){?>
								<td style="width: 85%;"><?php if($row22['check_note'] != ''){ echo '<a style="font-size: 15px;font-weight: bold;">Commend from '.$row22['checkby'].':</a> <a style="font-size: 15px;font-weight: bold; color: red;">'.$row22['check_note'].'<a>'; }?></td>
							 <?php } if($row22['status'] == '2' && 'yes' != (isset($_POST['ex_edit']) ? $_POST['ex_edit'] : '')){?>
								<td style="width: 85%;"><?php if($row22['check_note'] != ''){ echo '<a style="font-size: 15px;font-weight: bold;">Commend from '.$row22['checkby'].':</a> <a style="font-size: 15px;font-weight: bold; color: #0866c6;">'.$row22['check_note'].'<a>'; }?></td>
							 <?php } if($row22['status'] != '0' && 'yes' != (isset($_POST['ex_edit']) ? $_POST['ex_edit'] : '')){if($user_type == 'admin' || $user_type == 'superadmin'){?>
								<td style="width: 3%;"><form action='<?php echo $_SERVER['PHP_SELF'];?>' method='post'><input type='hidden' name='ex_edit' value='yes' /><input type='hidden' name='ex_id' value='<?php echo $row22['id']; ?>' /><button class='btn ownbtn3' style='padding: 6px 9px;'><i class='iconfa-edit'></i></button></form></td>
							 <?php }} ?>
							</tr>
						</table>
						</div><!--col-md-6-->
						
					</div>
			</div>			
		</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>