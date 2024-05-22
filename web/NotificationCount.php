<?php
		include("conn/connection.php");

ini_alter('date.timezone','Asia/Almaty');
$today_noti_date = date('Y-m-d H:i:s', time());

		$e_id = $_GET['e_id'];
		$sqlmknot = mysql_query("SELECT id, user_type FROM login WHERE e_id = '$e_id'");
		$rownot = mysql_fetch_assoc($sqlmknot);
		$user_typenot = $rownot['user_type'];
		
		if($user_typenot == 'admin' || $user_typenot == 'superadmin'){
			
			$querynotecount = mysql_query("SELECT id, object, date, time, date_time, icon FROM notification WHERE sts = '0'");
			$rowiiicount = mysql_fetch_assoc($querynotecount);
			$objectnow = $rowiiicount['object'];
			$id_now = $rowiiicount['id'];
		}
		else{
			$querynotecount = mysql_query("SELECT id, object, date, time, date_time, icon FROM notification WHERE sts = '0' AND e_id = '$e_id'");
			$rowiiicount = mysql_fetch_assoc($querynotecount);
			$objectnow = $rowiiicount['object'];
			$id_now = $rowiiicount['id'];
		}
	if($id_now == ''){}
	else{
?>
<script>
jQuery(document).ready(function(){
if(jQuery('#growl20').length > 0) {
		jQuery('#growl20').click(function(){
			var msg = "<?php echo $objectnow;?>";
			jQuery.jGrowl(msg, { life: 5000});
		});
	}
});
</script>
	<?php } ?>