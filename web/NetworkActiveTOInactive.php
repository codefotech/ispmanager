<?php
session_start();
include("conn/connection.php");
include("mk_api.php");
$c_id = $_GET['id'];
$e_id = $_SESSION['SESS_EMP_ID'];
ini_alter('date.timezone','Asia/Almaty');
$update_date = date('Y-m-d', time());
$update_time = date('H:i:s', time());
$todayy = date('d', time()); //17
$lastdayofthismonth = date('t'); //31

$que = mysql_query("SELECT c.con_sts, c.mk_id, c.p_id, c.mac_user, p.p_price FROM clients as c LEFT JOIN package as p ON p.p_id = c.p_id WHERE c.c_id = '$c_id'");
$row = mysql_fetch_assoc($que);
$a = $row['con_sts'];
$pidd = $row['p_id'];
$pprice = $row['p_price'];
$macuser = $row['mac_user'];
$mk_id = $row['mk_id'];

$sqlmk = mysql_query("SELECT id, ServerIP, Username, Pass, Port, e_Md, secret_h FROM mk_con WHERE sts = '0' AND id = '$mk_id'");
$rowmk = mysql_fetch_assoc($sqlmk);
$ServerIP = $rowmk['ServerIP'];
$Username = $rowmk['Username'];
$Pass= openssl_decrypt($rowmk['Pass'], $rowmk['e_Md'], $rowmk['secret_h']);
$Port = $rowmk['Port'];

			$API = new routeros_api();
			$API->debug = false;
			if ($API->connect($ServerIP, $Username, $Pass, $Port)) {
				$arrID = $API->comm("/ppp/secret/getall", 
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/secret/set",
						array(".id" => $arrID[0][".id"],"disabled"  => "yes",));
						
				$arrID = $API->comm("/ppp/active/print",
						  array(".proplist"=> ".id","?name" => $c_id,));

						$API->comm("/ppp/active/remove",
						array(".id" => $arrID[0][".id"],));
					?>
			<html>
				<body>
				<form action="NetworkActiveConniction?id=<?php echo $mk_id;?>" method="post" name="ok">
					<input type="hidden" name="sts" value="inactive">
					<input type="hidden" name="ccc_id" value="<?php echo $c_id;?>">
				</form>
				<script language="javascript" type="text/javascript">
					document.ok.submit();
				</script>
				</body>
			</html>
			
		<?php
		$API->disconnect();
		}
			else{ echo "Error!! No Connected Network Found.";}
		mysql_close($con); ?>