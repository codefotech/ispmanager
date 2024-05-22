<?php
ini_alter('date.timezone','Asia/Almaty');
extract($_POST);
include("conn/connection.php");
include("mk_api.php");

$API = new routeros_api();
$API->debug = false;
if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$arrID = $API->comm("/ppp/secret/getall", array(".proplist"=> ".id","?name" => $c_id,));
						 $API->comm("/ppp/secret/set", array(".id" => $arrID[0][".id"],"profile" => $mk_profile)); 
						 
				$arrID = $API->comm("/ppp/active/print", array(".proplist"=> ".id","?name" => $c_id,));
						 $API->comm("/ppp/active/remove", array(".id" => $arrID[0][".id"],));
		$API->disconnect();
			}
?>
<html>
	<body>
		<form action="PackageChange" method="post" name="ok">
			<input type="hidden" name="sts" value="done">
		</form>
		<script language="javascript" type="text/javascript">
			document.ok.submit();
		</script>
	</body>
</html>