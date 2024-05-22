<?php 
session_start();
include("conn/connection.php");
include('include/telegramapi.php');
$user_type = $_SESSION['SESS_USER_TYPE'];
$user_name = $_SESSION['SESS_FIRST_NAME'];
$empid = $_SESSION['SESS_EMP_ID'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'AppSettings' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
	
ini_alter('date.timezone','Asia/Almaty');
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
$dirrr = 'Backup_Files';
foreach(glob($dirrr . '/*') as $fileee) { 
        if(is_dir($fileee)) rmdir($fileee); else unlink($fileee); 
        } rmdir($dirrr); 

$s1 = mysql_query('SELECT * FROM app_config');
$sw1 = mysql_fetch_assoc($s1);

$tis_id = $sw1['tis_id'];
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

$folder = 'Backup_Files/';

if (!is_dir($folder))
mkdir($folder, 0777, true);
chmod($folder, 0777);

$date = date('m-d-Y_h-i-s_'); 
$date1 = date('isyhds'); 
$filenameee = "db_backup_".$empid."_".$date.$tis_id;
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

if($tele_sts == '0'){
$telete_way = 'payment_add';
$msg_body='..::[Database Downloaded]::..
'.$user_name.' ['.$empid.']

Please Keep the Database Secure.
'.$tele_footer.'';

include('include/telegramapicore.php');
}


echo json_encode(array("file" => $file));
}
else{
	header("Location:index");
}
?>