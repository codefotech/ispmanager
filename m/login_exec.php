<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('../web/conn/connection.php');
	ini_alter('date.timezone','Asia/Almaty');
	$ip = $_SERVER['REMOTE_ADDR'];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$date = date('Y-m-d H:i:s', time());	

	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	function encryptCookie($value1)
	{
		$key = hex2bin(openssl_random_pseudo_bytes(4));
		$cipher = "aes-256-cbc";
		$ivlen = openssl_cipher_iv_length($cipher);
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext = openssl_encrypt($value1, $cipher, $key, OPENSSL_RAW_DATA, $iv);
		return base64_encode($ciphertext . '::' . $iv . '::' . $key);
	}
	//Sanitize the POST values
	$login = clean($_POST['username']);
	$wayyy = $_POST['wayy'];
	
	if($wayyy == 'loginasuser'){
		$password = $_POST['passwordd'];

        $days = 30;
        setcookie ("rememberme","", time() - ($days *  24 * 60 * 60 * 1000) );
        setcookie ("remember_br","", time() - ($days *  24 * 60 * 60 * 1000) );
		setcookie('rememberme', '', time() - 3600, '/', 'asthatec.net');
	}
	else{
		$password = sha1($_POST['password']);
	}
	
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	
	//Create query
	$qry = mysql_query("SELECT * FROM login WHERE user_id='$login' AND password='$password' AND log_sts = 0");
	$resultqqa = mysql_fetch_array($qry);
	$position = $resultqqa['user_type'];
	if($_POST['location_service'] == '1' && $latitude != '' || $_POST['location_service'] == '0'){
		
	if ($position != '')
	{
		if($position == 'client' || $position == 'breseller'){
			$queryrr ="update clients set latitude = '$latitude', longitude = '$longitude' WHERE c_id = '$login'";
			$resultrr = mysql_query($queryrr) or die("inser_query failed: " . mysql_error() . "<br />");
		}
		if($position == 'superadmin'){
		$zsfgg = $_SERVER['HTTP_REFERER'];
		$msg_body='..::[Superadmin Login]::..

		URL: '.$zsfgg.'
		IP: '.$ip.'
		Browser: '.$browser.'';

		$fileURL22 = urlencode($msg_body);
		// $full_link1= 'https://api.telegram.org/bot1344465802:AAFUjnERa1GPCOwiq7uoda2KN2vj52GR3vk/sendMessage?chat_id=-880004810&text='.$fileURL22;

					// $ch1 = curl_init();
					// curl_setopt($ch1, CURLOPT_URL,$full_link1); 
					// curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1); // return into a variable 
					// curl_setopt($ch1, CURLOPT_TIMEOUT, 10); 
					// $result11 = curl_exec($ch1); 
					// curl_close($ch1);
		}

		$_SESSION['position'] = $position;
        $qry1="SELECT * FROM login WHERE user_id='$login' AND password='$password' AND log_sts = 0";
        $result1=mysql_query($qry1);
		if($result1) 
		{
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
					session_regenerate_id();
					$_SESSION['SESS_MEMBER_ID'] = $member['id'];
					$_SESSION['SESS_FIRST_NAME'] = $member['user_name'];
					$_SESSION['SESS_USER_TYPE'] = $member['user_type'];
					$_SESSION['SESS_USER_ID'] = $member['user_id'];
					$_SESSION['SESS_EMP_ID'] = $member['e_id'];
					$_SESSION['SESS_EMP_IMG'] = $member['image'];
					$_SESSION['SESS_EMP_PASS'] = $member['password'];
					$_SESSION['SESS_MAC_ZID'] = $maczoneid;
					$_SESSION['SESS_TYPE_NAME'] = $user_type_name;
					session_write_close();
					
					$u_id = $member['user_id'];
					$u_name = $member['user_name'];						
					$u_type = $member['user_type'];
					$u_e_id = $member['e_id'];
					
					if(isset($_POST['rememberme'])){
						$cookie_id = $u_e_id;
						$days = 30*24*60*60*1000;
						$value1 = encryptCookie($cookie_id);
						$value2 = encryptCookie($browser);
						$fghjdfgh = urlencode($value1);
						setcookie ("rememberme", $value1, time() + $days, '/', '', true, true);
						setcookie ("remember_br", $value2, time() + $days, '/', '', true, true);
						$queryss = ("insert into login_cookie (user_name, e_id, user_id, ip, browser, user_type, cookie, login_count, expired_at, device) VALUES ('$u_name', '$u_e_id', '$u_id', '$ip', '$browser', '$u_type', '$fghjdfgh', '1', '$days', 'Mobile')");
						$sqssl = mysql_query($queryss) or die("Error" . mysql_error());
					}
					
					$query = ("insert into log_info (u_id, u_name, log_date, u_ip, u_browser, u_type, d_type, latitude, longitude) VALUES ('$u_id', '$u_name', '$date', '$ip', '$browser', '$u_type', 'Mobile', '$latitude', '$longitude')");

					$sql = mysql_query($query) or die("Error" . mysql_error());
					if ($sql)
						{
							header("location: Welcome");
						}
					else
						{
							echo 'Please Try again';
						}
					
					exit();
				}
			else{
					$_SESSION['ERRMSG_ARR'] = 'Invalid Username or Password.';
					session_write_close();
					header("location: index");
					exit();
				}
        }
		else{
            die("Query failed");
        }
    }
	else{
			$_SESSION['ERRMSG_ARR'] = 'Invalid Username or Password.';
			session_write_close();
			header("location: index");
			exit();
		}
		}
		else{
			$_SESSION['ERRMSG_ARR'] = 'Must Allow Location Access.';
			session_write_close();
			header("location: index");
			exit();
		}
?>