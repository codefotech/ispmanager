<?php 
include("conn/backup_conn.php");
//include('company_info.php');
require 'email/PHPMailerAutoload.php';
ini_alter('date.timezone','Asia/Almaty');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$dirrr = 'Backup_Files';
foreach(glob($dirrr . '/*') as $fileee) { 
        if(is_dir($fileee)) rmdir($fileee); else unlink($fileee); 
        } rmdir($dirrr); 

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
$mailaddess = $OwnerEmail;

preg_match_all('/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/i', $OwnerEmail, $matches);

$backup_db = 'active';
include("conn/backup_conn.php");
$date_time = date("Y-m-d h:ia");

$without_tables = array("app_config","app_search","log_info","emp_log","department_info","mac_device","realtime_speed","sms_send","billing_mac_archive","client_bandwidth","districts","divisions","login_cookie","mk_active_count","network_sync_log","payment_online_setup","unions","upazilas"); //here your tables...

$tables = array();
$query = mysqli_query($con, 'SHOW TABLES');
while($row = mysqli_fetch_row($query)){
    if (!in_array($row[0], $without_tables)){
        $tables[] = $row[0];
    }
}
$result = "";
foreach($tables as $table){
$query = mysqli_query($con, 'SELECT * FROM '.$table);
$num_fields = mysqli_num_fields($query);

$result .= 'DROP TABLE IF EXISTS '.$table.';';
$row2 = mysqli_fetch_row(mysqli_query($con, 'SHOW CREATE TABLE '.$table));
$result .= "\n\n".$row2[1].";\n\n";

for ($i = 0; $i < $num_fields; $i++) {
while($row = mysqli_fetch_row($query)){
   $result .= 'INSERT INTO '.$table.' VALUES(';
     for($j=0; $j<$num_fields; $j++){
       $row[$j] = addslashes($row[$j]);
       $row[$j] = str_replace("\n","\\n",$row[$j]);
       if(isset($row[$j])){
		   $result .= '"'.$row[$j].'"' ; 
		}else{ 
			$result .= '""';
		}
		if($j<($num_fields-1)){ 
			$result .= ',';
		}
    }
   	$result .= ");\n";
}
}
$result .="\n\n";
}

//Create Folder
$folder = 'Backup_Files/';

if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('m-d-Y_h-i-s_'); 
$date1 = date('isyhds'); 
$filenameee = "db_backup_".$date.$tis_id;
$filename = $folder.$filenameee; 

$handle = fopen($filename.'.sql','w+');
fwrite($handle,$result);
fclose($handle);

$zip = new ZipArchive;
if ($zip->open($filename.'.zip', ZipArchive::CREATE) === TRUE)
{
    $zip->addFile($filename.'.sql');
    $zip->close();
}

$file = $filename.'.zip';
$content = file_get_contents($file);
$content = chunk_split(base64_encode($content));
$uid = md5(uniqid(time()));
$name = basename($file); 
 
$mail = new PHPMailer();
$address = array($OwnerEmail);
try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP(true);
    $mail->Host       = 'smtp.gmail.com';
    $mail->Username   = '01732197767s@gmail.com';
    $mail->Password   = 'hzdtuyfiatqhjggd';
    $mail->Port       = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
    $mail->setFrom('01732197767s@gmail.com', 'Billing || Backup');

	foreach(array_unique($matches[0]) as $email) {
		$mail->AddAddress("$email", "$CompanyOwner ($CompanyName)");
	}
    $mail->addReplyTo('swapon9124@gmail.com', 'SWAPON (Bapa Com)'); 

    $mail->addAttachment($file);         

	$mail->isHTML(true);                                  
    $mail->Subject = ''.$CompanyName.' || Billing || DB Backup  || '.$date_time.'';

	$mail->Body = "<html>
					<head>
					<title>TIS Backup</title>
					</head>
					<body> 	
					<p>
						<span style='font-family: georgia, palatino; font-size: large;'><strong>Dear ".$CompanyOwner.",</strong></span>
							<br />
						<span style='font-family: georgia, palatino; font-size: large;'>Please find your application <span style='color: #ff0000;'><strong>Database Last Backup as ZIP</strong></span> where we attached.</span>
							<br /><br />
						<span style='font-family: georgia, palatino; font-size: large;'>This backup was taken at ".$date_time.".</span>
							<br />
						<span style='font-family: georgia, palatino; font-size: large;'>Please <strong><span style='color: #ff0000;'>Keep it Safe</span></strong> for future inquiry.</span>
					</p>
					<br /><br />
					<span style='font-family: georgia, palatino; font-size: large;'>Thanks</span>
					<br />
					<span style='font-family: georgia, palatino; font-size: large;'>Sabbir Ahammed</span>
					<br />
					<span style='font-family: georgia, palatino; font-size: large;'>01717561922</span>
					</body>
					</html>";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Backup has been sent to '.$OwnerEmail.'. Please keep it safe.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

unlink('error_log');
foreach(glob($dirrr . '/*') as $fileee) { 
        if(is_dir($fileee)) rmdir($fileee); else unlink($fileee); 
        } rmdir($dirrr);
?>
<br>
<button onclick="history.back()">Go Back</button>