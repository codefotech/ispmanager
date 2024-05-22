
    <script src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
    <meta name="viewport" content="width=device-width" , initial-scale=1.0/>
<?php
$titel = "Payment";
$ClientsBill = 'active';
include('include/hader.php');
$error = $_GET['error'];
extract($_POST); 
ini_alter('date.timezone','Asia/Almaty');

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

$pytk = ($Dew*$bkshchrg)/100;

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
            <h1>Payment By bkash</h1>
        </div>
    </div><!--pageheader-->
	<?php if($error != '') {?>
		<div class="alert alert-error">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Payment Unsuccessful!!</strong> <?php echo $error;?>.
		</div><!--alert-->
	<?php } ?>
		<div class="box box-primary">
			<div class="modal-content">
				<div class="modal-body">
					<form id="form" class="stdform" method="post" action="" enctype="multipart/form-data">
					<input type ="hidden" name="c_id" value="<?php echo $row['c_id']; ?>">
						<div class="row">
							<table class="table table-bordered table-invoice" style="width: 100%;font-family: gorgia;">
										<tr>
											<td class="width30" style="font-size: 15px;font-weight: bold;text-align: right;">Invoice No</td>
											<td class="width70"><strong style="font-size: 15px;font-weight: bold;font-family: gorgia;"><?php echo 'BKASH'.$invo_no;?></strong></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;">PPoE User</td>
											<td style="font-size: 13px;"><?php echo $row['c_name'].' | '.$row['c_id'].' | '.$row['cell'].' | '.$row['address'];?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;">Due Amount</td>
											<td style="font-size: 13px;">৳ <?php echo number_format($Dew,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 13px;font-weight: bold;text-align: right;">Service Charge</td>
											<td style="font-size: 13px;">৳ <?php echo number_format($pytk,2); ?></td>
										</tr>
										<tr>
											<td style="font-size: 17px;font-weight: bold;text-align: right;">Total Payment Amount</td>
											<td style="font-size: 17px;font-weight: bold;color: firebrick;">৳ <?php echo number_format($payment_amount,2); ?></td>
										</tr>
							</table>
						</div>
					</form>
					<div class="modal-footer">
					<?php if($Dew < '1'){?> <h3>You have not any due.</h3> <?php } else{ ?>
						<input type="image" id="bKash_button" name="submit" src="imgs/bk_btn.png" border="0" alt="Submit" style="width: 200px;" />
						<?php } ?>
					</div>
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
<code class="language-javascript">
<script type="text/javascript">
    $(document).ready(function () {
            //Token
            $.ajax({
                        url: 'token.php',
                        type: 'POST',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from token  ..');
                        }
                    });

            var paymentConfig;
			paymentConfig = { createCheckoutURL: 'createpayment.php', executeCheckoutURL: 'executepayment.php' };


            var paymentRequest;
            paymentRequest = { amount: <?php echo number_format($payment_amount, 2, '.', ''); ?>, intent: 'bill' };

            bKash.init({

                paymentMode: 'checkout',

                paymentRequest: paymentRequest,


                createRequest: function (request) {

                    console.log('=> createRequest (request) :: ');
                    console.log(request);


                    $.ajax({
                        url: paymentConfig.createCheckoutURL+"?amount="+paymentRequest.amount,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from create  ..');
                            console.log('data ::=>');
                            console.log(JSON.parse(data).paymentID);
                            data = JSON.parse(data);
                            if (data && data.paymentID != null) {
                                paymentID = data.paymentID;
                                bKash.create().onSuccess(data);      
                            } else {
                                bKash.create().onError();
                            }
                        },
                        error: function () {
                            bKash.create().onError();

                        }
                    });

                },
                executeRequestOnAuthorization: function () {

                    console.log('=> executeRequestOnAuthorization');
                    $.ajax({
                        url: paymentConfig.executeCheckoutURL+"?paymentID="+paymentID,
                        type: 'POST',
                        contentType: 'application/json',
                        success: function (data) {
                            console.log('got data from execute  ..');
                            console.log('data ::=>');
                            console.log(JSON.stringify(data));
                            data = JSON.parse(data);
                             if (data && data.paymentID != null) {
 //                               window.location.href = "bKashSuccess.php?paymentID="+data.paymentID+"&trxID="+data.trxID+"&createTime="+data.createTime+"&updateTime="+data.updateTime+"&transactionStatus="+data.transactionStatus+"&intent="+data.intent+"&merchantInvoiceNumber="+data.merchantInvoiceNumber+"&amount="+data.amount+"&dewamount="+<?php echo $Dew;?>;
								alert('[SUCCESS] data : ' + JSON.stringify(data));
                            } else {
								alert(data.errorMessage);
                                window.location.href = "PaymentbKash?error="+data.errorMessage;
                            }
                        },
                        error: function () {
							alert(data.errorMessage);
                        }
                    });
                }
            });
			$('#bKash_button').removeAttr('disabled');
        });
</script>
</code>