<?php
$titel = "User Type";
$UserAccess = 'active';
include('include/hader.php');
extract($_POST);

//---------- Permission start-----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'UserAccess' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission end-----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345a">
	<div id='Pointdiv200h'></div>
</div>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal2">
	<form id="form2" class="stdform" method="post" action="ActionAdd">
	<input type="hidden" name="typ" value="UserType" />
	<input type="hidden" name="backto" value="UserType" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Add User Type</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1">Type Name:</div>
						<div class="col-2"><input type="text" name="u_type" id="" placeholder="Ex: Suppoer, Manager etc" class="input-large" required=""/></div>
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
	<div class="pageheader">
        <div class="searchbar">
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: green;border: 1px solid green;font-size: 14px;" href="AppSettings">Application Settings</a>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;font-size: 14px;" href="UserAccess">Menu Access</a>
			<a class="btn" style="border-radius: 3px;text-transform: uppercase;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;color: red;border: 1px solid red;font-size: 14px;" href="UserAccessPage">Advance Access</a>
			<a class="btn ownbtn2" href="#myModal2" data-toggle="modal"><i class="iconfa-plus"></i> Add</a>
        </div>
        <div class="pageicon"><i class="iconfa-group"></i></div>
        <div class="pagetitle">
            <h1>User Type</h1>
        </div>
    </div><!--pageheader-->	
	<?php if($sts == 'UserType') {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> New User Type Successfully Inserted.
		</div><!--alert-->
	<?php } ?>
	<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<div class="box box-primary">
			<div class="box-header">
				User Type List
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
							<th class="head0">Type ID</th>
                            <th class="head0">Type Name</th>
							<th class="head0 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT * FROM user_typ WHERE sts = '0'");
								while( $row = mysql_fetch_assoc($sql) )
								{
									if($row['type_id'] > 1011){
										$dellygi = "<li><form href='#myModal345345a' data-toggle='modal' title='Edit'><button type='submit' value='{$row['id']}' class='btn ownbtn3' style='padding: 6px 9px;' onClick='getRoutePoint1aa(this.value)'><i class='iconfa-edit'></i></button></form></li>";
									}
									else{
										$dellygi = "";
									}
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;font-size: 18px;'>{$row['type_id']}</td>
											<td style='font-weight: bold;font-size: 15px;'>{$row['u_des']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
												{$dellygi}
												</ul>
											</td>
										</tr>\n";
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

		function getRoutePoint1aa(afdId) {		
		
		var strURL="user-typeee.php?typeid="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv200h').innerHTML=req.responseText;						
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