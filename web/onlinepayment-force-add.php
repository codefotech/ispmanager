<?php
include("conn/connection.php") ;
$pid = $_GET['payment_id'];
$wayyyyy = $_GET['wayyyyy'];

$sql = mysql_query("SELECT p.id, DATE_FORMAT(p.date_time, '%D %M %Y') AS paydate, DATE_FORMAT(p.date_time, '%T') AS paytime, p.c_id, p.sender_no, p.pay_mode, p.date_time, p.paymentID, p.createTime, p.updateTime, p.trxID, p.transactionStatus, p.amount, p.pay_amount, p.currency, (p.amount - p.pay_amount) AS chargeamount, p.intent, p.merchantInvoiceNumber, p.refundAmount, p.card_type, p.bank_gw, p.card_no, p.card_issuer, p.card_brand, p.ssl_amount, p.tran_id, p.alldata, p.webhook, p.dateTime, p.debitMSISDN, p.creditOrganizationName, p.creditShortCode, p.transactionType, p.transactionReference, p.webhook_all FROM payment_online AS p 
					WHERE p.id = '$pid' AND p.c_id = '' AND p.reseller_id = ''");


if($wayyyyy == 'client'){
$queryr = mysql_query("SELECT c_id, c_name, cell FROM clients WHERE sts = '0' AND mac_user = '0' ORDER BY c_name");
	
?>
	<form id="form2" class="stdform" method="post" action="PaymentOnlineAdd">
	<input type="hidden" name="c_id" value="<?php echo $c_id;?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5" style="font-weight: bold;color: #f55;font-size: 17px;">Add Online Payment to</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client </div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="c_id" class="chzn-select"  style="width:280px;" required="" onchange="submit();">
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

<?php } else{echo 'Something wrong!!!';}?>

