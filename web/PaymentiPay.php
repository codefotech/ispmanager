<?php
$titel = "Payment";
$ClientsBill = 'active';
include('include/hader.php');
$sts = $_GET['sts'];
extract($_POST); 
ini_alter('date.timezone','Asia/Almaty');

$invoo = date('is', time());

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'ClientsBill' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

$resss = mysql_query("SELECT c_id FROM payment WHERE c_id = '$e_id'");
$rowsss = mysql_fetch_array($resss);
$c_idd = $rowsss['c_id'];

if($c_idd == '')
{
	$res = mysql_query("SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$e_id'");
	$rows = mysql_fetch_array($res);
	$pay = $rows['amt'];
	$Dew = $rows['amt'];
}

else{
$res = mysql_query("SELECT l.amt, t.dic, t.pay FROM
					(
						SELECT c_id, SUM(bill_amount) AS amt FROM billing WHERE c_id = '$e_id'
					)l
					LEFT JOIN
					(
						SELECT c_id, SUM(pay_amount) AS pay, SUM(bill_discount) AS dic FROM payment WHERE c_id = '$e_id'
					)t
					ON l.c_id = t.c_id");

$rows = mysql_fetch_array($res);
$Dew = 	$rows['amt'] - ($rows['pay'] + $rows['dic']);

if($Dew <= 0){
	
	$pay = 'Alrady Paid';
}else{
	$pay = $Dew;
}
}

$bkshchrg = "2";

$pytk1 = ($Dew*$bkshchrg)/100;

$pytk = number_format($pytk1,2);

$payment_amount = $Dew + $pytk;
$respy = mysql_query("SELECT `id` FROM `payment` ORDER BY id DESC LIMIT 1");
	$rowspy = mysql_fetch_array($respy);
	$invo_no = $rowspy['id'] + 1;

$result = mysql_query("SELECT c_id, c_name, cell, address, con_sts, b_date, payment_deadline, breseller FROM clients WHERE c_id = '$e_id'");
$row = mysql_fetch_array($result);	


?>

	<div class="pageheader">
        <div class="searchbar">
			<a class="btn btn-primary" href="ClientsBill"><i class="iconfa-arrow-left"></i>  Back</a>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Payment By iPay</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'faild'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment has been Faild!!</strong> Please try again.
			</div><!--alert-->
	<?php } if($sts == 'canceled'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment has been canceled!!</strong>.
			</div><!--alert-->
	<?php } if($sts == 'success'){?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Payment Successful!!</strong> Thanks for your payment.
			</div><!--alert-->
	<?php } ?>
		<div class="box box-primary">
			<div class="modal-content">
				<div class="modal-body">
				<form name="form1" class="stdform" method="post" action="PaymentiPayQuery" enctype="multipart/form-data">
				<input type="hidden" name="invoice" value="<?php echo 'IPAY'.$invo_no.$invoo;?>">
				<input type ="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
				<input type ="hidden" name="description" value="Internet Bill Pay">
				<input type ="hidden" name="payment_amount" value="<?php echo $payment_amount;?>">
				<input type ="hidden" name="dewamount" value="<?php echo '&dewamount='.number_format($Dew,2).'&amount='.number_format($payment_amount,2);?>">
					<div class="row">
						<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
									<tr>
										<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;">Invoice No</td>
										<td class="width70"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo 'IPAY'.$invo_no.$invoo;?></strong></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;">PPoE User</td>
										<td style="font-size: 13px;"><?php echo $row['c_name'].' | '.$row['c_id'].' | '.$row['cell'].' | '.$row['address'];?></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;">Due Amount</td>
										<td style="font-size: 13px;font-weight: bold;">৳ <?php echo number_format($Dew,2); ?></td>
									</tr>
									<tr>
										<td style="font-size: 13px;font-weight: bold;text-align: right;">Service Charge</td>
										<td style="font-size: 13px;font-weight: bold;">৳ <?php echo number_format($pytk,2); ?></td>
									</tr>
									<tr>
										<td style="font-size: 17px;font-weight: bold;text-align: right;">Total Payment Amount</td>
										<td style="font-size: 17px;font-weight: bold;color: firebrick;">৳ <?php echo number_format($payment_amount,2); ?></td>
									</tr>
						</table>
					</div>
					<div class="modal-footer">
					<?php if($Dew < '1'){?> <h3>You hant any due.</h3> <?php } else{ ?>
					<input type="image" name="submit" src="imgs/ip_btn.png" alt="Submit" style="width: 200px;border: 0px;" />
					<?php } ?>
					</div>
				</form>
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
</code>