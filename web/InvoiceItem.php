<?php
$titel = "Invoice Particular";
$Clients = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0){
//---------- Permission -----------

?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="InvoiceAdd" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Invoice Particular</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Name*</div>
						<div class="col-2"><input type="text" name="i_name" id="" placeholder="Ex: Youtube, BDIX" style="width: 100%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Description</div>
						<div class="col-2"><input type="text" name="i_des" id="" placeholder="Ex: Box Address" style="width: 100%;" /></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Unit*</div>
						<div class="col-2"><input type="text" name="i_unit" id="" placeholder="Ex: Mbps, KG, Pis" style="width: 50%;" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">VAT*</div>
						<div class="col-2"><input type="text" name="vat" id="" placeholder="Onu Details" value="0.00" style="width: 20%;" required=""/>&nbsp; (%)</div>
					</div>
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;">Status*</div>
						<div class="col-2">
							<select data-placeholder="Status" name="use_sts" class="chzn-select" style="width:100px;" style="font-size: 15px;">
								<option value="0">Active</option>
								<option value="1">Inactive</option>
							</select>
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

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv1'></div>
</div><!--#myModal-->

	<div class="pageheader">
        <div class="searchbar">
			<a href="Billing?id=invoice_client" class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: #ff5400;border: 1px solid #ff5400;font-size: 14px;">Invoice Clients</a>
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal"><i class="iconfa-plus"></i>&nbsp; Add New Particular</a>
        </div>
        <div class="pageicon"><i class="iconfa-th-list"></i></div>
        <div class="pagetitle">
            <h1>Invoice Particulars</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-danger">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Particulars List
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
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0 center" style="width: 3%;">ID</th>
                            <th class="head1">Name</th>
							<th class="head0">Description</th>
							<th class="head1 center" style="width: 6%;">Unit</th>
							<th class="head1 center" style="width: 8%;">Status</th>
							<th class="head0 center" style="width: 5%;">VAT (%)</th>
							<th class="head0 center" style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT * FROM invoice_item WHERE sts = '0' ORDER BY id DESC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['use_sts'] == '0'){
										$aaa = "Active";
										$colorrr = "color: green;";
									}
									else{
										$aaa = 'Inactive';
										$colorrr = "color: red;";
									}
									echo
										"<tr class='gradeX'>
											<td class='center' style='font-weight: bold;font-size: 18px;vertical-align: middle;'>{$row['id']}</td>
											<td style='font-weight: bold;font-size: 15px;vertical-align: middle;'>{$row['i_name']}</td>
											<td style='vertical-align: middle;'>{$row['i_des']}</td>
											<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 15px;'>{$row['i_unit']}</td>
											<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 15px;{$colorrr}'>{$aaa}</td>
											<td class='center' style='vertical-align: middle;font-weight: bold;font-size: 18px;'>{$row['vat']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><form href='#myModal345345' data-toggle='modal' title=''><button type='submit' value='{$row['id']}' class='btn ownbtn2' style='padding: 6px 9px;' onClick='getRoutePoint(this.value)' title='Edit'><i class='iconfa-edit'></i></button></form></li>
													<li><form action='ActionAdd' method='post' onclick='return checkDelete()'><input type='hidden' name='typ' value='InvoiceDelete'/><input type='hidden' name='invoice_id' value='{$row['id']}'/><button class='btn ownbtn4' style='padding: 6px 9px;' title='Delete'><i class='iconfa-trash'></i></button></form></li>
												</ul>
											</td>
										</tr>\n ";
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
<style>
#dyntable_length{display: none;}
</style>
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
	
	function getRoutePoint(afdId) {		
		
		var strURL="invoice-item-edit.php?invoice_id="+afdId;
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