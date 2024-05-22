<?php
include("conn/connection.php") ;
include("mk_api.php");
ini_alter('date.timezone','Asia/Almaty');
extract($_POST);

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
						array(".id" => $arrID[0][".id"],"profile" => $mk_profile));
				$API->disconnect();
?>
<html>
<body>
     <form action="NetworkPPPSecret?id=<?php echo $mk_id; ?>" method="post" name="ok">
       <input type="hidden" name="ccc_id" value="<?php echo $c_id; ?>">
       <input type="hidden" name="sts" value="UpdatePack">
     </form>

     <script language="javascript" type="text/javascript">
		document.ok.submit();
     </script>
</body>
</html>
<?php
			}
mysql_close($con);
?>