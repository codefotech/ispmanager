<?php
$titel = "Others Bill";
$SignupBill = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'SignupBill' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '25' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
ini_alter('date.timezone','Asia/Almaty');
$this_month_yr = date('Y-m', time());

if($user_type == 'admin' || $user_type == 'superadmin') {
$sql = mysql_query("SELECT a.id, a.c_id, a.sort_name, a.type, a.c_name, a.pay_date, a.amount, a.billentryby, a.cell, a.ww, a.pay_date_time AS paydatetime, a.bill_dsc FROM
(SELECT b.id, c.c_id, bn.sort_name, b.bill_type, q.type, c.c_name, b.pay_date, b.amount, e.e_name AS billentryby, c.cell, 'signup' AS ww, b.pay_date_time, b.bill_dsc FROM bill_signup AS b
						LEFT JOIN clients AS c ON b.c_id = c.c_id
						LEFT JOIN bills_type AS q ON q.bill_type = b.bill_type 						
						LEFT JOIN emp_info AS e ON e.e_id = b.ent_by
						LEFT JOIN bank AS bn ON bn.id = b.bank						
						
UNION
SELECT b.id, '', bn.sort_name, b.bill_type, q.type, b.be_name AS c_name, b.pay_date, b.amount, e.e_name AS billentryby, b.cell, 'extra' AS ww, b.pay_date_time, b.bill_dsc FROM bill_extra AS b
						LEFT JOIN bills_type AS q ON q.bill_type = b.bill_type 						
						LEFT JOIN emp_info AS e ON e.e_id = b.ent_by
						LEFT JOIN bank AS bn ON bn.id = b.bank) AS a

ORDER BY a.pay_date_time DESC");	
}
else{

$sql = mysql_query("SELECT a.id, a.c_id, a.sort_name, a.type, a.c_name, a.pay_date, a.amount, a.billentryby, a.cell, a.ww, a.pay_date_time AS paydatetime, a.bill_dsc FROM
(SELECT b.id, c.c_id, bn.sort_name, b.bill_type, q.type, c.c_name, b.pay_date, b.amount, e.e_name AS billentryby, c.cell, 'signup' AS ww, b.pay_date_time, b.bill_dsc, b.ent_by FROM bill_signup AS b
						LEFT JOIN clients AS c ON b.c_id = c.c_id
						LEFT JOIN bills_type AS q ON q.bill_type = b.bill_type 						
						LEFT JOIN emp_info AS e ON e.e_id = b.ent_by
						LEFT JOIN bank AS bn ON bn.id = b.bank						
						
UNION
SELECT b.id, '', bn.sort_name, b.bill_type, q.type, b.be_name AS c_name, b.pay_date, b.amount, e.e_name AS billentryby, b.cell, 'extra' AS ww, b.pay_date_time, b.bill_dsc, b.ent_by FROM bill_extra AS b
						LEFT JOIN bills_type AS q ON q.bill_type = b.bill_type 						
						LEFT JOIN emp_info AS e ON e.e_id = b.ent_by
						LEFT JOIN bank AS bn ON bn.id = b.bank) AS a

WHERE a.ent_by = '$e_id' ORDER BY a.pay_date_time DESC");
}
if($user_type == 'billing') {
$queryr = mysql_query("SELECT c.c_id, c.c_name, c.cell FROM clients AS c LEFT JOIN zone AS z ON z.z_id = c.z_id WHERE z.emp_id = '$e_id' ORDER BY c_name");
}
else{
$queryr = mysql_query("SELECT c_id, c_name, cell FROM clients ORDER BY c_name");
}

if($user_type == 'admin' || $user_type == 'superadmin'){
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
	$Bank11 = mysql_query("SELECT * FROM bank WHERE sts = 0 ORDER BY bank_name");
}
else{
	$Bank = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
	$Bank11 = mysql_query("SELECT * FROM bank WHERE sts = 0 AND emp_id = '$e_id' ORDER BY bank_name");
}
				
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="SignupBillSave">
	<input type="hidden" name="way" value="signup" />
	<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="pay_date" value="<?php echo date("Y-m-d");?>" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5"> Add New Bill </h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Client </div>
						<div class="col-2"> 
							<select data-placeholder="Choose Client" name="c_id" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php while ($row2=mysql_fetch_array($queryr)) { ?>
								<option value="<?php echo $row2['c_id']?>"><?php echo $row2['c_name']; ?> | <?php echo $row2['c_id']; ?> | <?php echo $row2['cell']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>										
					<div class="popdiv">
						<div class="col-1">Bill Type</div>
						<div class="col-2">
							<select name="bill_type" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php 
								$query11="SELECT bill_type, type FROM bills_type ORDER BY bill_type ASC";
								$result11 = mysql_query($query11);
								while ($row11=mysql_fetch_array($result11)) { ?>
								<option value="<?php echo $row11['bill_type']?>"><?php echo $row11['type']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Bill Status</div>
						<div class="col-2">
							<select data-placeholder="Select a Status" name="bill_sts" class="chzn-select"  style="width:80px;" required="" onChange="getRoutePoint1(this.value)">
									<option value="Unpaid">Unpaid</option>
									<option value="Paid">Paid</option>
							</select>
						</div>
					</div>
					<div id="Pointdiv1"></div>
					<div class="popdiv">
						<div class="col-1">Amount </div>
						<div class="col-2"> 
							<input type="text" name="amount" id="" required="" style="width:268px;" />
						</div>
					</div>
					<div class="popdiv">						
						<div class="col-1">Notes </div>						
						<div class="col-2"> 							
							<textarea type="text" name="bill_dsc" id="" placeholder="Write Your Bill Note" class="input-xlarge" /></textarea>						
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

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal10">
	<form id="form2" class="stdform" method="post" action="SignupBillSave">
	<input type="hidden" name="way" value="extra" />
	<input type="hidden" name="send_by" value="<?php echo $e_id;?>" />
	<input type="hidden" name="pay_date" value="<?php echo date("Y-m-d");?>" />
	
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5"> Add Extra Income </h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Name </div>
						<div class="col-2"> 
							<input type="text" name="be_name" id="" placeholder="Write the name." required="" style="width:268px;" />
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Cell No </div>
						<div class="col-2"> 
							<input type="text" name="cell" id="" placeholder="Mobile No" style="width:268px;" />
						</div>
					</div>						
					<div class="popdiv">
						<div class="col-1">Bill Type</div>
						<div class="col-2">
							<select name="bill_type" class="chzn-select"  style="width:280px;" required="">
								<option value=""></option>
								<?php 
								$query1111="SELECT bill_type, type FROM bills_type ORDER BY type ASC";
								$result1111 = mysql_query($query1111);
								while ($row111=mysql_fetch_array($result1111)) { ?>
								<option value="<?php echo $row111['bill_type']?>"><?php echo $row111['type']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Bank</div>
						<div class="col-2">
							<select data-placeholder="Select a Bank" name="bank" class="chzn-select"  style="width:280px;" required="">
								<?php while ($rowBank11=mysql_fetch_array($Bank11)) { ?>
									<option value="<?php echo $rowBank11['id'] ?>"><?php echo $rowBank11['bank_name']?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Amount </div>
						<div class="col-2"> 
							<input type="text" name="amount" id="" required="" style="width:168px;" /><input type="text" value="TK" readonly style="width:20px;" />
						</div>
					</div>
					<div class="popdiv">
						<div class="col-1">Send SMS?</div>
						<div class="col-2"> 
							<input type="radio" name="sentsms" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
							<input type="radio" name="sentsms" value="No"> No
						</div>
					</div>					
					<div class="popdiv">						
						<div class="col-1">Notes </div>						
						<div class="col-2"> 							
							<textarea type="text" name="bill_dsc" id="" placeholder="Write Your Bill Note" class="input-xlarge" /></textarea>						
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal20">
	<form id="form2" class="stdform" method="post" action="SignupBillSave">
	<input type="hidden" name="way" value="billtype" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> New Bill Type </h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">Bill Type</div>
							<div class="col-2"><input type="text" name="type" required="" id="" class="input-xlarge" placeholder="Ex: Join Fiber" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Bill Discription</div>
							<div class="col-2"><input type="text" name="bill_type_disc" id="" class="input-xlarge" placeholder="Discription" /></div>
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
		<?php if(in_array(215, $access_arry)){?>
			<a class="btn ownbtn3" href="#myModal20" data-toggle="modal">Add Bill Type </a>
		<?php } if(in_array(213, $access_arry)){?>
			<a class="btn ownbtn1" href="OthersBillAdd?way=client">Add For Client </a>
		<?php } if(in_array(214, $access_arry)){?>
			<a class="btn ownbtn2" href="OthersBillAdd?way=extra">Add Extra Income </a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-money"></i></div>
        <div class="pagetitle">
            <h1>Others Bills Collection</h1>
        </div>
    </div><!--pageheader-->
	<?php if($sts == 'delete') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted from Your System.
		</div>
		<!--alert-->
		<?php } if($sts == 'add') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> <?php echo $titel;?> Successfully Added from Your System.
		</div>
		<!--alert-->
		<?php } ?>
	<?php if(in_array(211, $access_arry)){?>
	<div class="box box-primary">
		<div class="box-header">
			<h5>All Others Bill Collection</h5>
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
						<col class="con0" />

                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Date</th>
							<th class="head1">Name/Cell/ID</th>											
							<th class="head0">Bill Type</th>
							<th class="head1">Amount</th>
							<th class="head0">Bank</th>
							<th class="head1">Entry By</th>
							<th class="head0">Note</th>
							<th class="head1 center">Paid From</th>
                            <th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>					
						<?php		
								while( $row = mysql_fetch_assoc($sql) )
								{
									$yrdata1= strtotime($row['pay_date']);
									$month_yr = date('Y-m', $yrdata1);
									
									if($row['ww'] == 'signup'){
										$qqq = "<span class='label label-success'>Client<span>";
										$colorrrr = 'style="color: green;"';
									}
									if($row['ww'] == 'extra'){
										$qqq = "<span class='label label-warning'>Outside<span>";
										$colorrrr = 'style="color: blue;"';
									}
									if($this_month_yr == $month_yr && in_array(212, $access_arry)){
										$aaaa = "<form action='SignupBillDelete' method='post'><input type='hidden' name='way' value='{$row['ww']}' /><input type='hidden' name='idd' value='{$row['id']}' /><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete' onclick='return checkDelete()';'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaaa = "";
									}
									
									echo
										"<tr class='gradeX'>
											<td>{$row['paydatetime']}</td>
											<td>{$row['c_name']}<br>{$row['cell']}<br>{$row['c_id']}</td>																					
											<td>{$row['type']}</td>
											<td>{$row['amount']}</td>
											<td>{$row['sort_name']}</td>
											<td>{$row['billentryby']}</td>
											<td>{$row['bill_dsc']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>{$qqq}</li>										
												</ul>
											</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>{$aaaa}</li>										
												</ul>
											</td>
										</tr>\n ";
								}
							?>
					</tbody>
				</table>
			</div>			
	</div>
	<?php } ?>
<!-- -------------------------------------------------------------Entry Data View------------------------------------------------------------ -->			
<!--<li><a data-placement='top' data-rel='tooltip' href='SignupBillDelete?id=",$id,"{$row['id']}' data-original-title='Delete' class='btn col5' onclick='return checkDelete()'><i class='iconfa-trash'></i></a></li>-->												
				
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
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'desc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Delete!!  Are you sure?');
}
</script>
<style>
#dyntable_length{display: none;}
</style>

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
		
		var strURL="others-bill-sts.php?bill_sts="+afdId1;
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