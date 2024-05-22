<?php
$titel = "Instruments List";
$Store = 'active';
include('include/hader.php');
include("conn/connection.php");
extract($_POST);
$type = $_GET['id'];
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Store' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '31' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv2'></div>
</div>

<?php if(in_array(187, $access_arry)){?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="product" />
	<input type="hidden" name="backto" value="products" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Instrument Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Instrument Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" placeholder="Ex: Switch, Router etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Instrument Details:</div>
						<div class="col-2"><input type="text" name="pro_details" id="" placeholder="" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Unit:</div>
						<div class="col-2"><input type="text" name="unit" id="" placeholder="" style="width: 70px;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Vat(%):</div>
						<div class="col-2"><input type="text" name="vat" id="" value="0.00" placeholder="" style="width: 25%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Have S/L No?</div>
						<div class="col-2">
						<select class="chzn-select" name="sl_sts" style="width: 70px;" required="" >
							<option value="0">No</option>
							<option value="1">Yes</option>
						</select></div>
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
</div><!--#myModal2-->
<?php } ?>
	<div class="pageheader">
        <div class="searchbar">
		<?php if(in_array(183, $access_arry)){?>
			<a class="btn ownbtn2" href="ProductInInstruments"><i class="iconfa-signin"></i>  IN </a>
		<?php } if(in_array(184, $access_arry)){?>
			<a class="btn ownbtn1" href="ProductOutInstruments"><i class="iconfa-signout"></i>  OUT </a>
		<?php } if(in_array(189, $access_arry)){?>
			<a class="btn ownbtn8" href="InstrumentsStoreInDetails"> Purchase Details </a>
		<?php } if(in_array(190, $access_arry)){?>
			<a class="btn ownbtn6" href="InstrumentsStoreOutDetails"> Store Out Details </a>
		<?php } if(in_array(187, $access_arry)){?>
			<a class="btn ownbtn2" href="#myModal2" data-toggle="modal"><i class="iconfa-plus"></i> Add</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-qrcode"></i></div>
        <div class="pagetitle">
            <h1>Store Instruments List</h1>
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'product') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Instrument Successfully Inserted.
		</div><!--alert-->
	<?php } ?>
	<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Instruments List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
						<col class="con1" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Instrument ID</th>
                            <th class="head1">Instrument Name</th>
                            <th class="head0">Details</th>
                            <th class="head1 center">Unit</th>
                            <th class="head0 center">Vat(%)</th>
                            <th class="head1 center">S/L Status</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT p.id, p.pro_name, p.pro_details, IFNULL(s.inqty,0) AS inqty, IFNULL(s.outqty,0) AS outqty, IFNULL(s.remainingqty,0) AS remainingqty, p.unit, p.vat, p.sl_sts FROM product AS p
												LEFT JOIN
												(SELECT i.id, i.p_id, i.inqty, IFNULL(o.qty, 0) AS outqty, (i.inqty - (IFNULL(o.qty, 0))) AS remainingqty from
													(SELECT id, SUM(quantity) AS inqty, p_id FROM store_in_instruments GROUP BY p_id) AS i
													LEFT JOIN
													(SELECT p_id, IFNULL(SUM(qty), 0) AS qty FROM store_out_instruments GROUP BY p_id) AS o
													ON i.p_id = o.p_id
													GROUP BY i.p_id) AS s
													ON s.p_id = p.id WHERE p.sts = '0'");
								while( $row = mysql_fetch_assoc($sql) )
								{			
									
									if($row['sl_sts'] == '1'){
										$slmuststs = 'Yes';
									}
									else{
										$slmuststs = 'No';
									}
							
								if($userr_typ == 'admin' || $userr_typ == 'superadmin'){
									if($row['inqty'] == '0'){
										$aaa = "<form action='ActionAdd' method='post' style='margin-top: 8px;' onclick='return checkDelete()'><input type='hidden' name='p_id' value='{$row['id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><input type='hidden' name='typ' value='prodectdelete'/><button class='btn ownbtn4' title='Delete' style='padding: 6px 9px;'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;font-size: 18px;width: 80px;vertical-align: middle;' class='center'>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['pro_name']}</b><br><b style='color: #00a65a;font-weight: bold;'>Total IN:</b> {$row['inqty']}<br><b style='color: #b94a48;font-weight: bold;'>Total OUT:</b> {$row['outqty']}<br><b style='font-weight: bold;'>Remaining:</b> {$row['remainingqty']}</td>
											<td style='font-weight: bold;font-size: 15px;vertical-align: middle;'>{$row['pro_details']}</td>
											<td style='font-weight: bold;font-size: 15px;vertical-align: middle;' class='center'>{$row['unit']}</td>
											<td style='font-weight: bold;font-size: 15px;vertical-align: middle;' class='center'>{$row['vat']}%</td>
											<td style='font-weight: bold;font-size: 15px;vertical-align: middle;' class='center'>{$slmuststs}</td>
											<td class='center' style='vertical-align: middle;'>
												<ul class='tooltipsample'>
													<li><form href='#myModal345345' data-toggle='modal' title='Edit'><button type='submit' value='{$row['id']}&remaining={$row['remainingqty']}' class='btn ownbtn3' style='padding: 6px 9px;' onClick='getRoutePoint1(this.value)'><i class='iconfa-edit'></i></button></form></li>
													<li>{$aaa}</li>
												</ul>
											</td>
										</tr>\n";
								}
								else{
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;font-size: 18px;'>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$row['pro_name']}</b><br><b style='color: #00a65a;font-weight: bold;'>Total IN:</b> {$row['inqty']}<br><b style='color: #b94a48;font-weight: bold;'>Total OUT:</b> {$row['outqty']}<br><b style='font-weight: bold;'>Remaining:</b> {$row['remainingqty']}</td>
											<td style='font-weight: bold;font-size: 15px;'>{$row['pro_details']}</td>
											<td style='font-weight: bold;font-size: 15px;' class='center'>{$row['unit']}</td>
											<td style='font-weight: bold;font-size: 15px;' class='center'>{$row['vat']}%</td>
											<td style='font-weight: bold;font-size: 15px;' class='center'>{$slmuststs}</td>
											<td class='center'>
												<ul class='tooltipsample'>
												</ul>
											</td>
										</tr>\n";
								}
								}

							?>
					</tbody>
				</table>
			</div>			
		</div>
<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('#dyntable').dataTable({
			"iDisplayLength": 50,
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0,'asc']],
            "fnDrawCallback": function(oSettings) {
                jQuery.uniform.update();
            }
        });
    });
</script>
<script language="JavaScript" type="text/javascript">function checkDelete(){    return confirm('Delete!!  Are you sure?');}</script>
<script language="javascript" type="text/javascript">
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

		function getRoutePoint1(afdId) {		
		
		var strURL="product-edit.php?p_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv2').innerHTML=req.responseText;						
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
</style>