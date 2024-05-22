<?php
session_start();
include("conn/connection.php");
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$userr_typ = $_SESSION['SESS_USER_TYPE'];
$update_date = date('Y-m-d', time());
$fstday_date = date('Y-m-01', time());

$acce_arry = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS page_access FROM module_page WHERE $userr_typ IN ('1', '2')"));
$access_arry = explode(',',$acce_arry['page_access']);

if($idqqqw != '' && $ee_id != '' && in_array(132, $access_arry)){
					if($macuser != '1'){
						if($breseller == '2'){
							if($_POST['subtotal'] > '0'){
							$query2in = "UPDATE billing_invoice SET sts = '1', update_by = $ee_id WHERE invoice_id = '$invoice_id' AND sts = '0' AND c_id = '$c_id'";
							$resultin = mysql_query($query2in) or die("inser_query failed: " . mysql_error() . "<br />");
								
								$itemNooo  = $_POST['itemNo'];
								$itemNameArray = $_POST['itemName'];
								$itemDesArray = $_POST['itemDes'];
								$quantityArray = $_POST['quantity'];
								$unitArray = $_POST['unit'];
								$unitepriceArray = $_POST['uniteprice'];
								$vatArray = $_POST['vat'];
								$priceArray = $_POST['price'];
								$start_dateArray = $_POST['start_date'];
								$end_dateArray = $_POST['end_date'];
								$daysArray = $_POST['days'];
								
								$invoice_date = $_POST['invoice_date'];
//								$due_deadlinee = date('Y-m-d', strtotime($_POST['due_deadline']));
								$due_deadlinee = date('Y-m-', time()).$_POST['due_deadline'];
								
								foreach( $itemNooo as $key => $productNo ){
											$itemNameValu = $itemNameArray[$key];
											$itemDesValu = $itemDesArray[$key];
											$quantityValu = $quantityArray[$key];
											$unitValu = $unitArray[$key];
											$unitepriceValu = $unitepriceArray[$key];
											$vatValu = $vatArray[$key];
											$priceValu = $priceArray[$key];
											
											$startdate = $start_dateArray[$key];
											$start_dateValu = date('Y-m-d', strtotime($startdate));
											
											$enddate = $end_dateArray[$key];
											$end_dateValu = date('Y-m-d', strtotime($enddate));
											
											$daysValu = $daysArray[$key];
											
											if ($productNo != '' && $itemNameValu != '' && $quantityValu >= '1' && $unitValu != '' && $unitepriceValu >= '1' && $priceValu >= '1' && $start_dateValu != '' && $end_dateValu != ''){
												$Sqlsin = ("INSERT INTO billing_invoice (invoice_id, invoice_date, due_deadline, c_id, item_id, item_name, description, quantity, unit, uniteprice, vat, start_date, end_date, days, total_price) 
												VALUES ('$invoice_id', '$fstday_date', '$due_deadlinee', '$c_id', '$productNo', '$itemNameValu', '$itemDesValu', '$quantityValu', '$unitValu', '$unitepriceValu', '$vatValu', '$start_dateValu', '$end_dateValu', '$daysValu', '$priceValu')");
												
												$resulsff = mysql_query($Sqlsin) or die("inser_query failed: " . mysql_error() . "<br />");
											}
											else{
												echo 'Wrong Entry. Try Again.';
											}
								}
								echo '<script type="text/javascript">window.close()</script>';
							}
							else{ echo 'Wrong Submit!!'; }
						}
						else{
							$query2q ="UPDATE billing SET bill_amount = '$bill_amount', update_date = '$update_date', update_by = '$ee_id', old_bill_amount = '$old_bill_amount' WHERE id = '$idqqqw'";
							if (!mysql_query($query2q)){
								die('Error: ' . mysql_error());
							}
							if($payment_deadline != ''){
							$queryqqq ="UPDATE clients SET payment_deadline = '$payment_deadline' WHERE c_id = '$c_id'";
								if (!mysql_query($queryqqq)){
									die('Error: ' . mysql_error());
								}
							}
							echo '<script type="text/javascript">window.close()</script>';
						}
					}
					else{
					$query2q ="UPDATE billing_mac_client SET bill_amount = '$bill_amount', update_date = '$update_date', update_by = '$ee_id', old_bill_amount = '$old_bill_amount' WHERE id = '$idqqqw'";
						if (!mysql_query($query2q)){
							die('Error: ' . mysql_error());
						}
						if($payment_deadline != ''){
						$queryqqq ="UPDATE clients SET payment_deadline = '$payment_deadline' WHERE c_id = '$c_id'";
							if (!mysql_query($queryqqq)){
								die('Error: ' . mysql_error());
							}
						}
						echo '<script type="text/javascript">window.close()</script>';
					}

}
else{ echo 'Wrong Submit!!';}
?>