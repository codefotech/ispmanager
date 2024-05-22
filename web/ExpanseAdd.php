<?php
$titel = "Expense";
$Expanse = 'active';
include('include/hader.php');
extract($_POST);
ini_alter('date.timezone','Asia/Almaty');
$eid = $_SESSION['SESS_EMP_ID'];

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
if(in_array(198, $access_arry) || in_array(199, $access_arry) || in_array(200, $access_arry)){
//---------- Permission -----------

$query="SELECT id, ex_type FROM expanse_type WHERE status = '0' ORDER BY ex_type ASC";
$result=mysql_query($query);

if(in_array(254, $access_arry)){
	$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' ORDER BY e_id ASC";
	$result1=mysql_query($query1);
}
else{
	$query1="SELECT e_id, e_name, e_des FROM emp_info WHERE status = '0' AND e_id = '$e_id' ORDER BY e_id ASC";
	$result1=mysql_query($query1);
}

if(in_array(255, $access_arry)){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}

$sql2 ="SELECT id FROM expanse ORDER BY id DESC LIMIT 1";
$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$idz = $row2['id'];
$voucher = $idz + 1;
?>
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php if(in_array(201, $access_arry) || in_array(202, $access_arry) || in_array(203, $access_arry) ||in_array(204, $access_arry)){?>
			<a class="btn ownbtn2" href="ExpenseType">Expense Type</a>
		<?php } ?>
		</div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Expense</h1>
        </div>
    </div><!--pageheader-->

	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Add Expense</h5>
				</div>
					
				<form id="" name="form1" class="stdform" method="post" action="ExpanseAddSave">
					<input type="hidden" value="<?php echo $_SESSION['SESS_EMP_ID'];?>" name="entry_by" />
					<input type="hidden" value="<?php echo date('Y-m-d H:i:s');?>" name="enty_date" />
					<input type="hidden" value="<?php echo $idz;?>" name="old_voucher" />
					<input type="hidden" name="ex_date" value="<?php echo date('Y-m-d'); ?>" readonly />
					<div class="modal-body">
						<p>
							<label style="padding: 0;">Voucher No</label>
							<span class="field" style="font-size: 20px;font-weight: bold;color: #910000;"><input type="hidden" name="voucher" value="<?php echo $voucher;?>" style="width:15%;" readonly required=""/><?php echo $voucher;?></span>
						</p>
						<p>
							<label style="font-weight: bold;">Expense by*</label>
							<?php if(in_array(254, $access_arry)){ ?>
							<select data-placeholder="Type Of Expense" name="exp_by" style="width:350px;" class="chzn-select" required="">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result1)) { ?>
								<option value="<?php echo $row['e_id'];?>"><?php echo $row['e_name'];?> - <?php echo $row['e_des'];?> - <?php echo $row['e_id'];?></option>
									<?php } ?>
							</select>
							<?php } else{ ?>
							<span class="field" style="font-size: 15px;font-weight: bold;padding: 7px 0 0px 0;">
								<input type="hidden" name="exp_by" id="" required="" value="<?php echo $e_id;?>" />
								<?php $row=mysql_fetch_array($result1); echo $row['e_name'].' - '.$row['e_des'].' - '.$row['e_id'];?>
							</span>
							<?php } ?>
						</p>
						<p>
							<label style="font-weight: bold;">Bank*</label>
							<?php if(in_array(255, $access_arry)){ ?>
							<select data-placeholder="Type Of bank" name="bank" style="width:180px;" class="chzn-select" required="">
								<option value=""></option>
								<?php while ($rowBank=mysql_fetch_array($Bank)) { ?>
									<option value="<?php echo $rowBank['id'];?>"><?php echo $rowBank['bank_name'];?> <?php if($rowBank['emp_id'] != ''){echo '('.$rowBank['emp_id'].')';}?></option>
								<?php } ?>
							</select>
							<?php } else{ ?>
							<span class="field" style="font-size: 15px;font-weight: bold;padding: 7px 0 0px 0;">
								<?php $rowBank=mysql_fetch_array($Bank); echo $rowBank['bank_name'];?>
								<input type="hidden" name="bank" id="" required="" value="<?php echo $rowBank['id'];?>" />
							</span>
							<?php } ?>
						</p>
						<p>
							<label style="font-weight: bold;">Category*</label>
							<span class="field">
								<select class="chzn-select" name="category" style="width:180px;" required="" onChange="getRoutePoint1(this.value)"> 
								<?php if(in_array(198, $access_arry)){?>
									<option value="0">Office Expense</option>
								<?php } if(in_array(218, $access_arry)){?>
									<option value="3">Investment Expense</option>
								<?php } if(in_array(199, $access_arry)){?>
									<option value="1">Vendor Bill Pay</option>
								<?php } if(in_array(200, $access_arry)){?>
									<option value="2">Agent Commission Pay</option>
								<?php } ?>
								</select>
							</span>
						</p>
						<div id="Pointdiv1"></div>
						
						<p>	
							<label style="font-weight: bold;">Purpose*</label>
							<select data-placeholder="Choose a Head" name="type" class="chzn-select"  style="width:350px;" required="">
								<option value=""></option>
									<?php while ($row=mysql_fetch_array($result)) { ?>
								<option value="<?php echo $row['id'] ?>"><?php echo $row['ex_type']?></option>
									<?php } ?>
							</select>
						</p>
						<p>
							<label style="font-weight: bold;">Amount*</label>
							<span class="field"><input type="text" name="amount" id="" style="width:80px;height: 25px;font-size: 20px;font-weight: bold;color: brown;" required="" placeholder="Amount" /><input type="text" name="" id="" style="width:17px;height: 25px; color:brown; font-weight: bold;font-size: 20px;border-left: none;" value='৳' readonly /></span>
						</p>
						<p>
							<label style="font-weight: bold;">Mathod*</label>
							<span class="field">
								<select class="chzn-select" name="mathod" style="width:116px;" required="" onChange="getRoutePoint(this.value)"> 
									<option value="Cash">CASH</option>
									<option value="Bank">BANK</option>
									<option value="Online">ONLINE</option>
								</select>
							</span>
						</p>
						<div id="Pointdiv"></div>
						<p>
							<label>Notes</label>
							<span class="field"><textarea type="text" name="note" style="width:350px;" id="" placeholder="Expense Note (If Any)" class="input-xxlarge" /></textarea></span>
						</p>
					</div>
					<div class="modal-footer">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit">Submit</button>
					</div>
				</form>			
			</div>
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">

                            <th class="head1">Voucher No</th>
                            <th class="head0">Date</th>
							<th class="head1">Purpose</th>
							<th class="head0">Bank</th>
							<th class="head1">Amount</th>
							<th class="head0">Note</th>
							<th class="head1">Status</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
								$sql = mysql_query("SELECT e.id, e.voucher, b.sort_name, e.ex_date, t.ex_type, e.amount, e.enty_date, e.note, e.status FROM expanse AS e
													LEFT JOIN expanse_type AS t ON t.id = e.type
													LEFT JOIN bank AS b	ON b.id = e.bank
													WHERE e.entry_by = '$eid' ORDER BY e.id DESC LIMIT 10");
									while( $row = mysql_fetch_assoc($sql) )
									{
										if($row['status'] == '0'){
											$exxxx = "Pending";
										}
										elseif($row['status'] == '1'){
											$exxxx = "Rejected";
										}
										else{
											$exxxx = "Approved";
										}
										echo
											"<tr class='gradeX'>
												<td>{$row['voucher']}</td>
												<td>{$row['ex_date']}</td>
												<td>{$row['ex_type']}</td>
												<td>{$row['sort_name']}</td>
												<td>{$row['amount']}</td>
												<td>{$row['note']}</td>
												<td>{$exxxx}</td>
											</tr>\n";
									}  
							?>
                    </tbody>
            </table>
		</div>
	</div>
	<?php
}
else{ ?>
<div class="box box-primary">
	<div class="box-header">
		<h4 style="text-align: center;color: red;font-size: 20px;"><b>WORNING!!! You are not Authorized. Please Dont Try.</b></h4>
	</div>
</div>
<?php }
include('include/footer.php');
?>

<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	

	function getRoutePoint(afdId) {		
		
		var strURL="ex_mathod.php?mathod="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<script type="text/javascript">
function getXMLHTTP() { //fuction to return the xml http object
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e){		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }
	

	function getRoutePoint1(afdId1) {		
		
		var strURL="ex_category.php?category="+afdId1;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv1').innerHTML=req.responseText;						
					} else {
						alert("Problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}			
			req.open("GET", strURL, true);
			req.send(null);
		}		
	}
</script>
<style>
#dyntable_length{display: none;}
#dyntable_filter{display: none;}
</style>