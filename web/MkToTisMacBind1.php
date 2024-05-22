<?php
include("conn/connection.php");
include("mk_api.php");
extract($_POST);


		if($bind == 'Yes'){
		$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		
		$API = new routeros_api();
		$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			   $arrID =	$API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"caller-id" => $mkmac));
				$API->disconnect();
				
			$query1 = "UPDATE clients SET mac = '$mkmac' WHERE c_id = '$c_id'";
			$result = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

?>
<html>
<body>
     <form action=<?php if($wayyy == 'clientview'){ ?> "ClientView" <?php } else{ ?>"NetworkActiveConniction?id=<?php echo $mk_id; ?>"<?php } ?> method="post" name="ok">
       <input type="hidden" name="ccc_id" value="<?php echo $c_id; ?>">
	   <input type="hidden" name="ids" value="<?php echo $c_id; ?>">
       <input type="hidden" name="sts" value="macadd<?php echo $bind;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>


<?php
		}
		else{ echo "Error!! No Connected Network Found.";}
		}
		else{
		$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
		$rowmk = mysql_fetch_assoc($sqlmk);
		
		$ServerIP = $rowmk['ServerIP'];
		$Username = $rowmk['Username'];
		$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
		$Port = $rowmk['Port'];
		
		$API = new routeros_api();
		$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
			   $arrID =	$API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"caller-id" => $mkmac));
				$API->disconnect();
				
			$query1 = "UPDATE clients SET mac = '$mkmac' WHERE c_id = '$c_id'";
			$result = mysql_query($query1) or die("inser_query failed: " . mysql_error() . "<br />");

?>
<html>
<body>
     <form action=<?php if($wayyy == 'ppp'){?>"NetworkPPPSecret?id=<?php echo $mk_id;?>"<?php } elseif($wayyy == 'clientview'){ ?>"ClientView"<?php } else{ ?>"NetworkActiveConniction?id=<?php echo $mk_id;?>"<?php } ?> method="post" name="ok">
       <input type="hidden" name="ccc_id" value="<?php echo $c_id; ?>">
       <input type="hidden" name="ids" value="<?php echo $c_id; ?>">
       <input type="hidden" name="sts" value="macadd<?php echo $bind;?>">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>


<?php
					}
		else{ echo "Error!! No Connected Network Found.";}
		
		}

?>