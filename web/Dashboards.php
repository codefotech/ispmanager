<?php
$titel = "Dashboard";
$Dashboards = 'active';
include('include/hader.php');

//---------- Permission -----------
$user_type = $_SESSION['SESS_USER_TYPE'];
$access = mysql_query("SELECT * FROM module WHERE module_name = 'Dashboards' AND $user_type = '1'");
if(mysql_num_rows($access) > 0){
//---------- Permission -----------

?>

<?php
}
else{
	include('include/index');
}
include('include/footer.php');
?>