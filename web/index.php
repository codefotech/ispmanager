<?php
	session_start();
include("conn/connection.php");
include('company_info.php');

	$browser = $_SERVER['HTTP_USER_AGENT'];
	
	function decryptCookie($ciphertext){
	   $cipher = "aes-256-cbc";
	   list($encrypted_data,$iv,$key) = explode('::',base64_decode($ciphertext));
	   return openssl_decrypt($encrypted_data,$cipher,$key,0,$iv);
	}
	
if(isset($_GET['way']) == 'logout'){

        session_unset();

		// destroy the session
		session_destroy();

        // Remove cookie variables
		if(isset($_COOKIE['rememberme'])){
			$raw_cookies = urlencode($_COOKIE['rememberme']);
		//	$querygg=mysql_query("UPDATE login_cookie SET sts = '1' WHERE cookie = '$raw_cookies'");
		}
		
        $days = 30;
        setcookie ("rememberme","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remember_br","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remembermep","", time() - ($days *  24 * 60 * 60 * 1000) );
}

//$s1 = mysql_query('SELECT * FROM app_config');
//$sw1 = mysql_fetch_assoc($s1);

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
$Company_location_service = $sw1['location_service'];
$CompanyCurrency = $sw1['currency'];
$CompanyLogo = $sw1['logo'];
$mailaddess = $OwnerEmail.','.$OwnerEmail2;
if(1 == 1){

if(isset($_COOKIE['rememberme']) && isset($_COOKIE['remember_br'])){
	$raw_cookie = urlencode($_COOKIE['rememberme']);
	
//	$userid = decryptCookie($_COOKIE['rememberme']);
//	$remember_br = decryptCookie($_COOKIE['remember_br']);
	
//	$qry = mysql_query("SELECT * FROM login_cookie WHERE cookie = '$raw_cookie' AND sts = '0'");
//	$memb = mysql_fetch_assoc($qry);
	$cookie = $memb['cookie'];
	$cookiebr = $memb['browser'];
	$cookielast_page = $memb['last_page'];
	$user_id = $memb['user_id'];
	$login_count = $memb['login_count']+1;
	
	if($cookie != '' && $browser == $cookiebr){
	$qry1="SELECT * FROM login WHERE user_id = '$user_id' AND log_sts = '0'";
    $result1=mysql_query($qry1);
		if(mysql_num_rows($result1) > 0) {
		$member = mysql_fetch_assoc($result1);
		
		$usertypeee = $member['user_type'];
		$userrrr_id = $member['e_id'];
					
					if($usertypeee == 'mreseller'){
							$sss1 = mysql_query("SELECT z_id FROM zone WHERE e_id ='$userrrr_id'");
							$sssw1 = mysql_fetch_assoc($sss1);
								$maczoneid = $sssw1['z_id'];
						}
					if($usertypeee == 'superadmin'){
						$user_type_name = 'superadmin';
					}
					else{
					$sss1m = mysql_query("SELECT u_des FROM user_typ WHERE u_type = '$usertypeee'");
					$sssw1m = mysql_fetch_assoc($sss1m);
					$user_type_name = $sssw1m['u_des'];
					}
					
			$_SESSION['SESS_MEMBER_ID'] = $member['id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['user_name'];
			$_SESSION['SESS_USER_TYPE'] = $member['user_type'];
			$_SESSION['position'] = $member['user_type'];
			$_SESSION['SESS_USER_ID'] = $member['user_id'];
			$_SESSION['SESS_EMP_ID'] = $member['e_id'];
			$_SESSION['SESS_EMP_IMG'] = $member['image'];
			$_SESSION['SESS_MAC_ZID'] = $maczoneid;
			$_SESSION['SESS_TYPE_NAME'] = $user_type_name;
			
		//	$query=mysql_query("UPDATE login_cookie SET login_count = '$login_count' WHERE cookie = '$raw_cookie'");
			if($cookielast_page != ''){
				header('Location: '.$cookielast_page);
			}
			else{
				header('Location: welcome');
			}
		   exit;
		}
	}
	else{
		session_unset();

		// destroy the session
		session_destroy();

        // Remove cookie variables
        $days = 30;
        setcookie ("rememberme","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remember_br","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remembermep","", time() - ($days *  24 * 60 * 60 * 1000) );
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $CompanyName; ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" type="text/css" />
<link rel="icon" type="images/png" href="images/favicon.png"/>
<style></style>
</head>
   <body>
      <div class="content"> 
         <div class="text">
         </div>
		 <?php if(isset($_SESSION['ERRMSG_ARR']) != ''){ ?>
			<a style="color: red;"><?php echo $_SESSION['ERRMSG_ARR'];?></a>
		<?php } ?>
         <form id="login" action="login_exec" method="post">
		 <input type="hidden" name="location_service" value="<?php echo $Company_location_service;?>"/>
         <p id="location"></p>
			<div class="field"> 
               <input type="text" name="username" placeholder="Username" id="login" required>
               <span class="fas fa-user"></span>
          
            </div>
            <div class="field" style="margin-top:20px">
               <input type="password" name="password" placeholder="Password" id="password" required>
               <span class="fas fa-lock"></span>
              
            </div>
            <div class="forgot-pass">
              <label class="switch">
                 <input type="checkbox" name="rememberme">
                <span class="slider round"></span>
              </label>
               <label style="position: relative;color: #666666;left: 5%;transform: translateY(-50%);vertical-align: middle;top: 10%;">Remember Me</label>
            </div>
            <button>LOGIN</button>
            
<!--		<div class="login-footer" style="border-top: 1px solid #80808063;border-radius: 0 0 5px 5px;font-size: 9px;color: #595959;">
			<?php echo $footer; ?>
		</div>--->
         </form>
      </div>
   </body>
</html>

<?php } else{
        session_unset();
		session_destroy();
        // Remove cookie variables
        $days = 30;
        setcookie ("rememberme","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remember_br","", time() - ($days *  24 * 60 * 60 * 1000) );
		setcookie('rememberme', '', time() - 3600, '/', 'asthatec.net');


$ip = getenv(REMOTE_ADDR);
$browser = $_SERVER['HTTP_USER_AGENT'];

 $json  = file_get_contents("http://ipinfo.io/$ip/geo");
 $json  =  json_decode($json ,true);
 $country =  $json['country'];
 $region= $json['region'];
 $city = $json['city'];
 $glat = $json['loc'];
 $postal = $json['postal'];

$msg_body='..::[Terminated Account]::..

ISP: '.$CompanyName.'
Device: WEB
IP: '.$ip.'
Area: '.$country.' '.$region.' '.$city.' '.$postal.'
G-Area: '.$glat.'';

// $fileURL22 = urlencode($msg_body);
// $full_link1= 'https://api.telegram.org/bot1344465802:AAFUjnERa1GPCOwiq7uoda2KN2vj52GR3vk/sendMessage?chat_id=-880004810&text='.$fileURL22;

			// $ch1 = curl_init();
			// curl_setopt($ch1, CURLOPT_URL,$full_link1); 
			// curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
			// curl_setopt($ch1, CURLOPT_TIMEOUT, 10); 
			// $result11 = curl_exec($ch1); 
			// curl_close($ch1);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $CompanyName; ?></title>
<link rel="icon" type="images/png" href="images/favicon.png"/>
</head>
<body style="height: unset;">

</html>

<?php } ?>
<style>

@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
  margin: 0;
  padding: 0;
  /* user-select: none; */
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}
html,body{
  height: 100%;
}
body{
  display: grid;
  background: url("imgs/imagebg.jpg") repeat;
    background-repeat: no-repeat;
  background-size: cover;
  place-items: center;
  text-align: center;
}
.content{
  width: 330px;
  padding: 25px 30px 20px 30px;
  background: #ffffffe8;
  border-radius: 10px;
  box-shadow: -3px -3px 7px #ffffff73,
               2px 2px 5px rgba(94,104,121,0.288);
}
.content .text{
  font-weight: 600;
  margin-bottom: 35px;
  color: #595959;
}
.field{
  height: 50px;
  width: 100%;
  display: flex;
  position: relative;
}
.field:nth-child(2){
  margin-top: 20px;
}
.field input{
  height: 100%;
  width: 100%;
  padding-left: 45px;
  outline: none;
  border: none;
  font-size: 18px;
  background: #dde1e7;
  color: #595959;
  border-radius: 10px;
  box-shadow: inset 2px 2px 5px #BABECC,
              inset -5px -5px 10px #ffffff73;
}
.field input:focus{
  box-shadow: inset 1px 1px 2px #BABECC,
              inset -1px -1px 2px #ffffff73;
}
.field span{
  position: absolute;
  color: #595959;
  width: 50px;
  line-height: 50px;
}
.field label{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  left: 45px;
  pointer-events: none;
  color: #666666;
}
.field input:valid ~ label{
  opacity: 0;
}
.forgot-pass{
  text-align: left;
  margin: 10px 0 10px 5px;
}
.forgot-pass a{
  font-size: 16px;
  color: #3498db;
  text-decoration: none;
}
.forgot-pass:hover a{
  text-decoration: underline;
}
button{
  margin: 15px 0;
  width: 100%;
  height: 50px;
  font-size: 18px;
  line-height: 50px;
  font-weight: 600;
  background: #dde1e7;
  border-radius: 10px;
  border: none;
  outline: none;
  cursor: pointer;
  color: #595959;
  box-shadow: 2px 2px 5px #BABECC,
             -5px -5px 10px #ffffff73;
}
button:focus{
  color: #3498db;
  box-shadow: inset 2px 2px 5px #BABECC,
             inset -5px -5px 10px #ffffff73;
}
.sign-up{
  margin: 10px 0;
  color: #595959;
  font-size: 16px;
}
.sign-up a{
  color: #3498db;
  text-decoration: none;
}
.sign-up a:hover{
  text-decoration: underline;
}

 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} 
</style>
