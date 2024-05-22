<?php
$titel = "Expanse Type";
$Expanse = 'active';
include('include/hader.php');
include("conn/connection.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Expanse' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '41' AND $user_type = '1'");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(201, $access_arry) || in_array(202, $access_arry) || in_array(203, $access_arry) ||in_array(204, $access_arry)){
//---------- Permission -----------
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal345345">
	<div id='Pointdiv1'></div>
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form class="stdform" method="post" action="ExpanseHeadSave" name="form" enctype="multipart/form-data">
	<input type="hidden" value="add" name="wayyy" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> Add New Expense Type </h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">Expense Type</div>
							<div class="col-2"><input type="text" name="ex_type" required="" id="" class="input-xlarge" placeholder="Ex: Mobile Bill" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Type Discription</div>
							<div class="col-2"><input type="text" name="ex_des" id="" class="input-xlarge" placeholder="Discription" /></div>
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
			<a class="btn ownbtn12" onclick="history.back()"><i class="iconfa-arrow-left"></i> Back</a>
		<?php if(in_array(202, $access_arry)){?>
			<a class="btn ownbtn2" href="#myModal" data-toggle="modal">Add Expense Type</a>
		<?php } ?>
        </div>
        <div class="pageicon"><i class="iconfa-signout"></i></div>
        <div class="pagetitle">
            <h1>Expense Type</h1>
        </div>
    </div><!--pageheader-->					<?php if($sts == 'delete') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Deleted in Your System.			</div><!--alert-->		<?php } if($sts == 'add') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Added in Your System.			</div><!--alert-->		<?php } if($sts == 'edit') {?>			<div class="alert alert-success">				<button data-dismiss="alert" class="close" type="button">&times;</button>				<strong>Success!!</strong> <?php echo $titel;?> Successfully Edited in Your System.			</div><!--alert-->		<?php } ?>		
		<?php if(in_array(201, $access_arry)){?>
		<div class="box box-primary">
			<div class="box-header">
				Expense Type List
			</div>
			<div class="box-body">
				<table id="dyntable" class="table table-bordered responsive">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr  class="newThead">
							<th class="head0">Expense ID</th>
                            <th class="head1">Expense Type</th>
                            <th class="head0">Discripsion</th>
							<th class="head1 center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
							$sql = mysql_query("SELECT id, ex_type, ex_des FROM `expanse_type` WHERE status = '0' AND id != '1' AND id != '2' ORDER BY id ASC");
								while( $row = mysql_fetch_assoc($sql) )
								{
									$queryaaaa = mysql_query("SELECT COUNT(id) AS expcount FROM expanse WHERE type = '{$row['id']}'");
									$rowaaaa = mysql_fetch_assoc($queryaaaa);

									$expcount = $rowaaaa['expcount'];
									if($expcount == '0' && in_array(202, $access_arry)){
										$aaa = "<form action='ExpanseHeadSave' method='post' style='margin-top: 4px;' onclick='return checkDelete()'><input type='hidden' name='ex_id' value='{$row['id']}'/><input type='hidden' name='e_id' value='{$e_id}'/><input type='hidden' name='wayyy' value='delete'/><button class='btn ownbtn4' style='padding: 6px 9px;' data-placement='top' data-rel='tooltip' title='Delete'><i class='iconfa-trash'></i></button></form>";
									}
									else{
										$aaa = '';
									}
									if(in_array(203, $access_arry)){
										$bbb = "<form href='#myModal345345' data-toggle='modal'><button type='submit' value='{$e_id}&ex_id={$row['id']}' class='btn ownbtn2' style='border-radius: 3px;text-transform: uppercase;padding: 6px 9px;' onClick='getRoutePoint(this.value)' title='Edit'/><i class='iconfa-edit'></i></button></form>";
									}
									else{
										$bbb = '';
									}
									echo
										"<tr class='gradeX'>
											<td style='font-weight: bold;'>{$row['id']}</td>
											<td><b>{$row['ex_type']}</b></td>
											<td>{$row['ex_des']}</td>
											<td class='center'>
												<ul class='tooltipsample'>
													<li>{$bbb}</li>
													<li>{$aaa}</li>
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
}}
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
			"iDisplayLength": 100,
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
		
		var strURL="ExpenseTypeEdit.php?e_id="+afdId;
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