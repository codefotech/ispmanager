<?php
include("conn/connection.php");
include("mk_api.php");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");
extract($_POST);
 if($mk_id != '')
 {
							if(empty($_POST['mk_profile1']) || empty($_POST['p_name1']) || empty($_POST['bandwith1']) || empty($_POST['p_price1'])){}
							else{
								$sql_cus1 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus1 = mysql_fetch_array($sql_cus1);
								$p_id1 = $row_cus1['p_id']+1;
								
								$query11 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id1', '$mk_profile1', '$p_name1', '$p_price1', '$bandwith1', '$z_id', '$mk_id')";
								$result11 = mysql_query($query11) or die("inser_query failed: " . mysql_error() . "<br />");
								}
								
							if(empty($_POST['mk_profile2']) || empty($_POST['p_name2']) || empty($_POST['bandwith2']) || empty($_POST['p_price2'])){}
							else{
								$sql_cus2 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus2 = mysql_fetch_array($sql_cus2);
								$p_id2 = $row_cus2['p_id']+1;
								
								$query12 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id2', '$mk_profile2', '$p_name2', '$p_price2', '$bandwith2', '$z_id', '$mk_id')";
								$result12 = mysql_query($query12) or die("inser_query failed: " . mysql_error() . "<br />");
								}
								
							if(empty($_POST['mk_profile3']) || empty($_POST['p_name3']) || empty($_POST['bandwith3']) || empty($_POST['p_price3'])){}
							else{
								$sql_cus3 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus3 = mysql_fetch_array($sql_cus3);
								$p_id3 = $row_cus3['p_id']+1;
								
								$query13 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id3', '$mk_profile3', '$p_name3', '$p_price3', '$bandwith3', '$z_id', '$mk_id')";
								$result13 = mysql_query($query13) or die("inser_query failed: " . mysql_error() . "<br />");
								}
								
							if(empty($_POST['mk_profile4']) || empty($_POST['p_name4']) || empty($_POST['bandwith4']) || empty($_POST['p_price4'])){}
							else{
								$sql_cus4 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus4 = mysql_fetch_array($sql_cus4);
								$p_id4 = $row_cus4['p_id']+1;
								
								$query14 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id4', '$mk_profile4', '$p_name4', '$p_price4', '$bandwith4', '$z_id', '$mk_id')";
								$result14 = mysql_query($query14) or die("inser_query failed: " . mysql_error() . "<br />");
								}
								
							if(empty($_POST['mk_profile5']) || empty($_POST['p_name5']) || empty($_POST['bandwith5']) || empty($_POST['p_price5'])){}
							else{
								$sql_cus5 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus5 = mysql_fetch_array($sql_cus5);
								$p_id5 = $row_cus5['p_id']+1;
								
								$query15 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id5', '$mk_profile5', '$p_name5', '$p_price5', '$bandwith5', '$z_id', '$mk_id')";
								$result15 = mysql_query($query15) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							if(empty($_POST['mk_profile6']) || empty($_POST['p_name6']) || empty($_POST['bandwith6']) || empty($_POST['p_price6'])){}
							else{
								$sql_cus6 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus6 = mysql_fetch_array($sql_cus6);
								$p_id6 = $row_cus6['p_id']+1;
								
								$query16 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id6', '$mk_profile6', '$p_name6', '$p_price6', '$bandwith6', '$z_id', '$mk_id')";
								$result16 = mysql_query($query16) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							if(empty($_POST['mk_profile7']) || empty($_POST['p_name7']) || empty($_POST['bandwith7']) || empty($_POST['p_price7'])){}
							else{
								$sql_cus7 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus7 = mysql_fetch_array($sql_cus7);
								$p_id7 = $row_cus7['p_id']+1;
								
								$query17 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id7', '$mk_profile7', '$p_name7', '$p_price7', '$bandwith7', '$z_id', '$mk_id')";
								$result17 = mysql_query($query17) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							if(empty($_POST['mk_profile8']) || empty($_POST['p_name8']) || empty($_POST['bandwith8']) || empty($_POST['p_price8'])){}
							else{
								$sql_cus8 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus8 = mysql_fetch_array($sql_cus8);
								$p_id8 = $row_cus8['p_id']+1;
								
								$query18 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id8', '$mk_profile8', '$p_name8', '$p_price8', '$bandwith8', '$z_id', '$mk_id')";
								$result18 = mysql_query($query18) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							if(empty($_POST['mk_profile9']) || empty($_POST['p_name9']) || empty($_POST['bandwith9']) || empty($_POST['p_price9'])){}
							else{
								$sql_cus9 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus9 = mysql_fetch_array($sql_cus9);
								$p_id9 = $row_cus9['p_id']+1;
								
								$query19 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id9', '$mk_profile9', '$p_name9', '$p_price9', '$bandwith9', '$z_id', '$mk_id')";
								$result19 = mysql_query($query19) or die("inser_query failed: " . mysql_error() . "<br />");
								}
							if(empty($_POST['mk_profile10']) || empty($_POST['p_name10']) || empty($_POST['bandwith10']) || empty($_POST['p_price10'])){}
							else{
								$sql_cus10 = mysql_query("SELECT p_id FROM package ORDER BY p_id DESC LIMIT 1");
								$row_cus10 = mysql_fetch_array($sql_cus10);
								$p_id10 = $row_cus10['p_id']+1;
								
								$query110 ="insert into package (p_id, mk_profile, p_name, p_price, bandwith, z_id, mk_id) VALUES ('$p_id10', '$mk_profile10', '$p_name10', '$p_price10', '$bandwith10', '$z_id', '$mk_id')";
								$result110 = mysql_query($query110) or die("inser_query failed: " . mysql_error() . "<br />");
								}
?>
<html>
<body>
<form action="Package" method="post" name="ok">
	<input type="hidden" name="sts" value="add">
</form>
<script language="javascript" type="text/javascript">
		document.ok.submit();
</script>
</body>
</html>
<?php } else{echo 'Wrong Data Inserted.';}?>