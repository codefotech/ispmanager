<?php
$titel = "Edit Profile";
include('include/hader.php');
include("conn/connection.php") ;
$id = $_SESSION['SESS_MEMBER_ID'];
extract($_POST); 

$sql = ("SELECT l.id, l.user_name, l.e_id, l.user_id, l.pw, l.password, l.email, l.user_type, l.image, u.u_des FROM login AS l LEFT JOIN user_typ AS u ON u.u_type = l.user_type WHERE l.id = '$id'");
$query = mysql_query($sql);
$row = mysql_fetch_assoc($query);
		$idssss= $row['id'];
		$user_name= $row['user_name'];
		$e_id = $row['e_id'];
		$user_id = $row['user_id'];
		$password = sha1($row['password']);
		$emaill= $row['email'];
		$user_type= $row['user_type'];
		$u_des= $row['u_des'];
		$image= $row['image'];
		if($image==''){
			$image = 'emp_images/no_img.jpg';
		}
if($user_type == 'client' || $user_type == 'breseller'){
	$sqlf = mysql_query("SELECT c.c_name, l.id, c.z_id, p.p_price_reseller, c.extra_bill, b.b_name, c.edit_sts, c.terms, l.nid_fond, l.nid_back, c.father_name, c.bill_man, c.old_address, z.z_name, c.technician, c.termination_date,
	c.box_id, c.raw_download, c.calculation, c.breseller, c.raw_upload, c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.total_price, 
	l.e_id AS userid, l.pw, c.b_date, c.mk_id, m.Name AS mk_name, m.ServerIP, c.cell, cell1, cell2, cell3, cell4, mac_user, payment_deadline, c.occupation, c.email, 
	p_m, c.address, c.thana, c.join_date, DATE_FORMAT(c.join_date, '%D %M %Y') AS joinn, c.opening_balance, c.con_type, c.connectivity_type, c.ip, c.mac, c.cable_sts, c.discount, c.con_sts, c.req_cable, c.cable_type, 
	c.nid, c.p_id, p.p_name, p.p_price, p.bandwith, c.signup_fee, c.note FROM clients AS c
		LEFT JOIN zone AS z
		ON z.z_id = c.z_id
		LEFT JOIN box AS b
		ON b.box_id = c.box_id
		LEFT JOIN package AS p
		ON p.p_id = c.p_id 
		LEFT JOIN mk_con AS m
		ON m.id = c.mk_id
		LEFT JOIN login AS l
		ON l.e_id = c.c_id
		WHERE c.c_id ='$e_id' ");
		
$rowsdfs = mysql_fetch_assoc($sqlf);
		$c_name= $rowsdfs['c_name'];
		$z_id= $rowsdfs['z_id'];
		$z_name = $rowsdfs['z_name'];
		$b_name = $rowsdfs['b_name'];
		$father_name = $rowsdfs['father_name'];
		$occupation = $rowsdfs['occupation'];
		if($rowsdfs['nid_fond']==''){
			$nid_fondd = 'images/no_nid.png';
		}
		else{
			$nid_fondd = $rowsdfs['nid_fond'];
		}
		if($rowsdfs['nid_back']==''){
			$nid_backk = 'images/no_nid.png';
		}
		else{
			$nid_backk = $rowsdfs['nid_back'];
		}
		$cell= $rowsdfs['cell'];
		$cell1= $rowsdfs['cell1'];
		$cell2= $rowsdfs['cell2'];
		$cell3= $rowsdfs['cell3'];
		$cell4= $rowsdfs['cell4'];
		$opening_balance = $rowsdfs['opening_balance'];
		$email= $rowsdfs['email'];
		$address= $rowsdfs['address'];
		$old_address= $rowsdfs['old_address'];
		$thana= $rowsdfs['thana'];
		$previous_isp= $rowsdfs['previous_isp'];
		$join_date= $rowsdfs['joinn'];
		$con_type= $rowsdfs['con_type'];
		$mac_user = $rowsdfs['mac_user'];
		$connectivity_type= $rowsdfs['connectivity_type'];
		$ip= $rowsdfs['ip'];
		$mac= $rowsdfs['mac'];
		$cable_sts= $rowsdfs['cable_sts'];
		$con_sts= $rowsdfs['con_sts'];
		$req_cable= $rowsdfs['req_cable'];
		$cable_type= $rowsdfs['cable_type'];
		$nid= $rowsdfs['nid'];
		$p_id= $rowsdfs['p_id'];
		$signup_fee= $rowsdfs['signup_fee'];
		$note= $rowsdfs['note'];
		$discount = $rowsdfs['discount'];
		$p_m = $rowsdfs['p_m'];
		$p_name = $rowsdfs['p_name'];
		if($mac_user == '1'){
			$p_price = ($rowsdfs['p_price_reseller']-$rowsdfs['discount'])+$rowsdfs['extra_bill'];
		}
		else{
			$p_price = ($rowsdfs['p_price']-$rowsdfs['discount'])+$rowsdfs['extra_bill'];
		}
		
		$bandwith = $rowsdfs['bandwith'];
		$mk_name = $rowsdfs['mk_name'];
		$ServerIP = $rowsdfs['ServerIP'];
		$payment_deadline = $rowsdfs['payment_deadline'];
		$b_date = $rowsdfs['b_date'];
		$pw = $rowsdfs['pw'];
		$mk_id = $rowsdfs['mk_id'];
		$lid = $rowsdfs['id'];
		$raw_download = $rowsdfs['raw_download'];
		$youtube_bandwidth = $rowsdfs['youtube_bandwidth'];
		$raw_upload = $rowsdfs['raw_upload'];
		$total_bandwidth = $rowsdfs['total_bandwidth'];
		$bandwidth_price = $rowsdfs['bandwidth_price'];
		$youtube_price = $rowsdfs['youtube_price'];
		$total_price = $rowsdfs['total_price'];
		$breseller = $rowsdfs['breseller'];
		$box_id = $rowsdfs['box_id'];
		$technician = $rowsdfs['technician'];
		$bill_man = $rowsdfs['bill_man'];
		$termination_date = $rowsdfs['termination_date'];
		$edit_sts = $rowsdfs['edit_sts'];
		$terms = $rowsdfs['terms'];
}
		
?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal100">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $idssss;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="passchange" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> Change Password</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1">New Password</div>
							<div class="col-2"><input type="password" name="pass1" required="" id="" class="input-xlarge" placeholder="Type 6 Digit New Password" /></div>
						</div>
						<div class="popdiv">
							<div class="col-1">Retype Password</div>
							<div class="col-2"><input type="password" name="pass2" id="" class="input-xlarge" placeholder="Type 6 Digit New Password Again" /></div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn">Reset</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal101">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $idssss;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="imgway" value="main_img" />
		<input type="hidden" name="backway" value="" />
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
					<button type="reset" class="btn">Reset</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal103">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $idssss;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="imgway" value="nid_fond" />
		<input type="hidden" name="backway" value="" />
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
					<button type="reset" class="btn">Reset</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal104">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $idssss;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="picchange" />
		<input type="hidden" name="imgway" value="nid_back" />
		<input type="hidden" name="backway" value="" />
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
					<button type="reset" class="btn">Reset</button>
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal102">
	<form class="stdform" method="post" action="UserEditAccountQuery" name="form" enctype="multipart/form-data">
		<input type="hidden" name="idssss" value="<?php echo $idssss;?>"/>
		<input type="hidden" name="user_type" value="<?php echo $user_type;?>"/>
		<input type="hidden" name="way" value="photodelete" />
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="h5"> Remove Photo</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="popdiv">
							<div class="col-1"></div>
							<div class="col-2" style="color: red;font-size: 14px;font-weight: bold;">Remove Photo!! Are You Sure?</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Yes, Delete Please </button>
				</div>
			</div>
		</div>	
	</form>	
</div><!--#myModal-->
	<div class="pageheader">
        <div class="pageicon"><i class="iconfa-group"></i></div>
        <div class="pagetitle">
            <h1>Edit Account</h1>
        </div>
    </div><!--pageheader-->
	<?php if('useredit' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Profile Successfully Updated.
			</div><!--alert-->
	<?php } if('changepass' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Password Successfully Updated.
			</div><!--alert-->
	<?php } if('picchange' == (isset($_POST['sts']) ? $_POST['sts'] : '') && 'No' == (isset($_POST['response']) ? $_POST['response'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> New Picture Successfully Added.
			</div><!--alert-->
	<?php } if('picchange' == (isset($_POST['sts']) ? $_POST['sts'] : '') && 'Yes' == (isset($_POST['response']) ? $_POST['response'] : '')) {?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Error!!</strong> <?php echo $message;?>
			</div><!--alert-->
	<?php } if('photodelete' == (isset($_POST['sts']) ? $_POST['sts'] : '')) {?>
			<div class="alert alert-success">
				<button data-dismiss="alert" class="close" type="button">&times;</button>
				<strong>Success!!</strong> Picture Successfully Deleted.
			</div><!--alert-->
	<?php } ?>
	<div class="box box-primary">
		<div class="box-header">
				 <div class="row-fluid">
                    	<div class="span4 profile-left">
						<?php if($user_type == 'client' || $user_type == 'breseller'){?>
                        <div class="widgetbox tags">
                                <h4 class="widgettitle">User Info</h4>
                                <div class="widgetcontent">
                                    <ul class="taglist">
                                        <table class="table table-bordered table-invoice">
										<tr>
											<td style="text-align: right;font-weight: bold;">Joining Date</td>
											<td><?php echo $join_date;?></td>
										</tr>
										<tr>
											<td class="width30" style="text-align: right;font-weight: bold;">Zone</td>
											<td class="width70" style="font-family: gorgia;"><?php echo $z_name.' ('.$b_name.')'; ?></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Package</td>
											<td><?php echo $p_name;?>-<?php echo $bandwith;?> (<?php echo $p_price;?>TK)</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">User Type</td>
											<td><?php echo $con_type;?> (<?php echo $connectivity_type;?>)</td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Connectivity</td>
											<td><?php echo $connectivity_type;?></td>
										</tr>
										<tr>
											<td style="text-align: right;font-weight: bold;">Line Status</td>
											<?php if($con_sts = 'Active'){?>
											<td style="color: green;font-weight: bold;">Active</td>
											<?php } else{ ?>
											<td style="color: red;font-weight: bold;">Inactive</td>
											<?php } ?>
										</tr>

									</table>
                                    </ul>
								</div>
                        </div>
						<?php } ?>
						<div class="widgetbox profile-photo">
                            <div class="headtitle">
							<?php if($edit_sts == '0' or $user_type != 'client' or $user_type == 'breseller'){?>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#myModal101" data-toggle="modal">Change Photo</a></li>
                                      <li><a href="#myModal102" data-toggle="modal">Remove Photo</a></li>
                                    </ul>
                                </div>
							<?php } ?>
                                <h4 class="widgettitle">User Photo</h4>
                            </div>
                            <div class="widgetcontent">
                                <div class="profilethumb">
                                    <img src="<?php echo $image;?>" height="180px" width="180px"  alt="" class="img-polaroid" />
                                </div><!--profilethumb-->
                            </div>
                        </div>
						<?php if($user_type == 'client' || $user_type == 'breseller'){?>
                        <div class="widgetbox profile-photo">
                            <div class="headtitle">
							<?php if($edit_sts == '0'){?>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#myModal103" data-toggle="modal">Change Photo</a></li>
                                    </ul>
                                </div>
							<?php } ?>
                                <h4 class="widgettitle">National ID Card Front Side Photo</h4>
                            </div>
                            <div class="widgetcontent">
                                <div class="profilethumb">
                                    <img src="<?php echo $nid_fondd;?>" height="100px" width="180px"  alt="" class="img-polaroid" />
                                </div><!--profilethumb--><br>
                            </div>
                        </div>
						<div class="widgetbox profile-photo">
                            <div class="headtitle">
							<?php if($edit_sts == '0'){?>
                                <div class="btn-group">
                                    <button data-toggle="dropdown" class="btn dropdown-toggle">Action <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a href="#myModal104" data-toggle="modal">Change Photo</a></li>
                                    </ul>
                                </div>
							<?php } ?>
                                <h4 class="widgettitle">National ID Card Back Side Photo</h4>
                            </div>
                            <div class="widgetcontent">
								<div class="profilethumb">
                                    <img src="<?php echo $nid_backk;?>" height="100px" width="180px"  alt="" class="img-polaroid" />
                                </div><!--profilethumb-->
                            </div>
                        </div>
						<?php } ?>
                        </div><!--span4-->
                        <div class="span8">
                            <form method="post" action="UserEditAccountQuery" class="editprofileform" name="form">
							<input type="hidden" name="idssss" value="<?php echo $idssss;?>" />
							<input type="hidden" name="updateway" value="not_client" />
                                <div class="widgetbox login-information">
                                    <h4 class="widgettitle">Login Information</h4>
                                    <div class="widgetcontent">
										<p>
                                            <label>Name*</label>
                                            <input type="text" name="user_name" <?php if($user_type == 'client' || $user_type == 'breseller'){?> readonly <?php } ?> class="input-xlarge" value="<?php echo $user_name;?>" required=""/>
                                        </p>
										<?php if($user_type == 'client' || $user_type == 'breseller'){}else{?>
										<p>
                                            <label>Email</label>
                                            <input type="text" name="email" class="input-xlarge" value="<?php echo $emaill;?>" />
                                        </p>
										<?php } ?>
                                        <p>
                                            <label>User ID:</label>
                                            <input type="text" readonly class="input-xlarge" value="<?php echo $e_id;?>" />
                                        </p>
                                        <p>
                                            <label>Username:</label>
                                            <input type="text" readonly class="input-xlarge" value="<?php echo $user_id;?>" />
                                        </p>
										 <p>
                                            <label>User Type:</label>
                                            <input type="text" readonly class="input-xlarge" value="<?php echo $u_des;?>" />
                                        </p>
                                        <p>
                                            <label></label>
										<?php if($user_type == 'client' || $user_type == 'breseller'){} else{ ?>
                                           <button class="btn btn-red" href="#myModal100" data-toggle="modal"> Change Password</button>
										<?php } ?>
                                        </p>
                                    </div>
                                </div>
								
                            <?php if($user_type == 'client' || $user_type == 'breseller'){?>
                            	<input type="hidden" name="c_id" value="<?php echo $e_id;?>" />
								<input type="hidden" name="edit_by" value="<?php echo $e_id;?>" />
								<input type="hidden" name="edit_date" value="<?php echo date('Y-m-d', time());?>" />
								<input type="hidden" name="edit_time" value="<?php echo date('H:i:s', time());?>" />
								<input type="hidden" name="updateway" value="client"/>
                                <div class="widgetbox personal-information">
                                    <h4 class="widgettitle">Personal Information</h4>
                                    <div class="widgetcontent">
                                        <p>
                                            <label style="width: 150px;">Name*</label>
                                            <input type="text" name="c_name" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $user_name;?>" required="" />
                                        </p>
										 <p>
                                            <label style="width: 150px;">Father's Name*</label>
                                            <input type="text" name="father_name" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $father_name;?>" required="" />
                                        </p>
										<p>
                                            <label style="width: 150px;">Cell No*</label>
                                            <input type="text" name="cell" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $cell;?>" required="" />
                                        </p>
										<p>
                                            <label style="width: 150px;">Alternative No</label>
                                            <input type="text" name="cell1" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $cell1;?>" />
                                        </p>
                                        <p>
                                            <label style="width: 150px;">Email</label>
                                            <input type="text" name="email" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $email;?>" />
                                        </p>
										<p>
                                            <label style="width: 150px;">Occupation</label>
                                            <input type="text" name="occupation" class="input-xlarge" value="<?php echo $occupation;?>" />
                                        </p>
										<p>
                                            <label style="width: 150px;">National ID No*</label>
                                            <input type="text" name="nid" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $nid;?>" required="" />
                                        </p>
										<p>
                                            <label style="width: 150px;">Previous ISP</label>
                                            <input type="text" name="previous_isp" class="input-xlarge" value="<?php echo $previous_isp;?>"/>
                                        </p>
                                    </div>
                                </div>
								<div class="widgetbox personal-information">
                                    <h4 class="widgettitle">Location Information</h4>
                                    <div class="widgetcontent">
                                        <p>
                                            <label style="width: 150px;">Thana*</label>
                                            <input type="text" name="thana" class="input-large" <?php if($edit_sts == '1'){?> readonly <?php } ?> value="<?php echo $thana;?>" required="" />
                                        </p>
                                        <p>
                                            <label style="width: 150px;">Present Address*</label>
                                            <textarea type="text" name="address" class="input-xlarge" <?php if($edit_sts == '1'){?> readonly <?php } ?> required="" /><?php echo $address;?></textarea>
                                        </p>
										 <p>
                                            <label style="width: 150px;">Permanent Address</label>
                                            <textarea type="text" name="old_address" class="input-xlarge"/><?php echo $old_address;?></textarea>
                                        </p>
										<p>
											<label style="width: 150px;"></label>
                                            <input type="checkbox" name="terms" value="1" <?php if($terms=='1'){echo 'checked';}?> required="" /> <a href="">Agree With Our Terms and Conditions</a>
                                        </p>
                                    </div>
                                </div>
							<?php } ?>
                                <p>
                                	<button type="submit" class="btn btn-primary">Update Profile</button> 
                                </p>
                                
                            </form>
                        </div><!--span8-->
                    </div><!--row-fluid-->
		</div>
	</div>

<?php

include('include/footer.php');
?>
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