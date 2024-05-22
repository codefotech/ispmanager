<?php
		include("conn/connection.php");

ini_alter('date.timezone','Asia/Almaty');
$today_noti_date = date('Y-m-d H:i:s', time());

		$e_id = $_GET['e_id'];
		$sqlmknot = mysql_query("SELECT id, user_type FROM login WHERE e_id = '$e_id'");
		$rownot = mysql_fetch_assoc($sqlmknot);
		$user_typenot = $rownot['user_type'];
		
		if($user_typenot == 'admin' || $user_typenot == 'superadmin'){
			$sqlnoo = mysql_query("SELECT id, e_id, object, c_id, date, time, date_time, icon, sts  FROM notification WHERE sts = '0' ORDER BY id DESC LIMIT 20");			
			
			$querynotecount = mysql_query("SELECT COUNT(id) AS totalnotef FROM notification WHERE sts = '0'");
			$rowiiicount = mysql_fetch_assoc($querynotecount);
			$totalbotcount = $rowiiicount['totalnotef'];
		}
		else{
			$sqlnoo = mysql_query("SELECT id, e_id, object, c_id, date, time, date_time, icon, sts  FROM notification WHERE sts = '0' AND e_id = '$e_id' ORDER BY id DESC LIMIT 20");
			$querynotecount = mysql_query("SELECT COUNT(id) AS totalnotef FROM notification WHERE sts = '0' AND e_id = '$e_id'");
			$rowiiicount = mysql_fetch_assoc($querynotecount);
			$totalbotcount = $rowiiicount['totalnotef'];
		}
?>
<a href="" data-toggle="dropdown" class="dropdown-toggle"><i class="iconfa-bell" style="font-size: 15px;"></i><span class="count" style="font-weight: bold;color: black;"><?php echo $totalbotcount;?></span></a>
<ul class="dropdown-menu pull-right" style="overflow-y: scroll;height: 400px;">
<li class="nav-header" style="text-align: left;">Notifications</li>
<?php
		while( $rownoo = mysql_fetch_assoc($sqlnoo) )
										{
												$datetime1 = strtotime($today_noti_date);
												$datetime2 = strtotime($rownoo['date_time']);
												$interval  = abs($datetime2 - $datetime1);
												$minutes   = round($interval / 60);
											echo
												"<li style='text-align: left;'><a href=''><span class='{$rownoo['icon']}' style='padding-right: 5px;'></span><strong>{$rownoo['object']} </strong><small class='muted'> - {$minutes} minutes ago</small></a></li>\n";
										}
?>
</ul>