<?php 
//session_cache_expire( 20 );
session_start(); // NEVER FORGET TO START THE SESSION!!!
unset($_SESSION['page_counter']);
    //Check whether the session variable SESS_MEMBER_ID is present or not
	if($_SESSION['SESS_USER_TYPE'] == '') {
		header("location: index");
		exit();
	}
	
include("company_info.php");
include("conn/connection.php");
include("Function.php");

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
ini_alter('date.timezone','Asia/Almaty');
$PageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);  

$e_id = $_SESSION['SESS_EMP_ID'];
$userr_typ = $_SESSION['SESS_USER_TYPE'];

if($userr_typ == 'mreseller') {
$sss1 = mysql_query("SELECT z_id, z_name, e_id FROM zone WHERE e_id ='$e_id'");
$sssw1 = mysql_fetch_assoc($sss1);

$macz_id = $sssw1['z_id'];

$sss1m = mysql_query("SELECT reseller_logo, billing_type, e_name AS reseller_fullname, e_cont_per AS reseller_cell, over_due FROM emp_info WHERE e_id ='$e_id'");
$sssw1m = mysql_fetch_assoc($sss1m);

$reseller_fullname = $sssw1m['reseller_fullname'];
$reseller_cell = $sssw1m['reseller_cell'];
$billing_typee = $sssw1m['billing_type'];
$over_due_balance = '-'.$sssw1m['over_due'];
$over_due_balance_main = $sssw1m['over_due'];

if($sssw1m['reseller_logo'] != 'emp_images/'){
$logo = $sssw1m['reseller_logo'];
}
else{
$logo = 'images/logo.png';
}}
else{
$logo = 'images/logo.png';
}


$s1 = mysql_query('SELECT * FROM app_config');
$sw1 = mysql_fetch_assoc($s1);

$CompanyName = $sw1['name'];
$CompanyOwner = $sw1['owner_name'];
$CompanyEmail = $sw1['com_email'];
$OwnerEmail = $sw1['email'];
$OwnerEmail2 = $sw1['email2'];
$CompanyAddress = $sw1['address'];
$CompanyPostalCode = $sw1['postal_code'];
$CompanyFax = $sw1['fax'];
$CompanyPhone = $sw1['phone'];
$CompanyWebsite = $sw1['website'];
$CompanyCurrency = $sw1['currency'];
$CompanyLogo = $sw1['logo'];
$mailaddess = $OwnerEmail.','.$OwnerEmail2;

$acce_arry = mysql_fetch_assoc(mysql_query("SELECT GROUP_CONCAT(id SEPARATOR ',') AS page_access FROM module_page WHERE $userr_typ IN ('1', '2')"));
$access_arry = explode(',',$acce_arry['page_access']);
?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8" />
<title><?php echo $titel.' | '.$CompanyName;?> | BILL</title>

<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-fileupload.min.css" type="text/css" />
<link rel="stylesheet" href="css/bootstrap-timepicker.min.css" type="text/css" />
<link rel="stylesheet" href="css/prettify.css" type="text/css" />
<link rel="icon" type="images/png" href="images/favicon.png"/>

<?php if($PageName == 'ClientAddInvoice.php' || $PageName == 'ClientEditMonthlyInvoice.php' || $PageName == 'ClientsBillAdjust.php' || $PageName == 'BankEdit.php'){?>
<link href="invoice/css/jquery-ui.min.css" rel="stylesheet">
<link href="invoice/css/datepicker.css" rel="stylesheet">
<?php } else{ ?>


<?php if(in_array($_SESSION['SESS_USER_TYPE'], $chat_access)){ ?>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e7694368d24fc2u6';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php } ?>

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
<script type="text/javascript" src="js/prettify.js"></script>
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
<script type="text/javascript" src="js/elements.js"></script>
<script type="text/javascript" src="js/dy_add_input.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard.min.js"></script>
<?php } ?>
<script type="text/javascript">
$(document).ready(function()
{    
 $("#mainclientsearch").keyup(function()
 {  
  var name = $(this).val(); 
  
  if(name.length > <?php if($search_way == 'c_id'){echo '4';} elseif($search_way == 'com_id'){echo '0';} elseif($search_way == 'c_name'){echo '5';} elseif($search_way == 'ip'){echo '8';} else{echo '5';}?>)
  {
   $("#searchresult").html('');
   $.ajax({
    
    type : 'POST',
    url  : 'MainClientSearchResult.php',
    data : $(this).serialize(),
    success : function(data)
        {
          $("#searchresult").html(data);
        }
    });
    return false;
  }
  else if(name.length == '')
  {
   $("#searchresult").html('&nbsp;&nbsp;Type Something');
  }
  else
  {
   $("#searchresult").html('&nbsp;&nbsp;Type more. Searching....');
  }
 });
 
});
</script>

<!-- print script start-->
<script>
function myFunction()
{
window.print();
}
</script>
<!--print script end -->
</head>

 
<body>
     <div id="auto-lock"></div>
<?php if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'accounts' || $userr_typ == 'ets' || $userr_typ == 'billing' || $userr_typ == 'support' || $userr_typ == 'billing_manager' || $userr_typ == 'support_manager') {?>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5e7694368d24fc2265892f20/1e4oanqu6';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php } else {}?>

<style>
  .searchstyle {
	  text-transform: uppercase;
	  font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;
	  border: 1px solid #ddd;
	  color: #08c;
	  font-size: 12px;
	  background: #ddd;
	  font-weight: bold;
  }
    .searchstyle:hover {
	  text-transform: uppercase;
	  font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;
	  border: 1px solid #ddd;
	  color: red;
	  font-size: 12px;
	  background: #f7f7f7;
	  font-weight: bold;
  }
  .Marquee-box {
     position: fixed;
     display: inline-block;
  }
.MyMarquee {
	font-family: 'RobotoRegular', 'Helvetica Neue', Helvetica, sans-serif;
	box-sizing: border-box;
	display: initial;
}
  .MyMarquee div {
     display: inline-block;
     vertical-align: middle;
  }
  .MyMarquee a, .MyMarquee img {
     display: inline-block;
     text-decoration: underline;
     color: #e80e0e;
     vertical-align: middle;
  }
</style>
<div class="mainwrapper">
    <div class="header">
        <div class="logo">
			<a href="welcome"><img src="<?php echo $logo;?>" height="40px" width="175px" style="margin-left: -6px;" /></a>
        </div>
		<div>
            <ul class="headmenu">
				 <li class="right">
					<a class="dropdown-toggle" style="padding: 11px 10px;" data-toggle="dropdown" href="#">
						<img style="margin: -8px 5px -5px 0;border-radius: 50% !important;" class="lock-avatar" height="40" width="40" src="<?php if($_SESSION['SESS_EMP_IMG'] == ''){echo 'imgs/user.png';} else {echo $_SESSION['SESS_EMP_IMG'];} ?>">
						<?php echo $_SESSION['SESS_FIRST_NAME'];?>
					</a>
                <?php if($_SESSION['position'] == 'admin' || $_SESSION['position'] == 'superadmin') {?>
					<ul class="dropdown-menu" style="width: 99%;">
						<li style="text-align: left;" class="viewmore"><a href="UserAccess" class=""> <i class="iconfa-cogs"></i> &nbsp; User Access</a></li>
						<li style="text-align: left;" class="viewmore"><a href="AppSettings" class=""><i class="iconfa-cog"></i> &nbsp; App Settings</a></li>
						<li class="divider"></li>
						<li style="text-align: left;" class="viewmore"><a href="UserEditAccount" class=""><i class="iconfa-edit"></i>  &nbsp; Edit Account</a></li>
						<li style="text-align: left;" class="viewmore"><a href="index?way=logout" class=""><i class="iconfa-off"></i>  &nbsp; Logout</a></li>
                    </ul>
				<?php } else {?>
					<ul class="dropdown-menu" style="width: 99%;">
						<li style="text-align: left;" class="viewmore"><a href="UserEditAccount" class=""><i class="iconfa-edit"></i>  &nbsp; Edit Account</a></li>
						<li style="text-align: left;" class="viewmore"><a href="index?way=logout" class=""><i class="iconfa-off"></i>  &nbsp; Logout</a></li>
                    </ul>
				<?php } ?>
                </li>
			</ul>
        </div>
    </div>
	<div class="leftpanel">
        <div class="leftmenu">
				<ul class="nav nav-tabs nav-stacked">
					<li class="nav-header" style="text-align: center;font-weight: bold;font-size: 14px;"><?php echo $_SESSION['SESS_TYPE_NAME'];?></li>
					<?php
						$sqlq = mysql_query("SELECT `position`, `module_name`, `desc`, `icon` FROM module WHERE $userr_typ = '1' AND sts = '0' AND id != '1' order by position");
						while( $rowaa = mysql_fetch_assoc($sqlq) )
						{ 
									echo "<li class='${$rowaa['module_name']}'>
											<a href='{$rowaa['module_name']}'>
												<i class='{$rowaa['icon']}'></i>
												<span class='title'>{$rowaa['desc']}</span>
												<span class='selected'></span>
											</a>
										</li>";
						}
						
				if($userr_typ == 'admin' || $userr_typ == 'superadmin'){ ?>
				<li class="dropdown <?php echo $AppSettings;?>"><a href="AppSettings"><span class="iconfa-cogs" style="margin-right: 0px;"></span> Settings</a>
                	<ul <?php if($AppSettings == 'active' || $SMSSettings == 'active' || $UserAccess == 'active' || $UserAccessPage == 'active'){echo "style='display: block;'";}?>>
                    	<li><a href="AppSettings?wayyy=Balance" style="padding: 7px 10px 7px 43px;">Balance</a></li>
                    	<li><a href="AppSettings?wayyy=Basic Informations" style="padding: 7px 10px 7px 43px;">Basic</a></li>
                    	<li><a href="AppSettings?wayyy=Owner Informations" style="padding: 7px 10px 7px 43px;">Owner</a></li>
                    	<li><a href="AppSettings?wayyy=Backup Informations" style="padding: 7px 10px 7px 43px;">Backup</a></li>
                    	<li><a href="AppSettings?wayyy=Gateway" style="padding: 7px 10px 7px 43px;">Online Payment</a></li>
                    	<li class="dropdown"><a href="" style="padding: 7px 10px 7px 43px;">SMS</a>
							<ul <?php if($SMSSettings == 'active'){echo "style='display: block;'";}?>>
								<li><a href="AppSettings?wayyy=SMS API">API & Panel</a></li>
								<li><a href="SMSSettings">Templates</a></li>
							</ul>
						</li>
                    	<li><a href="AppSettings?wayyy=Telegram API" style="padding: 7px 10px 7px 43px;">Telegram</a></li>
                    	<li><a href="AppSettings?wayyy=Others Settings" style="padding: 7px 10px 7px 43px;">Others</a></li>
						<li class="dropdown"><a href="" style="padding: 7px 10px 7px 43px;">Permissions</a>
							<ul <?php if($UserAccess == 'active' || $UserAccessPage == 'active'){echo "style='display: block;'";}?>>
								<li><a href="UserAccess">Menu Access</a></li>
								<li><a href="UserAccessPage">Advance Access</a></li>
							</ul>
						</li>
                    </ul>
                </li>
				<?php } ?>
				</ul>
        </div><!--leftmenu--> 
    </div><!-- leftpanel -->
    <div class="rightpanel">
        <ul class="breadcrumbs" style="margin-left: 0px;">
            <li><a href="welcome"><i class="iconsweets-home"></i></a><span class='separator'></span></li>
			<?php
			echo "<li>$titel</li>";
			?>
		
			<li class="right">
                <a href="" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-tint"></i> Color</a>
                <ul class="dropdown-menu pull-right skin-color" style="text-align: left;min-width: 93px;">
                    <li><a href="default" style="font-weight: bold;color: #0866c6;">Blue</a></li>
                    <li><a href="navyblue" style="font-weight: bold;color: #3b6c8e;">Navy Blue</a></li>
                    <li><a href="palegreen" style="font-weight: bold;color: #409369;">Pale Green</a></li>
                    <li><a href="red" style="font-weight: bold;color: #bb2f0e;">Red</a></li>
                    <li><a href="green" style="font-weight: bold;color: #42b521;">Green</a></li>
                    <li><a href="brown" style="font-weight: bold;color: #6c5c51;">Brown</a></li>
                </ul>
            </li>
			
	

			<?php if($userr_typ == 'mreseller') {

$sql1q = mysql_query("SELECT c_id, SUM(bill_amount) AS totbill FROM billing_mac WHERE z_id = '$macz_id'");
$rowq = mysql_fetch_array($sql1q);


$sql1z1 = mysql_query("SELECT p.id, SUM(p.pay_amount) AS repayment, SUM(p.discount) AS rediscount, (SUM(p.pay_amount) + SUM(p.discount)) AS retotalpayments FROM `payment_macreseller` AS p
						WHERE p.z_id = '$macz_id' AND p.sts = '0'");
$rowwz = mysql_fetch_array($sql1z1);

$aaaa = $rowwz['retotalpayments']-$rowq['totbill'];

if($aaaa < 0){
	$color = 'color:red;';		
	$bcolor = 'background-color: red !important;';	
	$bdcolor = 'border: 1px solid red;';
} else{
	$color = 'color:#555555;';
	$bcolor = 'background-color: #0866c6cc !important;';	
	$bdcolor = 'border: 1px solid #0866c6cc !important;';
}
?>

<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModaldrhdrjcz">
	<form id="form" class="stdform" method="post" action="PaymentOnline?gateway=SSLCommerz">
	<input type="hidden" name="wayyy" value="reseller" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Recharge by SSLCommerz</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;font-size: 19px;width: 40%;margin-left: 40px;padding: 8px 0;">Recharge Amount:</div>
						<div class="col-2"><input type="text" name="dewamount" required="" placeholder="2000" style="width: 40%;height: 30px;font-size: 25px;font-weight: bold;color: brown;border-radius: 5px 0px 0px 5px;text-align: center;" /><input type="text" readonly value="৳" style="width: 9%;height: 30px;font-size: 30px;font-weight: bold;color: brown;border-left: none;border-radius: 0 5px 5px 0px;" /></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">PAY NOW</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal16ghdj">
	<form id="form" class="stdform" method="post" action="PaymentOnline?gateway=bKash">
	<input type="hidden" name="wayyy" value="reseller" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Recharge by bKash</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;font-size: 19px;width: 40%;margin-left: 40px;padding: 8px 0;">Recharge Amount:</div>
						<div class="col-2"><input type="text" name="dewamount" required="" placeholder="2000" style="width: 40%;height: 30px;font-size: 25px;font-weight: bold;color: brown;border-radius: 5px 0px 0px 5px;text-align: center;" /><input type="text" name="" readonly value="৳" style="width: 9%;height: 30px;font-size: 30px;font-weight: bold;color: brown;border-left: none;border-radius: 0 5px 5px 0px;" /></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">PAY NOW</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal16ghdjjj">
	<form id="form" class="stdform" method="post" action="PaymentOnline?gateway=bKashT">
	<input type="hidden" name="wayyy" value="reseller" />
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="h5">Recharge by bKash</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="popdiv">
						<div class="col-1" style="font-weight: bold;font-size: 19px;width: 40%;margin-left: 40px;padding: 8px 0;">Recharge Amount:</div>
						<div class="col-2"><input type="text" name="dewamount" required="" placeholder="2000" style="width: 40%;height: 30px;font-size: 25px;font-weight: bold;color: brown;border-radius: 5px 0px 0px 5px;text-align: center;" /><input type="text" name="" readonly value="৳" style="width: 9%;height: 30px;font-size: 30px;font-weight: bold;color: brown;border-left: none;border-radius: 0 5px 5px 0px;" /></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="reset" class="btn ownbtn11">Reset</button>
				<button class="btn ownbtn2" type="submit">PAY NOW</button>
			</div>
		</div>
	</div>	
	</form>	
</div><!--#myModal-->
			
		<?php if(in_array(4, $online_getway)){?>
			<li class="right">
				<a href="#myModal16ghdjrk" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by Rocket'><img src="imgs/rocket_s.png" style="width: 20px;"></a>
			</li>
		<?php } if(in_array(2, $online_getway)){?>
			<li class="right">
				<a href="#myModaldrhdrj" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by iPay'><img src="imgs/ip_rbttn.png" style="width: 20px;"></a>
			</li>
		<?php } if(in_array(1, $online_getway)){?>
			<li class="right">
				<a href="#myModal16ghdj" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by bKash'><img src="imgs/bk_rbttn.png" style="width: 20px;"></a>
			</li>
		<?php } if(in_array(6, $online_getway)){?>
			<li class="right">
				<a href="#myModal16ghdjjj" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by bKash'><img src="imgs/bk_rbttn.png" style="width: 20px;"></a>
			</li>
		<?php } if(in_array(5, $online_getway)){?>
			<li class="right">
				<a href="#myModaldrhdrjnagad" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by Nagad'><img src="imgs/nagad_s1.png" style="width: 20px;"></a>
			</li>
		<?php } if(in_array(3, $online_getway)){?>
			<li class="right">
				<a href="#myModaldrhdrjcz" data-toggle="modal" data-placement='top' data-rel='tooltip' title='Recharge by SSLCOMZ'><img src="imgs/ssl.png" style="width: 20px;"></a>
			</li>
		<?php } ?>
			<li class="right">
				<a style="font-weight: bold;font-size: 12px;<?php echo $color; ?>">Balance: <?php echo number_format($aaaa,2);?>৳</a>
			</li>
			
<?php } if($userr_typ == 'admin' || $userr_typ == 'superadmin' || $userr_typ == 'billing_manager' || $userr_typ == 'accounts' || $userr_typ == 'mreseller' || $userr_typ == 'support' || $userr_typ == 'ets' || $userr_typ == 'support_manager'){ ?>
			<li class="right">
				<div class="input-prepend dropdown-toggle" data-toggle="dropdown" style="margin-right: -3px;">
					<input type="text" name="searchway" placeholder="Search" id="mainclientsearch" value="<?php echo (isset($_POST['ccccc_id']) ? $_POST['ccccc_id'] : '');?>" style="height: 19px;background: #dfdfdf;margin-top: -1px;font-size: 20px;width: 210px;">
				</div>
					<span class="add-on" style="height: 20px;background: #dfdfdf;margin-top: -1px;padding: 0;">
						<div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle searchstyle" style="" title="Search By"><?php if($search_way == 'c_id'){ echo 'ID';} elseif($search_way == 'com_id'){ echo 'COM';} elseif($search_way == 'c_name'){ echo 'NAME';}elseif($search_way == 'cell'){ echo 'CELL';} elseif($search_way == 'ip'){ echo 'IP';} else{?><i class="iconfa-search" style="font-size: 17px;"></i><?php } ?></button>
                            <ul class="dropdown-menu" style="min-width: 100px;border-radius: 0px 0px 5px 5px;text-align: left;">
								<li><a href="ActionAdd?typ=search&way=c_id&eid=<?php echo $e_id;?>" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #044a8e;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;border-top: 1px solid #80808040;text-shadow: none;" title="Search by Client ID">Client ID</a></li>
								<li><a href="ActionAdd?typ=search&way=com_id&eid=<?php echo $e_id;?>" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #7d3f87;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-shadow: none;" title="Search by Company ID">Com ID</a></li>
								<li><a href="ActionAdd?typ=search&way=c_name&eid=<?php echo $e_id;?>" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #1b9e77;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-shadow: none;" title="Search by Name">Name</a></li>
								<li><a href="ActionAdd?typ=search&way=cell&eid=<?php echo $e_id;?>" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #e12a17;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-shadow: none;" title="Search by Phone No">Cell No</a></li>
								<li><a href="ActionAdd?typ=search&way=ip&eid=<?php echo $e_id;?>" style="font-size: 14px;font-weight: bold;border-bottom: 1px solid #80808040;color: #4454ab;font-family: 'RobotoLight', 'Helvetica Neue', Helvetica, sans-serif;text-shadow: none;" title="Search by Phone No">IP Address</a></li>
                            </ul>
                        </div>
					</span>

                <ul class="dropdown-menu newusers pull-right" style='text-align: left;right: auto;'>
					<span id="searchresult">&nbsp;&nbsp;<?php if($search_way == 'c_id'){echo 'Search by Client ID';} elseif($search_way == 'com_id'){echo 'Search by Compnay ID';} elseif($search_way == 'c_name'){echo 'Search by Client Name';} elseif($search_way == 'cell'){echo 'Search by Client Cell No';} elseif($search_way == 'ip'){echo 'Search by IP Address';} else{echo 'Search by Client ID';}?></span>
				</ul>
            </li>
<?php  } else {} ?>
<?php if($userr_typ == 'superadmin' && $tisdueuu >= '1000' && $tis_api == '1' || $userr_typ == 'admin' && $tisdueuu >= '1000' && $tis_api == '1'){ ?>
			<li class="right" style="border: 0;margin-top: -5px;">
			   <marquee class="MyMarquee" id="my_marquee" direction="left" behavior="2" scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()">
			   <?php if(date('d') <= '10'){?>
					<div style="color: red;font-weight: bold;font-size: 17px;padding: 5px 0px;">Dear <?php echo $_SESSION['SESS_FIRST_NAME'];?>, Your TIS Total Due <?php echo $tisdueuu;?>TK. Without Payment The Application Will Terminate at 10th <?php echo date("F");?>, <?php echo date("Y");?> 23:59:00.</div>
			   <?php  } else { ?>
					<div style="color: red;font-weight: bold;font-size: 17px;padding: 5px 0px;">Dear <?php echo $_SESSION['SESS_FIRST_NAME'];?>, Your TIS Total Due <?php echo $tisdueuu;?>TK. Without Payment The Application Can Terminate Anytime.</div>
			    <?php  } ?>
			   </marquee>
            </li>
<?php  } ?>
        </ul>

<div class="maincontent">
            <div class="maincontentinner">