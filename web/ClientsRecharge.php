<?php
$titel = "Recharge";
$Client = 'active';
include('include/hader.php');
extract($_POST);
$user_type = $_SESSION['SESS_USER_TYPE'];

$e_id = $_SESSION['SESS_EMP_ID'];
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());


$que = mysql_query("SELECT id, con_sts, breseller, mac_user FROM clients WHERE c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$con_sts = $row['con_sts'];		
$breseller = $row['breseller'];		
$macuserrr = $row['mac_user'];		
$clientid = $row['id'];		

$todayssss = strtotime(date('Y-m-d', time()));
$ques = mysql_query("SELECT b.id, b.c_id, c.cell, c.address, c.z_id, c.con_sts, c.mac_user, c.mk_id, c.c_name, c.payment_deadline, c.termination_date, b.days, b.start_date, b.start_time, b.end_date, b.p_id, p.p_name, p.bandwith, p.p_price, b.bill_amount FROM billing_mac AS b
						LEFT JOIN package AS p
						ON p.p_id = b.p_id
						LEFT JOIN clients AS c
						ON c.c_id = b.c_id
						WHERE c.c_id = '$c_id' ORDER BY b.id DESC LIMIT 1");
$roww = mysql_fetch_assoc($ques);
$idq = $roww['id'];
$cl_idsss = $roww['c_id'];
$c_name = $roww['c_name'];
$cell = $roww['cell'];
$start_date = strtotime($roww['start_date']);
$startdate = $roww['start_date'];
$start_time = strtotime($roww['start_time']);
$starttime = $roww['start_time'];
$end_date = strtotime($roww['end_date']);
$enddate = $roww['end_date'];
$p_id = $roww['p_id'];
$p_name = $roww['p_name'];
$bandwith = $roww['bandwith'];
$p_price = $roww['p_price'];
$bill_amount = $roww['bill_amount'];
$macuser = $roww['mac_user'];
$day = $roww['days'];
$mk_id = $roww['mk_id'];
$termination_date = $roww['termination_date'];
$z_id = $roww['z_id'];
$con_sts = $roww['con_sts'];
$address = $roww['address'];

$query1="SELECT p_id, p_name, p_price, bandwith FROM package WHERE z_id = '$z_id' AND p_price != '0.00' AND status = '0' order by id ASC";
$result1=mysql_query($query1);

$sqlqqmm = mysql_query("SELECT minimum_day, minimum_days, minimum_sts, terminate FROM emp_info WHERE z_id = '$z_id'");
$row22m = mysql_fetch_assoc($sqlqqmm);

$minimum_days = $row22m['minimum_days'];
$minimum_sts = $row22m['minimum_sts'];

if($minimum_sts != '1' && $minimum_days != ''){
	$minimum_days_array = explode(',',$minimum_days);
	$trimSpaces = array_map('trim',$minimum_days_array);
	asort($trimSpaces);
	$minimum_days_arrays = implode(',',$trimSpaces);
	$minimum_arraydd =  explode(',', $minimum_days_arrays);
	$minimum_day = min(explode(',', $minimum_days_arrays));
}
else{
	$minimum_day = $row22m['minimum_day'];
}
	
$terminate = $row22m['terminate'];

$sql8u8 = mysql_query("SELECT * FROM sms_setup WHERE z_id = '$z_id'");
$resellersms = mysql_num_rows($sql8u8);

//--------------------------------------------------------------------------------------------------------------------------------------------------

if($terminate == '0'){
$todayyyy = date('Y-m-d', time());

//$durations = strip_tags($_POST['duration']);

$Date2ww = date('Y-m-d', strtotime($termination_date . " + ".$minimum_day." day"));
$yrdatayy= strtotime($Date2ww);
$newdateee = date('F d, Y', $yrdatayy);

$Date2 = date('Y-m-d', strtotime($todayyyy . " + ".$minimum_day." day"));
$yrdata= strtotime($Date2);
$dateee = date('F d, Y', $yrdata);

$resultwww = mysql_query("SELECT p_id, p_price FROM package WHERE p_id = '$p_id' AND status = '0'");
$rowprice = mysql_fetch_assoc($resultwww);
$old_p_price= $rowprice['p_price'];

$packageoneday = $old_p_price/30;
$daycost = $minimum_day*$packageoneday;

if($todayssss > $start_date && $todayssss < $end_date || $todayssss <= $start_date && $todayssss <= $end_date) {?>
	<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-globe"></i></div>
        <div class="pagetitle">
            <h1>Recharge</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>New Recharge/Extend</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="ClientsRechargeQuery" onsubmit='disableButton()'>
				<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
				<input type="hidden" name="z_id" value="<?php echo $z_id; ?>">
				<input type="hidden" name="p_id" value="<?php echo $p_id; ?>">
				<input type="hidden" name="start_date" value="<?php echo $startdate; ?>">
				<input type="hidden" name="start_time" value="<?php echo $starttime; ?>">
				<input type="hidden" name="end_date" value="<?php echo $enddate; ?>">
				<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
				<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
				<input type="hidden" name="con_sts" value="<?php echo $con_sts;?>" />
					<div class="modal-body" style="min-height: 180px;">
                        <table class="table table-bordered table-invoice" style="width:100%">
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Current Package</td>
                                <td style="font-size: 18px;font-weight: bold;width: 51%;"><?php echo $p_name; ?> || <?php echo $bandwith; ?> || <?php echo $p_price; ?>৳</td>
                                <?php if($resellersms > 0){?><td rowspan="5"><?php } else{ ?><td rowspan="4"><?php } ?>
								<strong>
									<a style="font-size: 18px;font-weight: bold;color: darkgreen;"><?php echo $c_id;?></a>
								</strong> <br />
									<a style="font-size: 15px;font-weight: bold;color: darkmagenta;"><?php echo $c_name;?></a> <br />
                                    <a style="font-size: 13px;color: black;"><?php echo $cell;?></a><br />
                                    <a style="font-size: 13px;color: black;"> <?php echo $address;?></a> <br />
                                    <a style="font-weight: bold;font-size: 15px;color: green;">[<?php echo $con_sts;?>]</a></td>
						   </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Old Termination Date</td>
                                <td style="font-size: 17px;font-weight: bold;color: darkmagenta;width: 51%;"><?php $yrdata= strtotime($termination_date); $dateee = date('F d, Y', $yrdata); echo $dateee; ?></td>
                            </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">New Termination Date</td>
                                <td style="font-size: 18px;font-weight: bold;color: green;width: 51%;"><div id="dayprice" style="font-weight: bold;margin-left: 0px;" class="field"><a style="color: #f95a5a;font-size: 15px;">Cost: <?php echo number_format($daycost,2); ?>৳</a> <a style="color: green;font-size: 15px;">  Till: <?php echo $newdateee; ?></a></div></td>
                            </tr>
							<?php if($minimum_sts == '2' && $minimum_days_arrays != ''){?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Recharge/Extend Dayss</td>
                                <td style="font-size: 20px;font-weight: bold;color: maroon;width: 51%;">
									<select name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 35px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required="">
										<?php foreach ($minimum_arraydd as $item) { 
												echo "<option value='$item'>$item</option>";
											}?>
									</select>
									<br>
									<a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_days_arrays;?> Days]</a>
								</td>
                            </tr>
							<?php } else{?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Recharge/Extend Days</td>
                                <td style="font-size: 20px;font-weight: bold;color: maroon;width: 51%;"><input type="text" name="duration" id="duration" value="<?php echo $minimum_day;?>" style="width:80px;font-weight: bold;font-size: 30px;height: 30px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required="" ondrop="return false;" onpaste="return false;"><br><a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_day;?> Days]</a></td>
                            </tr>
							<?php } if($resellersms > 0){?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Send Invoice SMS</td>
                                <td>
									<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
									<input type="radio" name="sentsms" value="No" checked="checked"> No &nbsp; &nbsp;
								</td>
                            </tr>
						<?php } ?>
                        </table>
					</div>
					<div class="modal-footer" id="nfnhfnhn">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" type="submit" id="submitdisabl">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
<?php } else{ ?>
			<div class="pageheader">
        <div class="searchbar">
        </div>
        <div class="pageicon"><i class="iconfa-globe"></i></div>
        <div class="pagetitle">
            <h1>Recharge</h1>
        </div>
    </div><!--pageheader-->
	<div class="box box-primary">
		<div class="box-header">
			<div class="modal-content">
				<div class="modal-header">
					<h5>New Recharge</h5>
				</div>
				<form id="" name="form1" class="stdform" method="post" action="ClientsRechargeQuery" onsubmit='disableButton()'>
				<input type ="hidden" name="c_id" value="<?php echo $c_id; ?>">
				<input type ="hidden" name="z_id" value="<?php echo $z_id; ?>">
				<input type ="hidden" name="start_date" value="<?php echo $startdate; ?>">
				<input type ="hidden" name="start_time" value="<?php echo $starttime; ?>">
				<input type ="hidden" name="end_date" value="<?php echo $update_date; ?>">
				<input type="hidden" name="mk_id" value="<?php echo $mk_id;?>" />
				<input type="hidden" name="entry_by" value="<?php echo $e_id;?>" />
				<input type="hidden" name="con_sts" value="<?php echo $con_sts;?>" />
					<div class="modal-body" style="min-height: 280px;">
                        <table class="table table-bordered table-invoice" style="width:100%">
							
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Old Package</td>
                                <td style="font-size: 18px;font-weight: bold;width: 51%;"><?php echo $p_name; ?> || <?php echo $bandwith; ?> || <?php echo $p_price; ?>৳</td>
                                <?php if($resellersms > 0){?><td rowspan="5"><?php } else{ ?><td rowspan="4"><?php } ?>
								<strong>
									<a style="font-size: 18px;font-weight: bold;color: darkgreen;"><?php echo $c_id;?></a>
								</strong> <br />
									<a style="font-size: 15px;font-weight: bold;color: darkmagenta;"><?php echo $c_name;?></a> <br />
                                    <a style="font-size: 13px;color: black;"><?php echo $cell;?></a><br />
                                    <a style="font-size: 13px;color: black;"> <?php echo $address;?></a> <br />
                                    <a style="font-weight: bold;font-size: 15px;color: green;">[<?php echo $con_sts;?>]</a></td>
						   </tr>
							<tr>
                                <td class="" style="font-weight: bold;font-size: 12px;">Choose Package</td>
                                <td class="" style="font-size: 20px;font-weight: bold;color: maroon;">
								<select data-placeholder="Choose a Package" class="chzn-select" style="width:100%;" name="p_id" id="p_id" required="" onchange="myFunctionnn(event)"/>
											<option value=""></option>
												<?php while ($row1=mysql_fetch_array($result1)) { ?>
											<option value="<?php echo $row1['p_id']?>"<?php if($p_id == $row1['p_id']) echo 'selected="selected"';?>><?php echo $row1['p_name']; ?> (<?php echo $row1['p_price']; ?> - <?php echo $row1['bandwith']; ?>)</option>
												<?php } ?>
								</select>
								</td>
                            </tr>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">New Termination Date</td>
                                <td style="font-size: 18px;font-weight: bold;"><div id="dayprice1" style="font-weight: bold;margin-left: 0px;" class="field"><div id="dayprice" style="font-weight: bold;margin-left: 0px;" class="field"><a style="color: #f95a5a;font-size: 15px;">Cost: <?php echo number_format($daycost,2); ?>৳</a> <a style="color: green;font-size: 15px;">  Till: <?php echo $dateee; ?></a></div></div></td>
                            </tr>
							<?php if($minimum_sts == '2' && $minimum_days_arrays != ''){?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Recharge/Extend Dayss</td>
                                <td style="font-size: 20px;font-weight: bold;color: maroon;width: 51%;">
									<select name="duration" id="duration" style="width:80px;font-weight: bold;font-size: 20px;height: 35px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required="">
										<?php foreach ($minimum_arraydd as $item) { 
												echo "<option value='$item'>$item</option>";
											}?>
									</select>
									<br>
									<a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_days_arrays;?> Days]</a>
								</td>
                            </tr>
							<?php } else{?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Recharge/Extend Days</td>
                                <td style="font-size: 20px;font-weight: bold;"><input type="text" name="duration" value="<?php echo $minimum_day;?>" id="duration" style="width:80px;font-weight: bold;font-size: 30px;height: 30px;margin-bottom: 5px;text-align: center;" placeholder="<?php echo $minimum_day;?>" required=""><br><a class="field" style="color: red;font-size: 10px;font-weight: bold;">[Minimum <?php echo $minimum_day;?> Days]</a></td>
                            </tr>
							<?php } if($resellersms > 0){?>
							<tr>
                                <td style="font-weight: bold;font-size: 12px;">Send Invoice SMS</td>
                                <td>
									<input type="radio" name="sentsms" value="Yes"> Yes &nbsp; &nbsp;
									<input type="radio" name="sentsms" value="No" checked="checked"> No &nbsp; &nbsp;
								</td>
                            </tr>
						<?php } ?>
                        </table>
					</div>
					<div class="modal-footer" id="nfnhfnhn">
						<button type="reset" class="btn ownbtn11">Reset</button>
						<button class="btn ownbtn2" id="submitdisabl" type="submit">Submit</button>
					</div>
				</form>			
			</div>
		</div>
	</div>

<?php }}
else{
	echo '<br><h3 style="margin-left: 20px;color: red;">Your Account Has Been Terminated. Not Possible to Recharge.</h3><br>';
}
include('include/footer.php');

if($minimum_sts == '2' && $minimum_days_arrays != ''){
?>

<script type="text/javascript">
$(document).ready(function()
{    
 $('select[name="duration"]').on('change',function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "durationdayextend.php?clientid="+<?php echo $clientid;?>,
    data : $(this).serialize(),
    success : function(data)
        {
              $("#dayprice").html(data);
				if(data.length > 0)
				{
				  $("#nfnhfnhn").html('<button type="reset" class="btn ownbtn11">Reset</button><button class="btn ownbtn2" id="submitdisabl" type="submit">Submit</button>');
				}
			  else
			  {
			   $("#nfnhfnhn").html('');
			  }
           }
    });
    return false;
   
  }
  else
  {
   $("#dayprice").html('');
   $("#nfnhfnhn").html('');
  }
 });
 
});
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice1").html(data);
								if(data.length > 0)
								{
								  $("#nfnhfnhn").html('<button type="reset" class="btn ownbtn11">Reset</button><button class="btn ownbtn2" id="submitdisabl" type="submit">Submit</button>');
								}
							  else
							  {
							   $("#nfnhfnhn").html('');
							  }
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice1").html('');
				   $("#nfnhfnhn").html('');
				  }
				 });
				});
			}
        });
});

function myFunctionnn() {
    document.getElementById("duration").value = ''
}
</script>
<?php } else{?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#duration").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > 0)
  {  
   $("#dayprice").html('checking...');
   $.ajax({
    
    type : 'POST',
	url  : "durationdayextend.php?clientid="+<?php echo $clientid;?>,
    data : $(this).serialize(),
    success : function(data)
			{
              $("#dayprice").html(data);
				if(data.length > 0)
				{
				  $("#nfnhfnhn").html('<button type="reset" class="btn ownbtn11">Reset</button><button class="btn ownbtn2" id="submitdisabl" type="submit">Submit</button>');
				}
			  else
			  {
			   $("#nfnhfnhn").html('');
			  }
		   }
    });
    return false;
  }
  else
  {
   $("#dayprice").html('');
  }
 });
 
});
</script>
<script type="text/javascript">
jQuery(document).ready(function ()
{
        jQuery('select[name="p_id"]').on('change',function(){
           var CatID1 = jQuery(this).val();
           if(CatID1)
			{
				$(document).ready(function()
				{    
				 $("#duration").keyup(function()
				 {  
				  var name = $(this).val(); 
				  if(name.length > 0)
				  {  
				   $("#dayprice1").html('checking...');

				   $.ajax({
					
					type : 'POST',
					url  : "duration-packageprice-calculation.php?p_id="+CatID1,
					data : $(this).serialize(),
					success : function(data)
						{
							  $("#dayprice1").html(data);
							  if(data.length > 0)
								{
								  $("#nfnhfnhn").html('<button type="reset" class="btn ownbtn11">Reset</button><button class="btn ownbtn2" id="submitdisabl" type="submit">Submit</button>');
								}
							  else
							  {
							   $("#nfnhfnhn").html('');
							  }
						   }
					});
					return false;
				  }
				  else
				  {
				   $("#dayprice1").html('');
				  }
				 });
				});
			}
        });
});

function myFunctionnn() {
    document.getElementById("duration").value = ''
}

function disableButton() {
        var btn = document.getElementById('submitdisabl');
        btn.disabled = true;
        btn.innerText = 'Posting...'
}

</script>
<?php }?>
