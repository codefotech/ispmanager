<?php
//echo date("Y-m-d H:i:s");

date_default_timezone_set('Etc/GMT-6');
$date = date('Y-m-d h:i:s a', time());
echo $date;
?>
