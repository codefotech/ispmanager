<?php
include('company_info.php');
include("conn/connection.php");
include("Function.php");
$ip = $_SERVER['REMOTE_ADDR'];
extract($_POST);


$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE status = '0' AND z_id = '' AND p_price != '0.00' AND signup_sts = '1' order by id ASC";
$result1=mysql_query($query1);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Signup form</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="prettify/prettify.css" type="text/css" />
<link rel="stylesheet" href="data_grid/css/style.css" type="text/css" />
<link rel="stylesheet" href="data_grid/css/style_add.css" type="text/css" />
<link rel="icon" type="images/png" href="images/favicon.png"/>

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-fileupload.min.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/jquery.autogrow-textarea.js"></script>
<script type="text/javascript" src="js/charCount.js"></script>
<script type="text/javascript" src="js/colorpicker.js"></script>
<script type="text/javascript" src="js/ui.spinner.min.js"></script>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="prettify/prettify.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
<script type="text/javascript" src="js/dy_add_input.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        //slim scroll
        jQuery('#scroll1').slimscroll({
             color: '#666',
             size: '10px',
             width: 'auto',
             height: '208px'                  
         });
    });
</script>
 <script type="text/javascript">
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(50)
                        .height(50);
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
                        .width(90)
                        .height(50);
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
                        .width(90)
                        .height(50);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</head>

<body class="login-page" style="">
<?php include('company_info.php'); 
if ($c_name != ''){?>
		<div class="login-logo">
			Thank You Very Much... We will verify your information and update you via SMS. <?php echo $comp_name; ?> Again.
		</div>
<?php } else {?>
<div class="login-logo">
	Welcome to <?php echo $comp_name; ?>
</div>
<div class="maincontent">
  <div class="maincontentinner">
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>Client Signup Form</h5>
				</div>
					<form id="form" class="stdform" method="post" action="SignUpQuery" enctype="multipart/form-data">
						<input type="hidden" name="entry_date" value="<?php echo date("Y-m-d");?>" />
						<input type="hidden" name="entry_time" value="<?php echo date("h:i a");?>" />
						<input type="hidden" name="datimg" value="<?php echo date("Ymdhi");?>" />
						<input type="hidden" name="client_ip" value="<?php echo $ip;?>" />
							<div class="modal-body">
								<p>
									<label>Client Name*</label>
									<span class="field"><input type="text" name="c_name" id="" required="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Package*</label>
									<span class="field">
										<select data-placeholder="Choose a Package" name="p_id" class="chzn-select" style="width:540px;"  required="" >
											<option value=""></option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['p_id']?>"><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
												<?php } ?>
										</select>
									</span>
								</p>
								<p>
									<label>Type of Connectivity*</label>
										<span class="field">
											<select class="chzn-select" name="connectivity_type" style="width:540px;" required="" >
												<option value="Shared">Shared</option>
												<option value="Dedicated">Dedicated</option>
											</select>
										</span>					
								</p>
								<p>
									<label>Payment Method*</label>
									<span class="field">
										<select data-placeholder="Choose Payment Method" name="p_m" class="chzn-select" style="width:540px;" required="" >
											<option value="Home Cash">Cash from Home</option>
											<option value="Cash">Cash</option>
											<option value="Office">Office</option>
											<option value="bKash">bKash</option>
											<option value="Rocket">Rocket</option>
											<option value="iPay">iPay</option>
											<option value="Card">Card</option>
											<option value="Bank">Bank</option>
											<option value="Corporate">Corporate</option>
										</select>
									</span>
								</p>
								<p>
									<label>Signup Fee</label>
									<span class="field"><input type="text" name="signup_fee" placeholder="Ex: 1200" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Cell No*</label>
									<span class="field"><input type="text" name="cell" placeholder="Must Use 8801XXXXXXXXX" required="" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Alternative Cell No 1</label>
									<span class="field"><input type="text" name="cell1" placeholder="Alternative Cell No:1" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Address</label>
									<span class="field"><textarea type="text" name="address" id="" class="input-xxlarge"/></textarea></span>
								</p>
								<p>
									<label>Occupation</label>
									<span class="field"><input type="text" name="occupation" placeholder="Occupation" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Email</label>
									<span class="field"><input type="text" name="email" id="" placeholder="Ex: abcd@domain.com" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>National ID</label>
									<span class="field"><input type="text" name="nid" placeholder="Ex: 123456789" id="" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Previous ISP</label>
									<span class="field"><input type="text" name="previous_isp" id="" placeholder="Ex: 1230" class="input-xxlarge" /></span>
								</p>
								<p>
									<label>Feedback</label>
									<span class="field"><textarea type="text" name="note" placeholder="Optional" id="" class="input-xxlarge" /></textarea></span>
								</p>
								<p>
									<label class="control-label">Image</label>
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span2">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="image" onchange="readURL(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah" src="emp_images/no_img.jpg" alt="" style="width: 50px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
								<p>
									<label class="control-label">NID Front Side</label>
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span2">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="nid_f_image" onchange="readURL1(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah1" src="images/no_nid.png" alt="" style="width: 90px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
								<p>
									<label class="control-label">NID Back Side</label>
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-append">
											<div class="uneditable-input span2">
												<i class="iconfa-file fileupload-exists"></i>
												<span class="fileupload-preview"></span>
											</div>
											<span class="btn btn-file" style="padding: 5px 10px 4px 10px;">
												<span class="fileupload-new">Choose</span>
												<span class="fileupload-exists">Change</span>
												<input type="file" class="input-small" name="nid_b_image" onchange="readURL2(this);" />
											</span>
											<a href="#" class="btn fileupload-exists" style="padding: 5px 10px 4px 10px;" data-dismiss="fileupload">Remove</a>
										</div>
									<img id="blah2" src="images/no_nid.png" alt="" style="width: 90px;height: 50px;margin-left: 7px;"/>
									</div>
								</p>
								<p>
									<label><a href="" >Agree With Our Conditions</a></label>
										<span class="formwrapper">
										<input type="radio" name="disclaimer" value="Yes" checked="checked"> Yes &nbsp; &nbsp;
										<input type="radio" name="disclaimer" value="No"> No &nbsp; &nbsp;
									</span>
								</p>
							</div>
								
							<div class="modal-footer">
								<button type="reset" class="btn">Reset</button>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
					</form>			
			</div>
		</div>
	</div>

		<div class="login-footer">
			<?php echo $footer; ?>
		</div>
</div>		
</div>
<?php } ?>
</body>
</html>