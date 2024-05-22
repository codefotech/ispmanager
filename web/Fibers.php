<?php
$titel = "Fibers List";
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
	<input type="hidden" name="typ" value="fiber" />
	<input type="hidden" name="backto" value="fibers" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add Fiber Information</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Fiber Name:</div>
						<div class="col-2"><input type="text" name="pro_name" id="" placeholder="Ex: CAT-5, 4-CORE etc" class="input-large" required=""/></div>
					</div>
					<div class="popdiv">
						<div class="col-1">Fiber Details:</div>
						<div class="col-2"><input type="text" name="pro_details" id="" placeholder="" class="input-large" required=""/></div>
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
		<?php if(in_array(185, $access_arry)){?>
			<a class="btn ownbtn2" href="ProductInFiber"><i class="iconfa-signin"></i>  IN </a>
		<?php } if(in_array(186, $access_arry)){?>
			<a class="btn ownbtn1" href="ProductOutFiber"><i class="iconfa-signout"></i>  OUT </a>
		<?php } if(in_array(191, $access_arry)){?>
			<a class="btn ownbtn8" href="FiberStoreInDetails"> Purchase Details </a>
		<?php } if(in_array(192, $access_arry)){?>
			<a class="btn ownbtn6" href="FiberStoreOutDetails"> Store Out Details </a>
		<?php } if(in_array(197, $access_arry)){?>
			<a class="btn ownbtn2" href="#myModal2" data-toggle="modal"><i class="iconfa-plus"></i> Add</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-qrcode"></i></div>
        <div class="pagetitle">
            <h1>Store Fiber List</h1>
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'product') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New Fiber Successfully Inserted.
		</div><!--alert-->
	<?php } ?>
	<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				Fibers List
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
							<th class="head0 center">Fiber ID</th>
                            <th class="head1">Fiber Name</th>
                            <th class="head0">Details</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT * FROM fiber WHERE sts = '0'");
								while( $row = mysql_fetch_assoc($sql) )
								{			
								if($userr_typ == 'admin' || $userr_typ == 'superadmin'){
									
									$pro_name = $row['pro_name'];
									$id = $row['id'];										
										$sqls = mysql_query("SELECT id, IFNULL(SUM(fibertotal), 0) AS tolt_in, IFNULL(SUM(fibertotal_out), 0) AS tolt_out FROM store_in_out_fiber WHERE p_id = '$id' AND status = '0'");
										$res = '';
										$res1 = mysql_fetch_array($sqls);
										$aa = $res1['tolt_in'];
										$bb = $res1['tolt_out'];
										$totl_fiber = $aa - $bb;
										
										if($aa != '0' && in_array(191, $access_arry)){
											$fff = "<a data-placement='top' data-rel='tooltip' href='FiberStoreInDetails?pid={$id}' style='font-size: 13px;'>{$aa}M</a>";
										}
										else{
											$fff = "{$aa}";
										}
										
										if($bb != '0' && in_array(192, $access_arry)){
											$hhh = "<a data-placement='top' data-rel='tooltip' href='FiberStoreOutDetails?pid={$id}' style='font-size: 13px;'>{$bb}M</a>";
										}
										else{
											$hhh = "{$bb}";
										}
									
									
									if($aa == '0'){
										$aaa = "<form action='ActionAdd' method='post' style='margin-top: 8px;' onclick='return checkDelete()'><input type='hidden' name='p_id' value='{$row['id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><input type='hidden' name='typ' value='fiberdelete'/><button class='btn ownbtn4' title='Delete' style='padding: 6px 9px;'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;font-size: 18px;' class='center'>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$pro_name}</b></td>
											<td><b style='font-weight: bold;font-size: 15px;'>{$row['pro_details']}</b><br><b style='color: #00a65a;font-weight: bold;'>IN:</b> {$fff}<br><b style='color: #b94a48;font-weight: bold;'>OUT:</b> {$hhh}<br><b style='font-weight: bold;'>Remaining:</b> {$totl_fiber}M</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li><form href='#myModal345345' data-toggle='modal' title='Edit'><button type='submit' value='{$row['id']}' class='btn ownbtn3' style='padding: 6px 9px;' onClick='getRoutePoint1(this.value)'><i class='iconfa-edit'></i></button></form></li>
													<li>{$aaa}</li>
												</ul>
											</td>
										</tr>\n";
								}
								else{
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;font-size: 18px;' class='center'>{$row['id']}</td>
											<td><b style='font-weight: bold;font-size: 18px;'>{$pro_name}</b></td>
											<td><b style='font-weight: bold;font-size: 15px;'>{$row['pro_details']}</b><br><b style='color: #00a65a;font-weight: bold;'>IN:</b> {$fff}<br><b style='color: #b94a48;font-weight: bold;'>OUT:</b> {$hhh}<br><b style='font-weight: bold;'>Remaining:</b> {$totl_fiber}M</td>
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
		
		var strURL="fiber-edit.php?p_id="+afdId;
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