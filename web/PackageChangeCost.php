<?php
include("conn/connection.php") ;
ini_alter('date.timezone','Asia/Almaty');
$dateTimeee = date('Y-m-d', time());
$pid = $_GET['p_id'];

//$c_id = 'tal_abir@salauddincybernet';
$c_id = $_GET['c_id'];

$que = mysql_query("SELECT c.c_id, c.com_id, c.c_name, c.termination_date, c.ip, p.bandwith, c.mac, c.breseller, c.cell, c.mac_user, c.mk_id, c.raw_download, c.raw_upload , c.youtube_bandwidth, c.total_bandwidth, c.bandwidth_price, c.youtube_price, c.discount, c.total_price, c.address, c.p_id, p.p_name, p.p_price FROM clients AS c LEFT JOIN package AS p ON p.p_id = c.p_id WHERE c.c_id = '$c_id'");
$rowsu = mysql_fetch_assoc($que);
$ppp_id = $rowsu['p_id'];
$ppricee = $rowsu['p_price'];

$diff = abs(strtotime($rowsu['termination_date']) - strtotime($dateTimeee))/86400;
$onedayprice = $ppricee/30;
$alreadypaid = $diff * $onedayprice;


$queee=mysql_query("SELECT p_id, p_name, p_price, bandwith FROM package WHERE p_id ='$pid'");
$rowsueee = mysql_fetch_assoc($queee);
$pprice = $rowsueee['p_price'];
$onedaypriceee = $pprice/30;
$newpacgcost = $diff * $onedaypriceee;
$newcost = $newpacgcost - $alreadypaid;

echo '|| Cost '.number_format($newcost,2).'  ৳';


?>