<?php
$titel = "Edit Invoice Client";
$Clients = 'active';
include('include/hader.php');
include("conn/connection.php") ;
extract($_POST); 

ini_alter('date.timezone','Asia/Almaty');
//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Clients' AND $user_type = '1'");
$access1 = mysql_query("SELECT * FROM module_page WHERE parent_id = '8' AND $user_type in (1,2)");
if(mysql_num_rows($access) > 0 && mysql_num_rows($access1) > 0 && in_array(101, $access_arry)){
//---------- Permission -----------

$sqlf = ("SELECT c.c_name, c.com_id, c.invoice_date, c.due_deadline, l.id, c.z_id, l.nid_fond, l.nid_back, c.latitude, c.longitude, c.extra_bill, l.image, c.pop, c.onu_mac, c.edit_sts, c.father_name, c.bill_man, c.old_address, c.flat_no, c.house_no, c.road_no, z.z_name, c.technician, c.previous_isp, c.box_id, c.calculation, c.breseller, c.total_price, l.e_id AS userid, l.pw, c.b_date, c.mk_id, m.Name AS mk_name, m.ServerIP, c.cell, cell1, cell2, cell3, cell4, c.occupation, c.email, p_m, c.address, c.thana, c.join_date, c.opening_balance, c.con_type, c.connectivity_type, c.mac, c.cable_sts, c.con_sts, c.req_cable, c.cable_type, c.nid, c.p_id, c.signup_fee, c.note, c.agent_id, c.com_percent, c.count_commission FROM clients AS c
		LEFT JOIN zone AS z	ON z.z_id = c.z_id
		LEFT JOIN mk_con AS m ON m.id = c.mk_id
		LEFT JOIN login AS l ON l.e_id = c.c_id
		WHERE c.c_id ='$c_id' ");

$queryf = mysql_query($sqlf);
$row = mysql_fetch_assoc($queryf);
		if($row['image'] == ''){
			$image = 'emp_images/no_img.jpg';
		}
		else{
			$image= $row['image'];
		}
		if($row['nid_fond']==''){
			$nid_fondd = 'images/no_nid.png';
		}
		else{
			$nid_fondd = $row['nid_fond'];
		}
		if($row['nid_back']==''){
			$nid_backk = 'images/no_nid.png';
		}
		else{
			$nid_backk = $row['nid_back'];
		}
		$c_name= $row['c_name'];
		$com_id= $row['com_id'];
		$z_id= $row['z_id'];
		$z_name = $row['z_name'];
		$father_name = $row['father_name'];
		$occupation = $row['occupation'];
		$cell= $row['cell'];
		$cell1= $row['cell1'];
		$cell2= $row['cell2'];
		$cell3= $row['cell3'];
		$cell4= $row['cell4'];
		$opening_balance = $row['opening_balance'];
		$email= $row['email'];
		$address= $row['address'];
		$old_address= $row['old_address'];
		$thana= $row['thana'];
		$previous_isp= $row['previous_isp'];
		$join_date= $row['join_date'];
		$con_type= $row['con_type'];
		$connectivity_type= $row['connectivity_type'];
		$mac= $row['mac'];
		$cable_sts= $row['cable_sts'];
		$con_sts= $row['con_sts'];
		$req_cable= $row['req_cable'];
		$cable_type= $row['cable_type'];
		$nid= $row['nid'];
		$signup_fee= $row['signup_fee'];
		$note= $row['note'];
		$p_m = $row['p_m'];
		$mk_name = $row['mk_name'];
		$ServerIP = $row['ServerIP'];
		$pop = $row['pop'];
		$pw = $row['pw'];
		$mk_id = $row['mk_id'];
		$lid = $row['id'];
		$invoice_date = $row['invoice_date'];
		$due_deadline = $row['due_deadline'];
		$total_price = $row['total_price'];
		$breseller = $row['breseller'];
		$box_id = $row['box_id'];
		$technician = $row['technician'];
		$bill_man = $row['bill_man'];
		$edit_sts = $row['edit_sts'];
		$flat_no = $row['flat_no'];
		$house_no = $row['house_no'];
		$road_no = $row['road_no'];
		$onu_mac = $row['onu_mac'];
		$agent_id = $row['agent_id'];
		$com_percent = $row['com_percent'];
		$count_commission = $row['count_commission'];
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		
$resultwwwa = mysql_query("SELECT latitude, longitude FROM zone WHERE z_id = '$z_id'");
$row2aa = mysql_fetch_assoc($resultwwwa);
$z_latitude = $row2aa['latitude'];
$z_longitude = $row2aa['longitude'];

if($cable_type == 'FIBER' && $client_use_diagram_client == '1'){
$sql2 ="SELECT * FROM network_tree WHERE c_id = '$c_id'";

$query2 = mysql_query($sql2);
$row2 = mysql_fetch_assoc($query2);
$tree_id = $row2['tree_id'];
$parent_id = $row2['parent_id'];
$in_port = $row2['in_port'];
$in_color = $row2['in_color'];
$fiber_code = $row2['fiber_code'];
}
?>
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal21" style="left: 35%;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div id="googleMap" style="width:170%;height:500px;"></div>
		</div>
	</div>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
	<form class="stdform" method="post" action="ClientPPPoEPass" name="form" enctype="multipart/form-data">
		<input type="hidden" name="c_id" value="<?php echo $c_id;?>" />
		<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
		<input type="hidden" name="lid" value="<?php echo $lid;?>" />
		<input type="hidden" name="cell" value="<?php echo $cell;?>" />
		<input type="hidden" name="breseller" value="<?php echo $breseller;?>" />
		<input type="hidden" name="passway" value="tis" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> Change PPPoE Password from <?php echo $mk_name;?></h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">Old Password</div>
							<div class="col-2"><input type="text" readonly required="" id="" value="<?php echo $pw;?>" class="input-xlarge"/></div>
						</div>
						<div class="popdiv">
							<div class="col-1">New Password</div>
							<div class="col-2"><input type="text" name="pass1" required="" id="" class="input-xlarge" placeholder="Type 6 Digit New Password" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Retype Password</div>
							<div class="col-2"><input type="text" name="pass2" id="" class="input-xlarge" placeholder="Type 6 Digit New Password Again" /></div>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal101">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $lid;?>"/>
		<input type="hidden" name="c_id" value="<?php echo $c_id;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="backway" value="ClientEditInvoice" />
		<input type="hidden" name="imgway" value="main_img" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> Change Picture</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">Choose Image</div>
							<div class="col-2">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-append">
										<div class="uneditable-input span2" style="height: 18px;">
											<i class="iconfa-file fileupload-exists"></i>
											<span class="fileupload-preview"></span>
										</div>
										<span class="btn btn-file">
											<span class="fileupload-new">Select Image</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" class="file-input" name="file-input" onchange="readURL(this);">
										</span>
										<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
								</div>
							</div>
						</div>
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2" style="text-align: center;"><img id="blah" src="<?php echo $image;?>" alt="" style="width: 150px;height: 150px;"/></div>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal103">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $lid;?>"/>
		<input type="hidden" name="c_id" value="<?php echo $c_id;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="backway" value="ClientEditInvoice" />
		<input type="hidden" name="imgway" value="nid_fond" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Change National ID Card Picture</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">National ID Front Side</div>
							<div class="col-2">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-append">
										<div class="uneditable-input span2" style="height: 18px;">
											<i class="iconfa-file fileupload-exists"></i>
											<span class="fileupload-preview"></span>
										</div>
										<span class="btn btn-file">
											<span class="fileupload-new">Select Image</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" class="file-input" name="file-input" onchange="readURL1(this);">
										</span>
										<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
								</div>
							</div>
						</div>
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2" style="text-align: center;"><img id="blah1" src="<?php echo $nid_fondd;?>" alt="" style="width: 180px;height: 100px;"/></div>
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
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal104">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $lid;?>"/>
		<input type="hidden" name="c_id" value="<?php echo $c_id;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="backway" value="ClientEditInvoice" />
		<input type="hidden" name="imgway" value="nid_back" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5">Change National ID Card Picture</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">National ID Back Side</div>
							<div class="col-2">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-append">
										<div class="uneditable-input span2" style="height: 18px;">
											<i class="iconfa-file fileupload-exists"></i>
											<span class="fileupload-preview"></span>
										</div>
										<span class="btn btn-file">
											<span class="fileupload-new">Select Image</span>
											<span class="fileupload-exists">Change</span>
											<input type="file" class="file-input" name="file-input" onchange="readURL2(this);">
										</span>
										<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
									</div>
								</div>
							</div>
						</div>
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2" style="text-align: center;"><img id="blah2" src="<?php echo $nid_backk;?>" alt="" style="width: 180px;height: 100px;"/></div>
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
				<a class="btn ownbtn12" onclick="history.back()" style="float: left;margin-right: 2px;"><i class="iconfa-arrow-left"></i> Back</a>
				<form action='ClientEditMonthlyInvoice' method='post' data-placement='top' data-rel='tooltip' title='Edit Monthy Invoice & Transmission' style="float: left;padding-right: 3px;"><input type='hidden' name='c_id' value='<?php echo $c_id;?>'/><button class='btn ownbtn4'>Invoice & Transmission</form>
        </div>
        <div class="pageicon"><i class="iconfa-user"></i></div>
        <div class="pagetitle">
            <h1>Edit Invoice Client</h1>
        </div>
    </div><!--pageheader-->
	
		<?php if('invoicechange' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Monthly Invoice Change Successfully.
			</div><!--alert-->
		<?php } if(('picchange' == (isset($_POST['sts']) ? $_POST['sts'] : '')) && ('No' == (isset($_POST['response']) ? $_POST['response'] : ''))) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> New Picture Successfully Added.
			</div><!--alert-->
		<?php } if(('picchange' == (isset($_POST['sts']) ? $_POST['sts'] : '')) && ('Yes' == (isset($_POST['response']) ? $_POST['response'] : ''))) {?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Error!!</strong> <?php echo $message;?>
			</div><!--alert-->
		<?php } if('mk' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Password Successfully Change from Network.
		</div>
		<!--alert-->
		<?php } if('tis' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Password Successfully Change from This Application.
		</div>
		<!--alert-->
		<?php } if('both' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
		<div class="alert alert-success">
			<button data-dismiss="alert" class="close" type="button">&times;</button>
			<strong>Success!!</strong> Password Successfully Change from Network and This Application.
		</div>
		<!--alert-->
		<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Edit Client Informations</h5>
				</div>
				<form class="stdform" method="post" action="ClientEditQuery" name="form">
					<input type="hidden" name="c_id" value="<?php echo $c_id;?>" />
					<input type="hidden" name="edit_by" value="<?php echo $e_id;?>" />
					<input type="hidden" name="edit_date" value="<?php echo date('Y-m-d', time());?>" />
					<input type="hidden" name="edit_time" value="<?php echo date('H:i:s', time());?>" />
					<div class="modal-body" style="overflow: hidden;padding-bottom: 0px;">
						<div style="float: left;width: 50%;">
								<p>
									<label style="width: 130px;font-weight: bold;">Zone Name*</label>
									<select name="z_id" class="chzn-select"  style="width:250px;" required="" onChange="getRoutePoint(this.value)">		
										<?php 
											$queryd="SELECT * FROM zone WHERE status = '0' AND e_id = '' order by z_name";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>			
											<option value=<?php echo $rowd['z_id'];?> <?php if ($rowd['z_id'] == $z_id) echo 'selected="selected"';?> ><?php echo $rowd['z_name'];?> (<?php echo $rowd['z_bn_name'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label style="width: 130px;">Box</label>
									<div id="Pointdiv1">
									<select name="box_id" class="chzn-select"  style="width:250px;">	
										<option value="">Select Box</option>									
										<?php 
											$querydd="SELECT * FROM box WHERE z_id = '$z_id'";
											$resultdd=mysql_query($querydd);
										while ($rowdd=mysql_fetch_array($resultdd)) { ?>			
											<option value=<?php echo $rowdd['box_id'];?> <?php if ($rowdd['box_id'] == $box_id) echo 'selected="selected"';?> ><?php echo $rowdd['box_id'];?> - <?php echo $rowdd['b_name'];?> (<?php echo $rowdd['location'];?> - <?php echo $rowdd['b_port'];?>)</option>		
										<?php } ?>
									</select>
									</div>
								</p>
								<p>
									<label style="width: 130px;">Network*</label>
									<select name="mk_id" class="chzn-select"  style="width:250px;">		
										<?php 
											$querydt="SELECT * FROM mk_con WHERE sts = '0'";
											$resultdt=mysql_query($querydt);
										while ($rowdt=mysql_fetch_array($resultdt)) { ?>			
											<option value=<?php echo $rowdt['id'];?> <?php if ($rowdt['id'] == $mk_id) echo 'selected="selected"';?> ><?php echo $rowdt['Name'];?> (<?php echo $rowdt['ServerIP'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label style="width: 130px;">POP</label>
									<span class="field" style="margin-left: 0px;"><input type="text" class="input-xxlarge" name="pop" style="width:240px;" value="<?php echo $pop;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Payment Method*</label>
									<span class="field" style="margin-left: 0px;">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:250px;"/>
											<option value="Home Cash"<?php if ('Home Cash' == $p_m) echo 'selected="selected"';?>>Cash from Home</option>
											<option value="Cash"<?php if ('Cash' == $p_m) echo 'selected="selected"';?>>Cash</option>
											<option value="Officeh"<?php if ('Office' == $p_m) echo 'selected="selected"';?>>Office</option>
											<option value="bKash"<?php if ('bKash' == $p_m) echo 'selected="selected"';?>>bKash</option>
											<option value="Rocket"<?php if ('Rocket' == $p_m) echo 'selected="selected"';?>>Rocket</option>
											<option value="iPay"<?php if ('iPay' == $p_m) echo 'selected="selected"';?>>iPay</option>
											<option value="Card"<?php if ('Card' == $p_m) echo 'selected="selected"';?>>Card</option>
											<option value="Bank"<?php if ('Bank' == $p_m) echo 'selected="selected"';?>>Bank</option>
											<option value="Corporate"<?php if ('Corporate' == $p_m) echo 'selected="selected"';?>>Corporate</option>
										</select>
									</span>
								</p>
								<p>
									<label style="width: 130px;">Signup Fee</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="signup_fee" placeholder="Ex: 1200" style="width:240px;" id="" class="input-xxlarge" <?php if ($mac_user == '1'){ echo 'readonly';} else{} ?> value="<?php echo $signup_fee;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Type of Client</label>
										<span class="field" style="margin-left: 0px;">
											<select class="chzn-select" name="con_type" style="width:250px;">
												<option  value="Home" <?php if ('Home' == $con_type) echo 'selected="selected"';?>>Home</option>
												<option  value="Corporate" <?php if ('Corporate' == $con_type) echo 'selected="selected"';?>>Corporate</option>
												<option  value="Others" <?php if ('Others' == $con_type) echo 'selected="selected"';?>>Others</option>
											</select>
										</span>	
								</p>
								<p>
									<label style="width: 130px;">Type of Connectivity</label>
										<span class="field" style="margin-left: 0px;">
											<select class="chzn-select" name="connectivity_type" style="width:250px;">
												<option  value="Shared" <?php if ('Shared' == $connectivity_type) echo 'selected="selected"';?>>Shared</option>
												<option  value="Dedicated" <?php if ('Dedicated' == $connectivity_type) echo 'selected="selected"';?>>Dedicated</option>
											</select>
										</span>	
								</p>
								<p>
									<label style="width: 130px;">MAC Address</label>
									<span class="field" style="margin-left: 0px;"><input type="text" class="input-xxlarge" name="mac" style="width:150px;" value="<?php echo $mac;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Connection Mode</label>
									<span class="field" style="margin-left: 0px;"><input type="text" style="width:240px;" class="input-xxlarge" readonly value="<?php echo $con_sts;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Cable Type</label>
									<span class="field" style="margin-left: 0px;">
										<select class="chzn-select" name="cable_type" style="width:250px;" onChange="getRoutePoint11(this.value)">
											<option>Choose Cable Type</option>
											<option  value="UTP" <?php if ('UTP' == $cable_type) echo 'selected="selected"';?>>UTP</option>
											<option  value="FIBER" <?php if ('FIBER' == $cable_type) echo 'selected="selected"';?>>FIBER</option>
										</select>
									</span>
								</p>
								<div id="Pointdiv">
					<?php if($cable_type == 'FIBER' && $client_use_diagram_client == '1'){?>
					<div style="border:1px solid #bbbbbb70;">
						<center><b style="color: #ff0000b8;">..............::::::::::[ Network Diagram Informations ]::::::::::..............</b></center>
						<input type="hidden" style="width:240px;" name="diagram_way" class="input-xlarge" value="<?php echo $client_use_diagram_client;?>"/>
						<p>
							<label style="width: 130px;font-weight: bold;">ONU MAC*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="onu_mac" placeholder="Ex: A1:B2:C3:EF:G5:67" style="width:240px;" required="" value="<?php echo $onu_mac;?>"/></span>
						</p>
						<p>	
						<label style="width: 130px;font-weight: bold;">LineIn Source*</label>
						<select class="select-ext-large chzn-select" style="width:250px;" name="parent_id" required="" >
								<option value="">Choose Source</option>
								<?php $insorce=mysql_query("SELECT n.tree_id, n.parent_id, n.out_port, n.fiber_code, n.z_id, n.device_type, d.d_name, n.name, n.location, z.z_id, z.z_name FROM network_tree AS n 
												LEFT JOIN device AS d ON d.id = n.device_type
												LEFT JOIN zone AS z ON z.z_id = n.z_id
												WHERE n.sts = '0' AND n.device_sts = '0' AND n.device_type = '2' or n.device_type = '3' or n.device_type = '6' or n.device_type = '8' ORDER BY n.tree_id ASC");
										while ($enr=mysql_fetch_array($insorce)) { ?>
										<option value="<?php echo $enr['tree_id'];?>"<?php if ($enr['tree_id'] == $parent_id) echo 'selected="selected"';?>><?php echo $enr['tree_id'];?> - <?php echo $enr['name'];?> ( <?php echo $enr['tree_id'];?> - <?php echo $enr['d_name'];?> - <?php echo $enr['out_port'];?> )</option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label style="width: 130px;font-weight: bold;">Source Core Color*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="in_color" value="<?php echo $in_color;?>" id="" style="width:240px;" required="" placeholder="Ex: Blue, Red etc" /></span>
						</p>
						<p>
							<label style="width: 130px;font-weight: bold;">Source Core No*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="in_port" id="" value="<?php echo $in_port;?>" style="width:15%;" required=""/></span>
						</p>
						<p>
							<label style="width: 130px;">Fiber Code</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="fiber_code" id="" value="<?php echo $fiber_code;?>" style="width:15%;"/></span>
						</p>
					</div>
						<?php } if($cable_type == 'FIBER' && $client_use_diagram_client == '0'){?>
						<input type="hidden" style="width:240px;" name="diagram_way" class="input-xlarge" value="<?php echo $client_use_diagram_client;?>"/>
						<p>
							<label style="width: 130px;font-weight: bold;">ONU MAC*</label>
							<span class="field" style="margin-left: 0px;"><input type="text" name="onu_mac" placeholder="Ex: A1:B2:C3:EF:G5:67" style="width:240px;" required="" value="<?php echo $onu_mac;?>"/></span>
						</p>
						<?php } ?>
								</div>
								<p>
									<label style="width: 130px;">Require Cable</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="req_cable" style="width:240px;" placeholder="Ex: 200ft" id="" class="input-xxlarge" value="<?php echo $req_cable;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Cable Status</label>
									<span class="formwrapper" style="margin-left: 0px";>
										<input type="radio" name="cable_sts" value="Not Remove" <?php if ('Not Remove' == $cable_sts) echo 'checked="checked"';?>> Not Remove &nbsp;
										<input type="radio" name="cable_sts" value="Removed" <?php if ('Removed' == $cable_sts) echo 'checked="checked"';?>> Removed &nbsp;
										<input type="radio" name="cable_sts" value="Under Process" <?php if ('Under Process' == $cable_sts) echo 'checked="checked"';?>> Processing
									</span>
								</p>
								<p>
									<label style="width: 130px;">National ID</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="nid" style="width:240px;" placeholder="Ex: 123456789" id="" class="input-xxlarge" value="<?php echo $nid;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Bill Man</label>
									<select name="bill_man" class="chzn-select"  style="width:250px;">	
										<option value=""></option>
										<?php 
											$querydqee="SELECT * FROM emp_info WHERE mk_id = '' order by id ASC";
											$resultdqdd=mysql_query($querydqee);
										while ($rowdqdd=mysql_fetch_array($resultdqdd)) { ?>			
											<option value=<?php echo $rowdqdd['e_id'];?> <?php if ($rowdqdd['e_id'] == $bill_man) echo 'selected="selected"';?> ><?php echo $rowdqdd['e_name'];?> (<?php echo $rowdqdd['e_id'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label style="width: 130px;">Technician</label>
									<select name="technician" class="chzn-select"  style="width:250px;">	
										<option value=""></option>
										<?php 
											$querydq="SELECT * FROM emp_info WHERE mk_id = '' order by id ASC";
											$resultdq=mysql_query($querydq);
										while ($rowdq=mysql_fetch_array($resultdq)) { ?>			
											<option value=<?php echo $rowdq['e_id'];?> <?php if ($rowdq['e_id'] == $technician) echo 'selected="selected"';?> ><?php echo $rowdq['e_name'];?> (<?php echo $rowdq['e_id'];?>)</option>		
										<?php } ?>
									</select>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Note</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="note" placeholder="Optional" style="width:240px;" id="" class="input-xxlarge"/><?php echo $note;?></textarea></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Joining Date</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="join_date" id="" style="width:240px;" class="input-xxlarge datepicker" required="" value="<?php echo $join_date;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Client Can Edit?</label>
									<span class="formwrapper" style="margin-left: 0px";>
										<input type="radio" name="edit_sts" value="0" <?php if ('0' == $edit_sts) echo 'checked="checked"';?>> Yes &nbsp;
										<input type="radio" name="edit_sts" value="1" <?php if ('1' == $edit_sts) echo 'checked="checked"';?>> No &nbsp;
									</span>
								</p>
								<p>
									<label style="width: 130px;">Change Photo</label>
									<span class="formwrapper" style="margin-left: 0px";>
										<button class="btn ownbtn2" href="#myModal101" data-toggle="modal"> Client Photo</button>
									</span>
								</p>
								<p>
									<label style="width: 130px;">NID IMG</label>
									<span class="formwrapper" style="margin-left: 0px";>
										<button class="btn ownbtn3" href="#myModal103" data-toggle="modal"> NID Front Photo</button>
										<button class="btn ownbtn3" href="#myModal104" data-toggle="modal"> NID Back Photo</button>
									</span>
								</p>
						</div>
						
						<div style="margin-left: 48%;">
								<p>
									<label style="width: 130px;font-weight: bold;">Company ID*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="com_id" id="" <?php if($edit_last_id == '0'){?>readonly<?php }?> required="" style="width:140px;" class="input-xxlarge" value="<?php echo $com_id;?>"/></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Client Name*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="c_name" id="" style="width:240px;" class="input-xxlarge" value="<?php echo $c_name;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Login ID</label>
									<span class="field" style="margin-left: 0px;"><input type="text" readonly class="input-xxlarge" style="width:240px;" value="<?php echo $c_id;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Password</label>
									<span class="field" style="margin-left: 0px;"><input type="text" readonly class="input-xxlarge" style="width:240px;" value="<?php echo $pw;?>" /></span>
								</p>
								<?php if(in_array(127, $access_arry)){ ?>
								<p>
									<label style="width: 130px;"></label>
									<span class="field" style="margin-left: 0px;">
										<button class="btn ownbtn4" href="#myModal" data-toggle="modal"> Change Password</button>
									</span>
								</p>
								<?php }?>
								<p>
									<label style="width: 130px;">Father's Name</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="father_name" id="" style="width:240px;" value="<?php echo $father_name;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;font-weight: bold;">Cell No*</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="cell" style="width:240px;" placeholder="Cell No" id="" class="input-xxlarge" value="<?php if ($cell == ''){echo '88';}else{echo $cell;}?>" required=""/></span>
								</p>
								
								<p>
									<label style="width: 130px;">Alternative Cell No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="cell1" style="width:240px;" placeholder="Cell No" id="" class="input-xxlarge" value="<?php echo $cell1;?>" /></span>
								</p>
								<p>
									<label style="width: 130px">Flat No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="flat_no" id="" class="input-xxlarge" style="width:140px;" value="<?php echo $flat_no;?>" /></span>
								</p>
								<p>
									<label style="width: 130px">House No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="house_no" id="" class="input-xxlarge" style="width:140px;" value="<?php echo $house_no;?>" /></span>
								</p>
								<p>
									<label style="width: 130px">Road No</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="road_no" id="" class="input-xxlarge" style="width:140px;" value="<?php echo $road_no;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Present Address</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="address" style="width:240px;" id="" class="input-xxlarge"/><?php echo $address; ?></textarea></span>
								</p>
								<p>
									<label style="width: 130px;">Permanent Address</label>
									<span class="field" style="margin-left: 0px;"><textarea type="text" name="old_address" id="" style="width:240px;" class="input-xxlarge"/><?php echo $old_address; ?></textarea></span>
								</p>
								<p>
									<label style="width: 130px;">Thana</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="thana" id="" style="width:240px;" class="input-xxlarge" value="<?php echo $thana;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Occupation</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="occupation" style="width:240px;" placeholder="" id="" class="input-xxlarge" value="<?php echo $occupation;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Email</label>
									<span class="field" style="margin-left: 0px;"><input type="text" name="email" style="width:240px;" id="" placeholder="Ex: abcd@domain.com" class="input-xxlarge" value="<?php echo $email;?>" /></span>
								</p>
								<p>
									<label style="width: 130px;">Agent</label>
									<select name="agent_id" class="chzn-select" style="width:240px;" onChange="getRoutePoint111(this.value)">	
										<option value="0">--None--</option>		
										<?php 
											$queryd="SELECT * FROM agent WHERE sts = '0' order by e_name ASC";
											$resultd=mysql_query($queryd);
										while ($rowd=mysql_fetch_array($resultd)) { ?>
											
											<option value=<?php echo $rowd['e_id'];?> <?php if ($rowd['e_id'] == $agent_id) echo 'selected="selected"';?> ><?php echo $rowd['e_name'];?> (<?php echo $rowd['com_percent'];?>%)</option>		
										<?php } ?>
									</select>
								</p>
								<div id="Pointdiv100">
								
								<?php if($agent_id != '0'){?>
									<p>
										<label style="width: 130px;">Manual Commission</label>
										<span class="field" style="margin-left: 0px;"><input type="text" name="com_percent" style="width:10%;" required="" value="<?php echo $com_percent;?>"/><input type="text" name="" id="" style="width:5%; color:#2e3e4e; font-weight: bold;font-size: 17px;margin-right: 5px;border-left: 0px solid;" value='%' readonly /></span>
									</p>
									<p>
										<label style="width: 130px;">Count Commission?</label>
										<span class="formwrapper" style="margin-left: 0px";>
											<input type="radio" name="count_commission" value="1" <?php if ('1' == $count_commission) echo 'checked="checked"';?>> Yes &nbsp; &nbsp;
											<input type="radio" name="count_commission" value="0" <?php if ('0' == $count_commission) echo 'checked="checked"';?>> No &nbsp; &nbsp;
										</span>
									</p>
								<?php } ?>
								
								</div>
								<?php if($tree_sts_permission == '0'){ ?>
								<p>
									<label style="width: 130px;"></label>
									<span class="field" style="margin-left: 0px;">
										<div class="input-append">
											<p id="latitude"><input type="text" name="latitude" readonly placeholder="Map Latitude" value="<?php echo $latitude;?>" class="span2"></p>
											<p id="longitude"><input type="text" name="longitude" readonly placeholder="Map Longitude" value="<?php echo $longitude;?>" class="span2"></p>
										</div>
									<a data-placement='top' data-rel='tooltip' href='#myModal21' class='btn btn-circle' data-toggle="modal" style="border-radius: 15%;padding: 10px;width: 6%;margin-left: 10px;"><i class='iconfa-map-marker' style="font-size: 35px;"></i></a>
									</span>
								</p>
								<?php } else{ ?><input type="hidden" id="" name="latitude" placeholder="" value="<?php echo $latitude;?>"><input type="hidden" id="" name="longitude" placeholder="" value="<?php echo $longitude;?>"><?php } ?>
                        </div>
					</div>             
						<div class="modal-footer">
							<button type="reset" class="btn ownbtn11">Reset</button>
							<button class="btn ownbtn2" type="submit">Submit</button>
						</div>
				</form> <!-- END OF DEFAULT WIZARD -->
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
		
		var strURL="findzonebox.php?z_id="+afdId;
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
	

	function getRoutePoint11(afdId) {		
		
		var strURL="onu_mac.php?cable_type="+afdId+"&c_id="+'<?php echo $c_id;?>';
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
	
	function getRoutePoint111(afdId) {		
		
		var strURL="agent_commission_clients.php?agent_id="+afdId;
		var req = getXMLHTTP();
		
		if (req) {
			
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('Pointdiv100').innerHTML=req.responseText;						
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
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Remove Photo!!  Are you sure?');
}

     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(150);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
		
     function readURL1(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1')
                        .attr('src', e.target.result)
                        .width(180)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
		
     function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah2')
                        .attr('src', e.target.result)
                        .width(180)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>
<?php if($latitude == '' && $longitude == ''){?>
<script>
var latitude = document.getElementById("latitude");
var longitude = document.getElementById("longitude");
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(<?php if($z_latitude == ''){echo $copmaly_latitude;}else{echo $z_latitude;}?>, <?php if($z_longitude == ''){echo $copmaly_longitude;}else{echo $z_longitude;}?>),
    zoom:17,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
 });

google.maps.event.addListener(map, 'click', function(event) {
//alert(event.latLng.lat() + ", " + event.latLng.lng());
latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
});

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&libraries&callback=myMap"></script>
<?php } else{?>
<script type="text/javascript">
function my_map_add() {
var myMapCenter = new google.maps.LatLng(<?php echo $latitude;?>, <?php echo $longitude;?>);
var myMapProp = {center:myMapCenter, zoom:16, mapTypeId:google.maps.MapTypeId.ROADMAP};
var map = new google.maps.Map(document.getElementById("googleMap"),myMapProp);
var marker = new google.maps.Marker({position:myMapCenter});
marker.setMap(map);

 google.maps.event.addListener(map, 'click', function(event) {
     marker = new google.maps.Marker({position: event.latLng, map: map});
     console.log(event.latLng);   // Get latlong info as object.
     console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng()); // Get separate lat long.
 });

google.maps.event.addListener(map, 'click', function(event) {
//alert(event.latLng.lat() + ", " + event.latLng.lng());
latitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map Latitude' readonly name='latitude' value='" + event.latLng.lat() + "'/>";
longitude.innerHTML = "<input type='text' class='span2' placeholder='Google Map longitude' readonly name='longitude' value='" + event.latLng.lng() + "'/>";
});
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gapikey;?>&libraries&callback=my_map_add"></script>
<?php } ?>

