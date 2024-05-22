<?php
$titel = "Reports";
$Reports = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$e_id = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Reports' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '2' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(158, $access_arry)){
//---------- Permission -----------
?>
				<?php if(in_array(155, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportCashInHand;?>" href="ReportCashInHand" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Cash In Hand Statement </a>
				<?php } if(in_array(156, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportIncomeExpanceStatement;?>" href="ReportIncomeExpanceStatement" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Income Statement </a>
				<?php } if(in_array(157, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportExpenceHead;?>" href="ReportExpenceHead" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Expense </a>
				<?php } if(in_array(158, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportCollection;?>" href="ReportCollection" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Collection </a>
				<?php } if(in_array(159, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportCollectionSum;?>" href="ReportCollectionSum" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Collection Summary</a>
				<?php } if(in_array(160, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportBillPrint;?>" href="ReportBillPrint" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Due Bills </a>
				<?php } if(in_array(161, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportDew;?>" href="ReportDew" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Due Bill Summary</a>
				<?php } if(in_array(162, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportInvoice;?>" href="ReportInvoice" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Invoice (Due Bills)</a>
				<?php } if(in_array(163, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportClients;?>" href="ReportClients" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Clients </a>
				<?php } if(in_array(180, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportResellerCollection;?>" href="ReportResellerCollection" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Reseller Collection </a>
				<?php } if(in_array(179, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportClientsNew;?>" href="ReportClientsNew" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; New Clients </a>
				<?php } if(in_array(164, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportDiactivationClients;?>" href="ReportDiactivationClients" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Diactivation Clients </a>
				<?php } if(in_array(165, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportSupport;?>" href="ReportSupport" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Clients Support</a>
				<?php } if(in_array(166, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportClientLaser;?>" href="ReportClientLaser" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Client Ledger </a>
				<?php } if(in_array(169, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportStoreInstruments;?>" href="ReportStoreInstruments" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Store (Instrument)</a>
				<?php } if(in_array(172, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportStoreCable;?>" href="ReportStoreCable" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Store (Cable)</a>
				<?php } if(in_array(173, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportOthersBillCollection;?>" href="ReportOthersBillCollection" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Others Collection </a>
				<?php } if(in_array(178, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportRevenue;?>" href="ReportRevenue" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Revenue </a>
				<?php } if(in_array(174, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportAgentLedger;?>" href="ReportAgentLedger" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Agent Ledger </a>
				<?php } if(in_array(175, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportVendorLedger;?>" href="ReportVendorLedger" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Vendor Ledger </a>
				<?php } if(in_array(176, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportLoanLedger;?>" href="ReportLoanLedger" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; Loan Ledger </a>
				<?php } if(in_array(177, $access_arry)){?>
					<a class="list-group-item <?php echo $ReportBtrc;?>" href="ReportBtrc" style="font-weight: bold;"><i class="iconfa-chevron-right"></i> &nbsp; BTRC Report </a>
				<?php } ?>
				
<br>
<br>
<br>
				<div class="tabs-left">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#lA">Cash In Hand</a></li>
						<li><a data-toggle="tab" href="#lB">Income Statement</a></li>
						<li><a data-toggle="tab" href="#lC">Expense</a></li>
					</ul>
							<div class="tab-content">
								<div id="lA" class="tab-pane active">
									<center>
						<h5> Zone Wise Collection Report </h4>
							<div class="pad2">
								<form id="" name="form" class="stdform" method="post" action="form" target="_blank">
								<input type="hidden" name="user_type" id="" readonly value="<?php echo $user_type; ?>" />
								<input type="hidden" name="e_id" id="" readonly value="<?php echo $e_id; ?>" />
									<div class="inputwrapper animate_cus1">
									<?php if($userr_typ == 'mreseller'){ ?>
										<input type="hidden" name="z_id" id="" readonly value="<?php echo $macz_id; ?>" />
										<input type="hidden" name="way" id="" value="macreseller" />
										<select data-placeholder="Choose a Zone" name="box_id" class="chzn-select"  style="width:100%;" />
											<option value="all"> All Zone </option>
												<?php while ($rowaf=mysql_fetch_array($resultsgsg)) { ?>
											<option value="<?php echo $rowaf['box_id']?>"><?php echo $rowaf['b_name']; ?></option>
												<?php } ?>
										</select>
									<?php } else{?>
										<input type="hidden" name="way" id="" value="none" />
										<select data-placeholder="Choose a Zone" name="z_id" class="chzn-select"  style="width:100%;">
											<option value="all"> All Zone </option>
												<?php while ($row=mysql_fetch_array($result)) { ?>
											<option value="<?php echo $row['z_id']?>"><?php echo $row['z_name']; ?> (<?php echo $row['z_bn_name']; ?>)</option>
												<?php } ?>
										</select>
										<?php } ?>
									</div>
									<div class="inputwrapper animate_cus1">
										<select data-placeholder="Payment Type" name="payment_type" class="chzn-select"  style="width:345px;" />
											<option value="all"> All Payment Type</option>
											<option value="CASH"> Cash </option>
											<option value="Online"> Online </option>
										</select>
									</div>
									<div class="inputwrapper1 animate_cus4">
										<div id="custdiv">
											<input type="text" name="f_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-01', time());?>" placeholder="From Date"/>
											<input type="text" name="t_date" id="" class="surch_emp datepicker" value="<?php echo date('Y-m-d', time());?>" placeholder="To Date"/>
										</div>
									</div>
									<div class="animate_cus3">
										<input class="btn ownbtn2" style='width: 45%;' type="submit" value="PDF" onclick="javascript: form.action='fpdf/ReportCollection';"/>
										<input class="btn ownbtn3" style='width: 45%;' type="submit" value="CSV" onclick="javascript: form.action='exl/ReportCollection';"/>
									</div>
								</form>
							</div>
						</center>
								</div>
								<div id="lB" class="tab-pane">
									<p>
										Howdy, I'm in Section B.
									</p>
								</div>
								<div id="lC" class="tab-pane">
									<p>
										What up girl, this is Section C.
									</p>
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
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />

