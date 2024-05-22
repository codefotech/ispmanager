<?php
include("conn/connection.php");
      $dueinvoid     = strip_tags(isset($_POST['dueinvoid']) ? $_POST['dueinvoid'] : '');
      $invoice_mr = mysql_query("SELECT (IFNULL(b.bill, '0.00') - IFNULL(p.pay_amount, '0.00')) AS invoicedue FROM
								(SELECT invoice_id AS invoid, IFNULL(SUM(total_price), '0.00') AS bill FROM billing_invoice 
								WHERE sts = '0' AND invoice_id = '$dueinvoid' GROUP BY invoice_id)b
								LEFT JOIN
								(SELECT moneyreceiptno AS invoid, IFNULL((SUM(pay_amount)+SUM(bill_discount)), '0.00') AS pay_amount FROM payment 
								WHERE sts = '0' AND moneyreceiptno = '$dueinvoid' GROUP BY moneyreceiptno)p
								ON p.invoid = b.invoid");
			$rows = mysql_fetch_array($invoice_mr);
			$invoicedue = 	$rows['invoicedue'];
			
?>
<input type="text" name="payment" id="paymentt" style="width:10%;" value="<?php echo $invoicedue;?>" placeholder="Payment in Tk" onInput="updatesum()" onmouseover="updatesum()" onChange="updatesum()"/><input type="text" name="" id="" style="width:2%; color:#2e3e4e; font-weight: bold;font-size: 15px;margin-right: 5px;border-left: 0px solid;" value='৳' readonly />